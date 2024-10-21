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
                    <canvas id="fileExtensionsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Data passed from the controller
            var labels = @json($labels);
            var data = @json($data);

            // Initialize Chart.js
            var ctx = document.getElementById('fileExtensionsChart').getContext('2d');
            var fileExtensionsChart = new Chart(ctx, {
                type: 'bar', // You can change this to 'pie', 'line', etc.
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Files by Extension',
                        data: data,
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
        });
    </script>
</x-app-layout>
