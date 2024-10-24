<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 text-gray-900 dark:text-gray-100">

                    <div>
                        <!-- File Extensions Chart -->
                        <h3 class="text-lg">File Extensions Overview</h3>
                        <canvas id="fileExtensionsChart" width="400" height="200"></canvas>
                    </div>

                    <div class="h-80 w-auto flex items-center flex-col">
                        <!-- File Types Breakdown -->
                        <h3 class="text-lg">File Types Breakdown</h3>
                        <canvas id="fileTypesBreakdownChart" width="400" height="200"></canvas>
                    </div>

                    <div>
                        <!-- File Upload Trends -->
                        <h3 class="text-lg">File Upload Trends</h3>
                        <canvas id="fileUploadTrendsChart" width="400" height="200"></canvas>
                    </div>

                    <div>
                        <!-- Top Users by Uploads -->
                        <h3 class="text-lg">Top Users by File Uploads</h3>
                        <canvas id="topUsersChart" width="400" height="200"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Existing File Extensions Chart
            var fileExtensionsChart = new Chart(document.getElementById('fileExtensionsChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Number of Files by Extension',
                        data: @json($data),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // File Upload Trends
            var fileUploadTrendsChart = new Chart(document.getElementById('fileUploadTrendsChart').getContext(
                '2d'), {
                type: 'line',
                data: {
                    labels: @json($uploadTrendsLabels), // Example: ['Jan', 'Feb', 'Mar']
                    datasets: [{
                        label: 'Files Uploaded',
                        data: @json($uploadTrendsData), // Example: [5, 15, 20]
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Top Users by File Uploads
            var topUsersChart = new Chart(document.getElementById('topUsersChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($topUsersLabels), // Example: ['User 1', 'User 2', 'User 3']
                    datasets: [{
                        label: 'Files Uploaded',
                        data: @json($topUsersData), // Example: [50, 30, 20]
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // File Types Breakdown
            var fileTypesBreakdownChart = new Chart(document.getElementById('fileTypesBreakdownChart').getContext(
                '2d'), {
                type: 'pie',
                data: {
                    labels: @json($fileTypesLabels), // Example: ['Image', 'Document', 'Video']
                    datasets: [{
                        label: 'File Types Breakdown (Percentage)',
                        data: @json($fileTypesPercentageData), // Use percentage data
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw.toFixed(2) + '%'; // Show percentage
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

        });
    </script>
</x-app-layout>
