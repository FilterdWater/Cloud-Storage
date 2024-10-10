<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-700 dark:text-gray-300 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 px-2">
        <div>
            <a href="/">
                <x-application-logo class="w-32 h-32" />
            </a>
        </div>
        {{-- relative max-w-2xl lg:max-w-7xl --}}
        <div
            class="w-full relative max-w-2xl lg:max-w-4xl mt-6 mb-2 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden rounded-lg">
            <main>
                <div class="grid grid-cols-1 gap-4 sm:gap-0 sm:grid-cols-2 mb-8 mt-2">
                    <h1
                        class="text-3xl flex justify-center sm:justify-start font-bold text-gray-800 dark:text-gray-100 text-center">
                        Welcome to Cloudify</h1>
                    <div class="text-center flex justify-center sm:justify-end">
                        <!-- Guest users (not logged in) -->
                        @guest
                            <div class="flex items-center justify-center gap-6">
                                <x-link-button href="{{ route('login') }}">
                                    {{ __('Log in') }}
                                </x-link-button>
                                <x-link-button href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </x-link-button>
                            </div>
                        @else
                            <!-- Authenticated users (logged in) -->
                            <div class="flex items-center justify-center">
                                <x-link-button href="{{ route('dashboard') }}">
                                    {{ __('Go to Dashboard') }}
                                </x-link-button>
                            </div>
                        @endguest
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 mb-1">

                    <div
                        class="flex items-start gap-4 rounded-lg bg-white p-6  ring-1 ring-black/5 shadow-lg transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-gray-700 dark:ring-gray-600 dark:hover:text-white/70 dark:hover:ring-gray-500 dark:focus-visible:ring-[#FF2D20]">
                        <div
                            class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 sm:size-7" fill="none"
                                viewBox="0 0 24 24">
                                <g fill="#FF2D20">
                                    <path
                                        d="M14.2 14.5v.24c-.7.6-1.2 1.5-1.2 2.46V20H6.5c-1.5 0-2.81-.5-3.89-1.57C1.54 17.38 1 16.09 1 14.58q0-1.95 1.17-3.48C3.34 9.57 4 9.43 5.25 9.15c.42-1.53 1.25-2.77 2.5-3.72S10.42 4 12 4c1.95 0 3.6.68 4.96 2.04c1.12 1.12 1.77 2.46 1.97 3.96c-2.57.04-4.73 2.08-4.73 4.5m8.8 2.8v3.5c0 .6-.6 1.2-1.3 1.2h-5.5c-.6 0-1.2-.6-1.2-1.3v-3.5c0-.6.6-1.2 1.2-1.2v-1.5c0-1.4 1.4-2.5 2.8-2.5s2.8 1.1 2.8 2.5V16c.6 0 1.2.6 1.2 1.3m-2.5-2.8c0-.8-.7-1.3-1.5-1.3s-1.5.5-1.5 1.3V16h3z" />
                                </g>
                            </svg>
                        </div>


                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white">Secure and easy</h2>
                            <p class="mt-4 text-sm/relaxed">
                                Cloudify ensures your data is securely stored giving you
                                peace of mind. Access your files with a user-friendly
                                interface designed for simplicity.
                            </p>
                        </div>

                    </div>

                    <div
                        class="flex items-start gap-4 rounded-lg bg-white p-6  ring-1 ring-black/5 shadow-lg transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-gray-700 dark:ring-gray-600 dark:hover:text-white/70 dark:hover:ring-gray-500 dark:focus-visible:ring-[#FF2D20]">
                        <div
                            class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 sm:size-6" viewBox="0 0 512 512">
                                <g fill="#FF2D20">
                                    <path d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480v-83.6c0-4 1.5-7.8 4.2-10.8l167.6-182.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8l-88.3-44.2C7.1 311.3.3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4"/>
                                </g>
                            </svg>

                        </div>

                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white">Share your files!</h2>
                            <p class="mt-4 text-sm/relaxed">
                                Seamlessly share your files with colleagues, friends, or family. Cloudify allows
                                quick sharing of documents, photos, and videos, making collaboration
                                effortless.
                            </p>
                        </div>

                    </div>
            </main>
        </div>
    </div>
</body>

</html>
