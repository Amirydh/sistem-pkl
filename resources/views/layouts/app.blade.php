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
    <body class="font-sans antialiased">
        {{-- State Alpine.js sekarang hanya untuk sidebar di tampilan mobile --}}
        <div 
            x-data="{ mobileSidebarOpen: false }"
            class="min-h-screen bg-gray-100 dark:bg-gray-900"
        >
            {{-- Navigation Bar Utama --}}
            @include('layouts.navigation')
            
            {{-- Sidebar --}}
            @include('layouts.partials.sidebar')

            {{-- Overlay untuk menutup sidebar di tampilan mobile --}}
            <div
                x-show="mobileSidebarOpen"
                x-transition
                class="fixed inset-0 bg-gray-900/50 z-30 md:hidden"
                @click="mobileSidebarOpen = false"
            ></div>

            {{-- Konten Utama dengan margin kiri statis di layar besar --}}
            <div class="p-4 md:ml-64">
                <div class="mt-14">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="bg-white dark:bg-gray-800 shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>