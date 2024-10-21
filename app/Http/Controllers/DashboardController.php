<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all files and group them by file extension
        $filesByExtension = File::selectRaw('SUBSTRING_INDEX(path, ".", -1) as extension, COUNT(*) as count')
            ->groupBy('extension')
            ->get();

        // Prepare data for Chart.js
        $labels = $filesByExtension->pluck('extension')->toArray();
        $data = $filesByExtension->pluck('count')->toArray();

        return view('dashboard', compact('labels', 'data'));
    }
}
