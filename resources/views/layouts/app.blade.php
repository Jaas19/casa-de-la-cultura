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

    <body class="font-sans antialiased flex flex-col justify-center items-center w-full overflow-auto max-h-screen">
        
            @isset($standalone)
                <div id="containerShadow" class="transition-all hide bg-black opacity-0 flex flex-col items-center justify-center h-full w-full fixed"></div>
                    {{ $standalone }}
                </div>
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

        @isset($scriptAjax)
            <script src="{{ $scriptAjax }}"></script>
        @endisset
    </body>
</html>
