<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center justify-between w-full">
            <form action="" id="redirectForm" class="z-10">
                <select id="redirect-select" class="dropdown-arrow font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
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
            <h3 class="absolute text-center w-full">
                <a href="{{ route("lesson.index", $lesson->discipline_id) }}"
                    class="text-white2
                    text-2xl black_contour font-black mr-5">
                    {{ $lesson->name }}
                </a>
            </h3>
        </div>
    </x-slot>

    <form class="flex flex-col justify-between h-full" action='{{ route('period.store', $lesson) }}' method="POST">
    @csrf
    <div id="login-div" class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
        <div>
            <label for="name">Día</label>
            <select name="day" id="day" class="block">
                <option value="" disabled selected>Seleccione...</option>
                <option value="1">Lúnes</option>
                <option value="2">Martes</option>
                <option value="3">Miércoles</option>
                <option value="4">Jueves</option>
                <option value="5">Viernes</option>
                <option value="6">Sábado</option>
                <option value="7">Domingo</option>
            </select>
        </div>
        <div>
            <label for="description">Hora de inicio</label>
            <input type="time" name="starting_time" id="starting_time" class="block">
        </div>
        <div>
            <label for="description">Hora de fin</label>
            <input type="time" name="ending_time" id="ending_time" class="block">
        </div>
        <div>
            <label for="color">Estado</label>
            <select name="status" id="status" class="block" required>
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
    </div>

    <div class="flex justify-center w-full items-end p-[5vh]">
        <button class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Registrar</button>
    </div>
    </form>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

</x-app-layout>
