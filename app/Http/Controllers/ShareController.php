<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{

    // Retrieve shares where the authenticated user is the owner
    public function shared()
    {
        $shared = Share::with('file')
            ->where('owner_email', Auth::user()->email)
            ->whereHas('file', function ($query) {
                $query->whereNull('deleted_at'); // Filter out deleted files
            })
            ->get();

        // Remove any shares associated with soft-deleted files
        $this->cleanUpDeletedShares();

        return view('shared', ['shared' => $shared]);
    }

    // Retrieve shares where the authenticated user is the recipient
    public function sharedWithMe()
    {
        // Get the authenticated user's email
        $userEmail = Auth::user()->email;

        // Query to fetch files shared with the current user
        $sharedFiles = DB::table('shares')
            ->join('files', 'shares.file_id', '=', 'files.id')
            ->where('shares.recipient_email', $userEmail)
            ->whereNull('files.deleted_at')
            ->select('files.*', 'shares.created_at', 'shares.id as share_id', 'shares.owner_email as owner_email')
            ->get();

        // Remove any shares associated with soft-deleted files
        $this->cleanUpDeletedShares();

        // Return the view with the shared files
        return view('shared-with-me', ['sharedWithMe' => $sharedFiles]);
    }

    private function cleanUpDeletedShares()
    {
        // Find all shares where the associated file has been soft deleted
        $sharesToDelete = DB::table('shares')
            ->join('files', 'shares.file_id', '=', 'files.id')
            ->whereNotNull('files.deleted_at')
            ->select('shares.id')
            ->get();

        // Delete the identified shares
        foreach ($sharesToDelete as $share) {
            DB::table('shares')->where('id', $share->id)->delete();
        }
    }

    // Ensure the authenticated user owns the file before sharing or deleting the share
    private function authorizeFileAccess(File $file)
    {
        if ($file->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    // Store a new share
    public function store(Request $request, $fileId)
    {
        // Validate the input data
        $request->validate([
            'recipient_email' => 'required|email',
        ], [
            'recipient_email.required' => 'Please provide an email address.',
            'recipient_email.email' => 'Please enter a valid email address.',
        ]);

        // Fetch the file by ID, ensuring it belongs to the authenticated user
        $file = File::findOrFail($fileId);
        $this->authorizeFileAccess($file); // Ensure the user owns the file

        // Get the authenticated user's email
        $ownerEmail = Auth::user()->email;

        // Check if the recipient exists in the users table
        $recipient = User::where('email', $request->recipient_email)->first();

        if (!$recipient) {
            return redirect()->route('my-files')->with('status', 'recipient-email-doesnt-exist');
        }

        // Check if the recipient email is the owner email
        if ($request->recipient_email === $ownerEmail) {
            return redirect()->route('my-files')->with('status', 'owner-email-is-recipient-email');
        }

        // Check if this file is already shared with the recipient
        $alreadyShared = DB::table('shares')
            ->where('file_id', $fileId)
            ->where('recipient_email', $request->recipient_email)
            ->exists();

        if ($alreadyShared) {
            return redirect()->back()->with('status', 'already-shared');
        }

        // Store the shared record in the 'shares' table
        DB::table('shares')->insert([
            'file_id' => $fileId,
            'owner_email' => $ownerEmail,
            'recipient_email' => $request->recipient_email,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('status', 'file-shared');
    }

    // Delete a share
    public function destroy($id)
    {
        // Find the shared item by ID
        $share = DB::table('shares')->where('id', $id)->first();

        if (!$share) {
            return redirect()->back()->with('error', 'Share not found.');
        }

        // Fetch the associated file
        $file = File::findOrFail($share->file_id);

        // Ensure the user is the owner of the file before deleting the share
        $this->authorizeFileAccess($file);

        // If share exists and is authorized, delete it
        DB::table('shares')->where('id', $id)->delete();

        return redirect()->back()->with('status', 'share-deleted');
    }
}
