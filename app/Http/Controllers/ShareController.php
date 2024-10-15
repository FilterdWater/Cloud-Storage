<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{

    // Retrieve shares where the authenticated user is the owner
    public function shared()
    {
        $shared = DB::table('shares')
            ->join('files', 'shares.file_id', '=', 'files.id')
            ->where('shares.owner_email', Auth::user()->email)
            ->select('shares.*', 'files.path') // Select relevant columns
            ->get();

        return view('shared', ['shared' => $shared]);
    }


    // Retrieve shares where the authenticated user is the recipient
    public function sharedWithMe()
    {
        $sharedWithMe = DB::table('shares')
            ->where('recipient_email', Auth::user()->email)
            ->get();

        return view('shared-with-me', ['sharedWithMe' => $sharedWithMe]);
    }

    public function store(Request $request, $fileId)
    {
        // Validate the input data
        $request->validate([
            'recipient_email' => 'required|email',
        ]);

        // Fetch the file by ID, ensuring it belongs to the authenticated user
        $file = File::where('user_id', Auth::id())->findOrFail($fileId);

        // Check if the recipient exists in the users table
        $recipient = User::where('email', $request->recipient_email)->first();

        if (!$recipient) {
            return redirect()->back()->with('error', 'Recipient email does not exist.');
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
            'owner_email' => Auth::user()->email,
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
