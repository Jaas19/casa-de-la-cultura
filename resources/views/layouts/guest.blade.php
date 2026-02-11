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
        {{-- <style>
            .bg-system {
                background-image: url("{{ asset('images/house_facade.jpg') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 100vh;
                width: 100vw;
                position: fixed;
                top: 0;
                left: 0;
                z-index: -1;
                filter: brightness(0.7);
            }
        </style> --}}
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900"> --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-system"
        style="background-image: url('{{ asset('images/house_facade.jpg') }}')">

            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-[#f8f8f8] dark:bg-[#323232] shadow-md overflow-y-auto sm:rounded-3xl">
                {{ $slot }}
                @if (session('success'))
                    <x-notification>
                        <x-slot name="title">Éxito</x-slot>
                            <li>
                                <span class="text-gray-800">
                                    {{ session('success') }}
                                </span>
                            </li>
                    </x-notification>
                @endif

                @if($errors->any() || session('error'))
                    <x-notification>
                        <x-slot name="title">Error</x-slot>
                        @foreach ($errors->all() as $error)
                            <li>
                                <span class="text-gray-800">
                                    {{ $error }}
                                </span>
                            </li>
                        @endforeach
                    @if (session('error'))
                        <li>
                            <span class="text-gray-800">
                                {{ session('error') }}
                            </span>
                        </li>
                    @endif
                    {{ session('error') }}
                </x-notification>
                @endif
            </div>
        </div>
    </body>
    <script src="{{ asset('js/notification.js') }}"></script>
</html>
