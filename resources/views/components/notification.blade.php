@props(['title' => 'Notificacion'])

<div id="notification-wrapper" class="w-96 h-48 fixed bottom-0 left-0 ml-[2vw] mb-[3vh] overflow-hidden hidden z-50">
    <div data-position="0" id="notificationsContainer" class="flex gap-72">
        <div class="notification bg-white w-96 h-48 flex-shrink-0">

            <header @class([
                'p-2 flex flex-col justify-center text-center h-[30%] text-white font-bold text-lg uppercase tracking-wide',
                'bg-gradient-to-r from-green-600 to-green-800' => $title === 'Éxito',
                'bg-gradient-to-r from-red-600 to-red-800'     => $title === 'Error',
                'bg-gradient-to-r from-yellow-900 to-yellow-700' => $title !== 'Éxito' && $title !== 'Error',
            ])>
                {{ $title }}
            </header>

            {{-- BODY (CONTENIDO) --}}
            <ul class="list-disc py-4 px-8 h-full bg-white text-gray-800">
                <li class="marker:text-gray-400">
                    <span class="text-md font-medium">
                        {{-- Aquí se imprime el mensaje que envías --}}
                        {{ $slot }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>