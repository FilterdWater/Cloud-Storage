<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->role_id != 1) {
            return redirect('my-files');
        }

        // Group files by extension
        $filesByExtension = File::selectRaw('SUBSTRING_INDEX(path, ".", -1) as extension, COUNT(*) as count')
            ->groupBy('extension')
            ->get();

        $labels = $filesByExtension->pluck('extension')->toArray();
        $data = $filesByExtension->pluck('count')->toArray();

        // Filter data for categories like image, document, video
        $filterData = [
            'all' => [
                'labels' => $labels,
                'data' => $data
            ],
            'image' => [
                'labels' => ['jpg', 'png'], // Add all image extensions
                'data' => [10, 20]          // Example counts for these extensions
            ],
            'document' => [
                'labels' => ['pdf', 'docx'], // Add all document extensions
                'data' => [5, 3]             // Example counts for these extensions
            ],
            'video' => [
                'labels' => ['mp4'],         // Add all video extensions
                'data' => [7]                // Example counts for these extensions
            ]
        ];

        return view('dashboard', compact('labels', 'data', 'filterData'));
    }
}
