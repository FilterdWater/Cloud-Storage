<section>
    @php
        $status = session('status');
    @endphp

    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
        @switch($status)
            @case('file-uploaded')
                <div class="w-full bg-green-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File uploaded!') }}</p>
                </div>
                @break

            @case('file-deleted')
                <div class="w-full bg-green-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File deleted!') }}</p>
                </div>
                @break

            @case('file-shared')
                <div class="w-full bg-green-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File Shared!') }}</p>
                </div>
                @break

            @case('already-shared')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File is already shared with the user!') }}</p>
                </div>
                @break

            @default
                {{-- Optional: Handle other cases or do nothing --}}
        @endswitch
    </div>
</section>