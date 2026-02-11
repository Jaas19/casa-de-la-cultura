<x-app-layout>
    <div class="activity px-10 py-14 flex flex-wrap justify-evenly gap-y-14">
        <x-slot name="header">
            <form action="" id="redirectForm" class="z-10">
            <select id="redirect-select" class="dropdown-arrow font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}" selected disabled>Disciplinas</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                <option class="bg-black2 redirectOption" value="{{ route("permission.index") }}">Permisos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>

                </select>
            </form>

            <div class="flex flex-col items-center w-full absolute">
                <input type="text" placeholder="Buscar..." class="bg-black2">
            </div>


            <select id="filter-activity-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}')">
                <option class="bg-black2 filter-activity-option" value="Todas">Todas</option>
                <option class="bg-black2 filter-activity-option" value="Activas" selected>Activas</option>
                <option class="bg-black2 filter-activity-option" value="Inactiva">Inactivas</option>
            </select>
        </x-slot>

        <div class ="flex flex-wrap gap-x-9 gap-y-14 items-center justify-center">
            @foreach ($activeDisciplines as $activeDiscipline)
                <div class="size-72 bg-white rounded-3xl">
                    <div class="h-[42%] w-full bg-gradient-to-r from-lime-400 to-lime-200 py-3 px-4 rounded-t-3xl">
                        <h3 class="text-white2 black_contour_sm font-bold">{{ $activeDiscipline->name }}</h3>
                    </div>
                    <div class="py-4 px-4 rounded-b-3xl h-[60%] flex flex-col">
                        <ul class="text-blue-400">
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('discipline.edit', $activeDiscipline->id) }}">Editar</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('lesson.calendar', $activeDiscipline->id) }}">Calendario</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('lesson.index', $activeDiscipline->id) }}">Clases</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('student.index', $activeDiscipline->id) }}">Estudiantes</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('payment.index', $activeDiscipline->id) }}">Pagos</a></li>
                        </ul>
                    </div>
                </div>
            @endforeach

            @foreach ($inactiveDisciplines as $inactiveDiscipline)
                <div class="size-72 bg-white rounded-3xl">
                    <div class="h-[40%] w-full bg-gradient-to-r from-red-500 to-red-300 py-4 px-4 rounded-t-3xl">
                        <h3 class="text-white2 black_contour_sm font-bold">{{ $inactiveDiscipline->name }}</h3>
                    </div>
                    <div class="py-4 px-4 rounded-b-3xl h-[60%] flex flex-col">
                        <ul class="text-blue-400">
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('discipline.edit', $inactiveDiscipline->id) }}">Editar</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('lesson.calendar', $inactiveDiscipline->id) }}">Calendario</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('lesson.index', $inactiveDiscipline->id) }}">Clases</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('student.index', $inactiveDiscipline->id) }}">Estudiantes</a></li>
                            <li class="border-b border-blue-400 w-min text-sm"><a href="{{ route('payment.index', $inactiveDiscipline->id) }}">Pagos</a></li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

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
        text-gray-800

        bg-white2 text-black2 rounded-2xl p-3 text-xl p-3 text-center
        -->

    <x-slot name="script2">
        {{ "../js/redirect.js" }}
    </x-slot>
    </div>
    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-center gap-10">
            <a href="discipline/create" class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-40">Registrar</a>
            <a href= {{ route('lesson.general') }} class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-40">Ver calendario</a>
        </div>
    </x-slot>
    <x-slot name="script">
        {{ "../js/notification.js" }}
    </x-slot>
</x-app-layout>
