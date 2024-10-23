<section>
    <form method="POST" action="{{ URL::signedRoute('files.delete', ['id' => Crypt::encryptString($file->id)]) }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="path" value="{{ Crypt::encryptString($file->path) }}">

        <x-dropdown-link :href="route('files.delete', Crypt::encryptString($file->id))" onclick="event.preventDefault(); this.closest('form').submit();">
            <div class="flex items-center gap-1 size">
                <svg class="size-4 sm:size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z" />
                </svg>
                {{ __('Delete') }}
            </div>
        </x-dropdown-link>
    </form>
</section>
