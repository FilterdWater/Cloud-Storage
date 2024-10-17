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
            ->get();

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
            ->select('files.*', 'shares.created_at', 'shares.id as share_id', 'shares.owner_email as owner_email')
            ->get();

        // Return the view with the shared files
        return view('shared-with-me', ['sharedWithMe' => $sharedFiles]);
    }



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
        $file = File::where('user_id', Auth::id())->findOrFail($fileId);

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



    public function destroy($id)
    {
        // Find the shared item by ID
        $share = DB::table('shares')->where('id', $id)->first();

        // If share exists, delete it
        if ($share) {
            DB::table('shares')->where('id', $id)->delete();
            return redirect()->back()->with('status', 'share-deleted');
        }

        // If share does not exist, return an error
        return redirect()->back()->with('error', 'Share not found.');
    }
}
