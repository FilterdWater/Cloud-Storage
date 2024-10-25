<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated and their role is not admin (role_id = 1)
        if (Auth::user()->role_id != 1) {
            // Redirect to 'my-files' if the user is not an admin
            return redirect('my-files');
        }

        // File Extensions Data
        // Fetch the count of files grouped by their extension
        $filesByExtension = File::selectRaw('SUBSTRING_INDEX(path, ".", -1) as extension, COUNT(*) as count')
            ->groupBy('extension')
            ->orderBy('count', 'DESC') // Order by the count of files in descending order
            ->get();

        // Extract the file extensions and their counts into arrays
        $labels = $filesByExtension->pluck('extension')->toArray(); // List of file extensions
        $data = $filesByExtension->pluck('count')->toArray(); // Corresponding file counts

        // File Upload Trends (monthly)
        // Fetch monthly trends for file uploads
        $fileUploadTrends = File::selectRaw('MONTHNAME(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)') // Order by the earliest file upload date
            ->get();

        // Extract month names and counts for the upload trends
        $uploadTrendsLabels = $fileUploadTrends->pluck('month')->toArray(); // List of months
        $uploadTrendsData = $fileUploadTrends->pluck('count')->toArray(); // Corresponding upload counts per month

        // Top Users by File Uploads
        // Fetch the top 5 users based on the number of files they have uploaded
        $topUsers = File::select('user_id', DB::raw('COUNT(*) as total'))
            ->groupBy('user_id')
            ->orderBy('total', 'DESC') // Order by total uploads in descending order
            ->take(5) // Limit to top 5 users
            ->with('user:id,name') // Load the user relationship
            ->get();

        // Extract user names and their respective upload totals
        $topUsersLabels = $topUsers->pluck('user.name')->toArray(); // List of top user names
        $topUsersData = $topUsers->pluck('total')->toArray(); // Corresponding upload counts

        // File Types Breakdown
        // Fetch the breakdown of file types (extensions) similar to the first query
        $fileTypesBreakdown = File::selectRaw('SUBSTRING_INDEX(path, ".", -1) as extension, COUNT(*) as count')
            ->groupBy('extension')
            ->orderBy('count', 'DESC') // Order by file count in descending order
            ->get();

        // Extract file types and their counts
        $fileTypesLabels = $fileTypesBreakdown->pluck('extension')->toArray(); // List of file extensions
        $fileTypesData = $fileTypesBreakdown->pluck('count')->toArray(); // Corresponding file counts

        // Calculate total files and percentage data
        $totalFiles = array_sum($fileTypesData); // Total number of files uploaded

        // Calculate the percentage of each file type based on total files
        $fileTypesPercentageData =
            $totalFiles > 0 // Check if totalFiles is greater than zero to avoid division by zero
            ? array_map(function ($count) use ($totalFiles) {
                return ($count / $totalFiles) * 100; // Calculate percentage
            }, $fileTypesData)
            : array_fill(0, count($fileTypesData), 0); // Fill with zeros if no files

        // Return the 'dashboard' view with the compiled data
        return view(
            'dashboard',
            compact(
                'labels', // File extension labels
                'data', // File extension counts
                'uploadTrendsLabels', // Month labels for upload trends
                'uploadTrendsData', // File upload counts per month for trends
                'topUsersLabels', // Top user names
                'topUsersData', // Top user upload counts
                'fileTypesLabels', // File type labels
                'fileTypesPercentageData', // File type percentage data
            ),
        );
    }
}
