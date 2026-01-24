<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
            <select id="redirect-select" class="bg-black2 dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option value="" selected disabled>Volver</option>
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>
        <h1 class="text-center w-full text-white2 text-xl black_contour font-black">
            {{ $discipline->name }}
        </h1>
    </x-slot>


    <!--
        bg-blue-600
        bg-cyan-400
        bg-yellow-900
        bg-green-600
        bg-lime-400
        bg-yellow-300
        bg-pueple-700
    -->

    <x-slot name="element">
        <input id="date-input" type="date" class="bg-black2 text-gray-500">
    </x-slot>

    <div class="hidden from-red-500 to-red-300 from-purple-400 to-purple-200 from-orange-400 to-orange-200 from-lime-400 to-lime-200 from-yellow-400 to-yellow-100 from-cyan-400 to-cyan-200 bg-red-500 bg-red-300 bg-purple-400 bg-purple-200 bg-orange-400 bg-orange-200 bg-lime-400 bg-lime-200 bg-yellow-400 bg-yellow-100 bg-cyan-400 bg-cyan-200 border-red-500 border-red-300 border-purple-400 border-purple-200 border-orange-400 border-orange-200 border-lime-400 border-lime-200 border-yellow-400 border-yellow-100 border-cyan-400 border-cyan-200 text-red-500 text-red-300 text-purple-400 text-purple-200 text-orange-400 text-orange-200 text-lime-400 text-lime-200 text-yellow-400 text-yellow-100 text-cyan-400 text-cyan-200 text-gray-950 text-cyan-900 text-gray-800 text-cyan-700 text-gray-500 text-cyan-600 hover:bg-gray-200 border-b-4 bg-white2 text-black2 rounded-2xl rounded-full p-3 text-xl p-3 text-center h-2 w-2 text-left bg-gray-400 absolute opacity-25 opacity-0"></div>

    @csrf

    <x-slot name="standalone">
        <article id="dayActivitiesModal" class="transition-all hide flex flex-col bg-gray-200 border border-black max-h-[80svh] fixed w-[80svh] z-10 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-2xl rounded-lg z-50">
            <h3 id="modalHeader" class="black_contour_sm text-white2 text-xl px-5 flex items-center justify-left bg-gradient-to-r from-yellow-900 to-yellow-700 h-16 rounded-t-lg">
                </h3>
            <article id="activitiesContainer" class="flex flex-col overflow-auto p-2 gap-2">
                </article>
        </article>
    </x-slot>

    <div class="flex items-center justify-center p-[5%]">
        <table id="calendar"
               data-current-month=""
               data-current-year=""
               data-discipline-id="{{ $discipline->id }}"
               class="table-fixed grow-0 w-full border-collapse">
            <tr class="days-header black_contour_sm">
                <th>Domingo</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th><th>Sábado</th>
            </tr>
            @for ($y = 0; $y < 6; $y++)
                <tr>
                    @for ($x = 0; $x < 7; $x++)
                        <td class="bg-white2 h-20 w-1/7 overflow-hidden border border-black relative">
                            <div class="h-full calendar-day overflow-hidden flex flex-col justify-between gap-[1px] align-top w-full p-1" data-day="">
                            </div>
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </div>
    @if($discipline->id != 0)
        <x-slot name="footer">
            <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-center">

                    <a href="{{ route('schedule.create', $discipline->id) }}" class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-40">Agendar clase</a>

            </div>
        </x-slot>
    @endif
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>
    <x-slot name="script2">
        {{ asset("js/disciplinesCalendar.js") }}
    </x-slot>
</x-app-layout>
