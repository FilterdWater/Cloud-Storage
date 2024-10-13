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
                    {{ __('Upload a new file') }}

                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" required>
                        <button type="submit" class="btn btn-primary">Upload</button>
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
</x-app-layout>
