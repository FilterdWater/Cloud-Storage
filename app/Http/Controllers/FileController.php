<?php

namespace App\Http\Controllers;

use App\Models\File; // Include the model
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        // Fetch all files from the database
        $files = File::all();

        // Pass the files to the view
        return view('my-files', ['files' => $files]);
    }
}
