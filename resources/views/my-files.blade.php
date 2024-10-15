<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            @include('profile.partials.notification-message')
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.upload-files-form')
                </div>
            </div>
            <div class="flex flex-wrap gap-4">
                @if ($files->isEmpty())
                    <div
                        class="bg-white dark:bg-gray-800 mt-4 p-5 w-full text-center rounded-lg border-5 border-indigo-800 shadow">
                        <p>No files available.</p>
                        <p>Start uploading files to this amazing app</p>
                    </div>
                @else
                    @foreach ($files as $file)
                        <div class="flex-2 items-center justify-between mt-3">
                            <div
                                class="flex justify-between bg-gray-800 dark:bg-gray-500 p-3 rounded-lg text-white font-semibold dark:hover:!bg-gray-700 hover:bg-gray-400 hover:text-black dark:hover:text-white">

                                <p>{{ basename($file->path) }}</p>

                                <x-dropdown width="32">
                                    <x-slot name="trigger">
                                        <div class="ms-1 cursor-pointer">
                                            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="2" />
                                                <circle cx="12" cy="12" r="2" />
                                                <circle cx="12" cy="19" r="2" />
                                            </svg>
                                        </div>
                                    </x-slot>

                                    <x-slot name="content">

                                        @include('profile.partials.download-files-form')

                                        <x-dropdown-link x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', {{ $file->id }})">
                                            <i class="fa-solid fa-user-plus mr-2"></i>{{ 'Share' }}
                                        </x-dropdown-link>

                                        @include('profile.partials.delete-files-form')

                                    </x-slot>
                                </x-dropdown>
                            </div>

                        </div>
                    @endforeach
                @endif
                @foreach ($files as $file => $data)
                    @include('profile.partials.share-files-form')
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>

{{-- <x-app-layout>
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

                 Display uploaded files -->
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

    <!-- JavaScript to handle file size validation -->
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
    </script> 
    
</x-app-layout> --}}
