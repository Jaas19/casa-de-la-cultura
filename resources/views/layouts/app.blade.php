<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Cargado de clases al archivo css de tailwind
        from-red-500 to-red-300
        from-purple-400 to-purple-200
        from-orange-400 to-orange-200
        from-lime-400 to-lime-200
        from-yellow-400 to-yellow-100
        from-cyan-400 to-cyan-200

        border-red-500 border-red-300
        border-purple-400 border-purple-200
        border-orange-400 border-orange-200
        border-lime-400 border-lime-200
        border-yellow-400 border-yellow-100
        border-cyan-400 border-cyan-200

        text-red-500 text-red-300
        text-purple-400 text-purple-200
        text-orange-400 text-orange-200
        text-lime-400 text-lime-200
        text-yellow-400 text-yellow-100
        text-cyan-400 text-cyan-200
        text-gray-800 text-red-600

        bg-white2 text-black2 rounded-2xl p-3 text-xl p-3 text-center
        -->


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased flex flex-col justify-center items-center w-full overflow-auto max-h-screen">

            @isset($standalone)
                <div id="containerShadow" class="transition-all hide bg-black opacity-0 flex flex-col items-center justify-center h-full w-full fixed z-10"></div>
                    {{ $standalone }}
            @endisset

        <div class="bg-system" style="background-image: url('{{ asset('images/house_facade.jpg') }}')"></div>
        <div class="min-h-screen sm:w-[80%] w-full">
            <main class="h-screen flex flex-col">
                <header class="flex items-center bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full py-6 px-8 text-sm overflow-x-auto overflow-y-hidden">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center relative w-full">
                                {{ $header }}
                        </div>

                        @php
                            if(isset($element)){
                                echo $element;
                            }
                        @endphp
                    </div>


                </header>
                <div class="bg-[#f8f8f8] dark:bg-[#232323] flex flex-col overflow-auto h-full">
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
                @php
                if(isset($footer)){
                    echo $footer;
                }
                @endphp
            </main>
        </div>
        @isset($script)
            <script src="{{ $script }}"></script>
        @endisset

        @isset($script2)
            <script src="{{ $script2 }}"></script>
        @endisset

        @isset($script3)
            <script src="{{ $script3 }}"></script>
        @endisset

        @isset($scriptAjax)
            <script src="{{ $scriptAjax }}"></script>
        @endisset

        <script src="{{ asset('js/notification.js') }}"></script>
    </body>
</html>
