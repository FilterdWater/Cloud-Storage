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

                                        <button type="submit">
                                            <div class="flex items-center gap-1">
                                                <svg class="size-4 sm:size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 22c-1.886 0-2.828 0-3.414-.586S8 19.886 8 18s0-2.828.586-3.414S10.114 14 12 14s2.828 0 3.414.586S16 16.114 16 18s0 2.828-.586 3.414S13.886 22 12 22m1.805-3.084l-1.334 1.333a.667.667 0 0 1-.942 0l-1.334-1.333a.667.667 0 1 1 .943-.943l.195.195v-1.946a.667.667 0 0 1 1.334 0v1.946l.195-.195a.667.667 0 0 1 .943.943" clip-rule="evenodd"/><path fill="currentColor" d="M6.5 18v-.09c0-.865 0-1.659.087-2.304c.095-.711.32-1.463.938-2.08c.618-.619 1.37-.844 2.08-.94c.646-.086 1.44-.086 2.306-.086h.178c.866 0 1.66 0 2.305.087c.711.095 1.463.32 2.08.938c.619.618.844 1.37.94 2.08c.085.637.086 1.416.086 2.267c2.573-.55 4.5-2.812 4.5-5.52c0-2.47-1.607-4.572-3.845-5.337C17.837 4.194 15.415 2 12.476 2C9.32 2 6.762 4.528 6.762 7.647c0 .69.125 1.35.354 1.962a4.4 4.4 0 0 0-.83-.08C3.919 9.53 2 11.426 2 13.765S3.919 18 6.286 18z"/></svg>    
                                                {{ __('Download') }}
                                            </div>
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
