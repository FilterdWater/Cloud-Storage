@props(['disabled' => false])

<input type="file" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'block rounded-l-full rounded-r-full w-full text-sm text-gray-500 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-rose-500 dark:focus:border-rose-600 focus:ring-rose-500 dark:focus:ring-rose-600 rounded-md shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100'
]) !!}>
