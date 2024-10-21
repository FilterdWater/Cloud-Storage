<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg mb-4">File Extensions Overview</h3>
                    
                    <!-- Filter Buttons -->
                    <div class="mb-4">
                        <button class="filter-btn border border-1 rounded-lg border-rose-500 p-2" data-filter="all">All Extensions</button>
                        <button class="filter-btn border border-1 rounded-lg border-rose-500 p-2" data-filter="image">Images</button>
                        <button class="filter-btn border border-1 rounded-lg border-rose-500 p-2" data-filter="document">Documents</button>
                        <button class="filter-btn border border-1 rounded-lg border-rose-500 p-2" data-filter="video">Videos</button>
                    </div>

                    <!-- Chart -->
                    <canvas id="fileExtensionsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initial data passed from the controller
            var allLabels = @json($labels);  // Example: ['jpg', 'png', 'pdf', 'docx', 'mp4']
            var allData = @json($data);      // Example: [10, 20, 5, 3, 7]
            
            // Example of pre-defined filter data (you can adjust based on real data)
            var filterData = {
                'all': { labels: allLabels, data: allData },
                'image': { labels: ['jpg', 'png'], data: [10, 20] },
                'document': { labels: ['pdf', 'docx'], data: [5, 3] },
                'video': { labels: ['mp4'], data: [7] }
            };

            // Initialize Chart.js with default "all" data
            var ctx = document.getElementById('fileExtensionsChart').getContext('2d');
            var fileExtensionsChart = new Chart(ctx, {
                type: 'bar', 
                data: {
                    labels: allLabels,
                    datasets: [{
                        label: 'Number of Files by Extension',
                        data: allData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Add event listeners to buttons
            document.querySelectorAll('.filter-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var filter = this.getAttribute('data-filter');
                    var filteredLabels = filterData[filter].labels;
                    var filteredData = filterData[filter].data;

                    // Update the chart with filtered data
                    fileExtensionsChart.data.labels = filteredLabels;
                    fileExtensionsChart.data.datasets[0].data = filteredData;
                    fileExtensionsChart.update();
                });
            });
        });
    </script>
</x-app-layout>
