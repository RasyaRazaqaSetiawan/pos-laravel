<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="flex min-h-screen items-center justify-center bg-white p-6">
    @if (Route::has('login'))
        <div class="w-full max-w-md">
            <!-- Main POS Card -->
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-2xl">
                <!-- Header Section -->
                <div class="relative bg-gradient-to-br from-blue-600 to-blue-700 px-8 py-12 text-center">
                    <div class="absolute inset-0 bg-blue-600 opacity-90"></div>
                    <div class="relative z-10">
                        <!-- POS Icon -->
                        <div
                            class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-white bg-opacity-20">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <h1 class="mb-2 text-3xl font-bold text-white">Welcome to POS</h1>
                        <p class="text-lg text-blue-100">Point of Sales Management System</p>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="px-8 py-8">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="block w-full rounded-xl bg-blue-600 px-6 py-4 text-center text-lg font-medium text-white shadow-lg transition-colors duration-200 hover:bg-blue-700">
                            Go to Dashboard
                        </a>
                    @else
                        <div class="mb-8 space-y-4">
                            <a href="{{ route('login') }}"
                                class="block w-full rounded-xl bg-blue-600 px-6 py-4 text-center text-lg font-medium text-white shadow-lg transition-colors duration-200 hover:bg-blue-700">
                                Sign In
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="block w-full rounded-xl bg-gray-100 px-6 py-4 text-center text-lg font-medium text-gray-700 transition-colors duration-200 hover:bg-gray-200">
                                    Create New Account
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>

                <!-- Footer -->
                <div class="px-8 pb-8">
                    <div class="border-t border-gray-100 pt-6 text-center">
                        <p class="mb-2 text-sm text-gray-500">Created By</p>
                        <p class="text-sm font-medium text-blue-600">Rasya Razaqa Setiawan</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Indicators -->
            <div class="mt-6 flex justify-center space-x-2">
                <div class="h-2 w-2 rounded-full bg-blue-600"></div>
                <div class="h-2 w-2 rounded-full bg-gray-300"></div>
                <div class="h-2 w-2 rounded-full bg-gray-300"></div>
            </div>
        </div>
    @endif
</body>

</html>
