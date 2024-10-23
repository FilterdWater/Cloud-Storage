<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class FileController extends Controller
{
    public function index()
    {
        return $this->getFiles();
    }

    public function getFiles()
    {
        // Fetch only files that are tied to the User and haven't been soft deleted
        $files = File::where('user_id', Auth::id())
            ->paginate(20);

        return view('my-files', ['files' => $files]);
    }

    // Private method to check if the user owns the file or if the file there trying to download was shared with them.
    private function authorizeFileAccess(File $file)
    {
        // Check if the authenticated user owns the file
        if ($file->user_id === Auth::id()) {
            return true;
        }

        // Check if the file is shared with the authenticated user
        $userEmail = Auth::user()->email;
        $isSharedWithUser = Share::where('file_id', $file->id)
            ->where('recipient_email', $userEmail)
            ->exists();

        if ($isSharedWithUser) {
            return true;
        }

        // If neither ownership nor sharing condition is met, deny access
        abort(403, 'Unauthorized action.');
    }

    public function upload(Request $request)
    {
        // Validate that there is a file
        $request->validate([
            'file' => 'required|file'
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Create a directory for the user's files if it doesn't exist
        $destinationPath = "files/{$userId}";
        $file = $request->file('file');

        // Set the initial filename and extension
        $extension = $file->getClientOriginalExtension();
        $baseFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $finalFilename = "{$baseFilename}.{$extension}";

        // Check if the file already exists and modify the filename if necessary
        $counter = 1;
        while (Storage::disk('public')->exists("{$destinationPath}/{$finalFilename}")) {
            $finalFilename = "{$baseFilename}({$counter}).{$extension}";
            $counter++;
        }

        // Store the file with the new filename
        $filePath = $file->storeAs($destinationPath, $finalFilename, 'public');

        // Save the file info to the database
        $fileRecord = new File();
        $fileRecord->path = $filePath;  // Store the path
        $fileRecord->user_id = $userId; // Store the user ID
        $fileRecord->save();

        // Redirect back with a success message
        return redirect()->route('my-files')->with('status', 'file-uploaded');
    }

    public function download(Request $request)
    {
        $filePath = $request->input('path');

        // Retrieve file from database based on path
        $file = File::where('path', $filePath)->firstOrFail();

        // Check if the user is authorized to download this file
        $this->authorizeFileAccess($file);

        // Proceed with download if file exists
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath, $request->input('file_name'));
        }

        return redirect()->back()->with('error', 'File not found.');
    }


    public function destroy($encryptedId, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired request.');
        }

        // Decrypt the file ID
        $id = Crypt::decryptString($encryptedId);

        // Find the file using the decrypted ID
        $file = File::findOrFail($id);

        // Authorize access and delete the file
        $this->authorizeFileAccess($file);

        // Decrypt the file path as well
        $decryptedPath = Crypt::decryptString($request->input('path'));

        if (Storage::disk('public')->exists($decryptedPath)) {
            Storage::disk('public')->delete($decryptedPath);
        }

        $extension = pathinfo($decryptedPath, PATHINFO_EXTENSION);

        // Generate a new random basename for the record
        $newBasename = uniqid() . '.' . $extension;
        $newPath = time() . '_' . $newBasename;

        // Update the path in the database and soft delete the file record
        $file->path = $newPath;
        $file->save();

        // Soft delete the file record
        $file->delete();

        return redirect()->route('my-files')->with('status', 'file-deleted');
    }
}
