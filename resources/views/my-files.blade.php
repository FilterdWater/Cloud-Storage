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
                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf {{-- https://laravel.com/docs/11.x/csrf --}}
                        
                        {{-- Display error messages for file upload --}}
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Choose File') }}
                            </label>
                            <input type="file" name="file" id="file" class="mt-1 block w-full p-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" required>
                        </div>
                        <button type="submit" class="border p-3 bg-white text-black">
                            {{ __('Upload') }}
                        </button>
                    </form>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('All your files:') }}
                </div>
                <div>
                    @foreach ($files as $file)
                        <ul class="text-white pl-8 pb-8">
                            <li>
                                <strong>{{ basename($file->path) }}</strong>
                            </li>
                            <li>
                                Path: {{ $file->path }}
                            </li>
                            <li>
                                Uploaded on: {{ $file->created_at }}
                            </li>
                        </ul>
                    @endforeach
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
