<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        // Fetch only the authenticated user's files
        $files = File::where('user_id', Auth::id())->get();

        // Pass the files to the view
        return view('my-files', ['files' => $files]);
    }

    public function upload(Request $request)
    {
        // // Validate the file
        // $request->validate([
        //     'file' => 'required|file|max:2048', // Max file size is 2MB
        // ]);

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
        return redirect()->route('my-files')->with('success', 'File uploaded successfully!');
    }
}
