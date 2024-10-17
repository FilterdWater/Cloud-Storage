<section>
    @php
        $status = session('status');
    @endphp

    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
        {{-- Status-based notifications --}}
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
                    <p class="text-lg font-semibold text-white">{{ __('File shared successfully!') }}</p>
                </div>
            @break

            @case('already-shared')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File is already shared with this user!') }}</p>
                </div>
            @break

            @case('recipient-email-doesnt-exist')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('The recipient email does not exist.') }}</p>
                </div>
            @break

            @case('owner-email-is-recipient-email')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('You cannot share a file with yourself!') }}</p>
                </div>
            @break

            @default
                {{-- Optional: Handle other cases or do nothing --}}
        @endswitch

        {{-- Validation errors --}}
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ $error }}</p>
                </div>
            @endforeach
        @endif
    </div>
</section>
