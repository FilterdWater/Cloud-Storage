<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shared with Me') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            @if ($sharedWithMe->isEmpty())
                <div
                    class="bg-white dark:bg-gray-800 mt-4 p-5 w-full text-center rounded-lg border-5 border-indigo-800 shadow">
                    <p>{{ __('No files have been shared with you.') }}</p>
                    <p>{{ __('When people share files with you, they will appear here!') }}</p>
                </div>
            @else
                <table class="min-w-full table-auto shadow">
                    <thead class="bg-gray-800 dark:bg-gray-500 text-white font-semibold rounded-t-lg">
                        <tr>
                            <th class="p-3 text-left">{{ __('File Name') }}</th>
                            <th class="p-3 text-left">{{ __('Shared At') }}</th>
                            <th class="p-3 text-left">{{ __('Shared By') }}</th>
                            <th class="p-3 text-left">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sharedWithMe as $share => $data)
                            <tr class="bg-gray-800 dark:bg-gray-500 text-white hover:!bg-gray-700">
                                <td class="p-3">{{ basename($data->path) }}</td>
                                <td class="p-3">{{ $data->created_at }}</td>
                                <td class="p-3">{{ $data->owner_email }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('files.download') }}">
                                        @csrf
                                        <input type="hidden" name="path" value="{{ $data->path }}">
                                        <input type="hidden" name="file_name" value="{{ basename($data->path) }}">

                                        <button type="submit"
                                            class="text-blue-500 hover:text-blue-700 dark:text-blue-400">
                                            {{ __('Download') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
