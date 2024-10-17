<section>
    <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
        @csrf {{-- https://laravel.com/docs/11.x/csrf --}}
        <div class="flex items-center gap-2">
            <div>
                <x-upload-file id="file" name="file" />
            </div>
            <x-primary-button>{{ __('Upload') }}</x-primary-button>
        </div>
    </form>
</section>
