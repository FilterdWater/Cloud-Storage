<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('profile.partials.upload-files-form')
                </div>

                {{-- Display uploaded files --}}
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">{{ __('All your files:') }}</h3>
                    <ul class="mt-4 space-y-4">
                        @foreach ($files as $file)
                            <li class="border-b border-gray-300 dark:border-gray-600 pb-4">
                                <div class="text-lg font-semibold">
                                    {{ basename($file->path) }}
                                </div>
                                <div class="text-sm">
                                    <span class="font-semibold">{{ __('Path:') }}</span> {{ $file->path }}
                                </div>
                                <div class="text-sm">
                                    <span class="font-semibold">{{ __('Uploaded on:') }}</span> {{ $file->created_at }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- JavaScript to handle file size validation -->
    <script>
        document.getElementById('file').addEventListener('change', function () {
            const fileInput = this;
            const file = fileInput.files[0];

            const maxFileSizeMB = 2; // Maximum file size in MB
            const maxFileSizeBytes = maxFileSizeMB * 1024 * 1024; // Convert MB to bytes

            if (file.size > maxFileSizeBytes) {
                alert(`The file size exceeds the ${maxFileSizeMB}MB limit. Please choose a smaller file.`);
                fileInput.value = ''; // Reset the input
            }
        });
    </script> --}}
    
</x-app-layout>
