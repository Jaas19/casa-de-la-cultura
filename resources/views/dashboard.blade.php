<x-app-layout>
    <x-slot name="header">
            <form action="" id="redirectForm" class="z-10">
                <select id="redirect-select" class="bg-black2 dropdown-arrow font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
                style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                    <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}" selected disabled>Dashboard</option>
                    <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                    <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                    <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                    <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                    <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                    @can('is-admin')
                        <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                    @endcan
                    <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
                </select>
            </form>
            <h3 class="absolute w-full text-center text-white2 text-2xl black_contour font-black">
                {{ $username }}
            </h3>


            <input id="date-input" type="date" class="z-10 relative bg-black2 text-gray-500">
    </x-slot>
    <!-- Cargado de clases al archivo css de tailwind
        from-red-500 to-red-300
        from-purple-400 to-purple-200
        from-orange-400 to-orange-200
        from-lime-400 to-lime-200
        from-yellow-400 to-yellow-100
        from-cyan-400 to-cyan-200

        bg-red-500 bg-red-300
        bg-purple-400 bg-purple-200
        bg-orange-400 bg-orange-200
        bg-lime-400 bg-lime-200
        bg-yellow-400 bg-yellow-100
        bg-cyan-400 bg-cyan-200

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
        text-gray-950 text-cyan-900
        text-gray-800 text-cyan-700
        text-gray-500 text-cyan-600

        hover:bg-gray-200
        border-b-4
        bg-white2 text-black2 rounded-2xl rounded-full p-3 text-xl p-3 text-center h-2 w-2
        text-left
        bg-gray-400 absolute
        opacity-25
        opacity-0

        "></div>
        -->
        @csrf
        <x-slot name="standalone">
            <article id="dayActivitiesModal" class="transition-all hide flex flex-col bg-gray-200 border border-black max-h-[80svh] fixed w-[80svh] z-10">
                <h3 id="modalHeader" class="black_contour_sm text-white2 text-xl px-5 flex items-center justify-left bg-gradient-to-r from-yellow-900 to-yellow-700 h-16">28/11/2025</h3>
                <article id="activitiesContainer" class="flex flex-col overflow-auto">
                </article>
            </article>
        </x-slot>
        <div class="flex items-center justify-center p-[5%]">
            <table id="calendar" data-current-month="" data-current-year="" class="table-fixed grow-0 w-full border-collapse">
                <thead class="relative isolate w-full text-white2
                after:content-[''] after:absolute after:inset-0 after:-z-10
                after:bg-gradient-to-r after:from-yellow-900 after:to-yellow-700">
                    <tr class="days-header black_contour_sm">
                        <th>Domingo</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                    </tr>
                </thead>
                @for ($y = 0; $y < 6; $y++)
                    <tr>
                        @for ($x = 0; $x < 7; $x++)
                            <td class="bg-white2 h-20 w-1/7 overflow-hidden border border-black">
                                <div class="h-full calendar-day overflow-hidden flex flex-col justify-between gap-[1px] align-top" data-day="">
                                </div>
                            </td>
                        @endfor
                    </tr>
                @endfor
            </table>
            @php
                $carouselDays = [];
                for ($i = 0; $i < 8; $i++) {
                    $date = now()->addDays($i);
                    $dayNumber = $date->day;
                    $activitiesForDay = isset($upcomingActivities[$dayNumber]) ? $upcomingActivities[$dayNumber] : [];

                    if ($i == 0) {
                        $title = 'En curso';
                    } elseif ($i == 1){
                        $title = 'En 1 día';
                    } else {
                        $title = "En $i días";
                    }

                    $carouselDays[] = [
                        'title' => $title,
                        'activities' => $activitiesForDay
                    ];
                }
            @endphp
            <div class="w-72 h-32 fixed bottom-0 right-0 mr-[2vw] mb-[3vh] overflow-hidden z-10">
                <div id="right-button" class="absolute right-0 z-10 cursor-pointer">
                    <img src="{{ asset('images/right_arrow_white.png') }}">
                </div>
                <div id="left-button" class="absolute left-0 z-10 cursor-pointer">
                    <img src="{{ asset('images/left_arrow_white.png') }}">
                </div>
                <div data-position="0" id="notificationsContainer" class="flex gap-72">
                    @foreach ($carouselDays as $day)
                    <div class="notification bg-white2 w-72 h-32 flex-shrink-0">
                        <header class="p-2 flex flex-col justify-center text-center bg-gradient-to-r from-yellow-900 to-yellow-700 h-[30%] text-white2 black_contour_sm">
                            {{ $day['title'] }}
                        </header>
                        <ul class="list-disc py-2 px-6 h-full">
                            @forelse($day['activities'] as $activity)
                                <li class="text-{{ $activity->color1 }}">
                                    <span class="text-gray-900">{{ $activity->name }}</span>
                                </li>
                            @empty
                                Ninguna actividad de impacto.
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>
    <x-slot name="script2">
        {{ asset("js/calendar.js") }}
    </x-slot>
</x-app-layout>





