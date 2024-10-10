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
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 px-2">
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
                    <h1 class="text-3xl flex justify-center sm:justify-start font-bold text-gray-800 dark:text-gray-100 text-center">Welcome to Cloudify</h1>
                    <div class="text-center flex justify-center sm:justify-end">
                        <!-- Guest users (not logged in) -->
                        @guest
                            <div class="flex items-center justify-center gap-6">
                                <a href="{{ route('login') }}">
                                    <x-primary-button>
                                        {{ __('Log in') }}
                                    </x-primary-button>
                                 </a>
                                <a href="{{ route('register') }}">
                                    <x-primary-button>
                                        {{ __('Register') }}
                                    </x-primary-button>
                                </a>
                            </div>
                        @else
                            <!-- Authenticated users (logged in) -->
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}"
                                    class="inline-block px-6 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                                    {{ __('Go to Dashboard') }}
                                </a>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 sm:size-7" viewBox="0 0 24 24"
                                fill="none">
                                <g fill="#FF2D20">
                                    <path
                                        d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2m0 12H4V6h5.17l2 2H20zm-5-5c1.1 0 2-.9 2-2s-.9-2-2-2s-2 .9-2 2s.9 2 2 2m-4 4h8v-1c0-1.33-2.67-2-4-2s-4 .67-4 2z" />
                                </g>
                            </svg>

                        </div>

                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white">Share your files!</h2>
                            <p class="mt-4 text-sm/relaxed">
                                Seamlessly share your files with colleagues, friends, or family. Our platform allows
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
