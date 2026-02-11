<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm" class="z-10">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option value="" selected disabled>Volver</option>
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
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

        <h3 class="absolute text-center w-full">
            <a href="{{ route("activity.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Crear actividad
            </a>
        </h3>
    </x-slot>
    <form action="{{ route('activity.store') }}" method="POST">
        @csrf
        <div id="activity-form-div" class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
            <div>
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" class="block" placeholder="Introduzca el nombre...">
            </div>
            <div>
                <label for="status">Estado</label>
                <select name="status" class="block">
                    <option value="Suspendida">Suspendida</option>
                    <option value="Activa" selected>Activa</option>
                    <option value="En Espera">En Espera</option>
                    <option value="Completada">Completada</option>
                    <option value="Pospuesta">Pospuesta</option>
                    <option value="En Progreso">En Progreso</option>
                </select>
            </div>

            <!--
            <div>
                <label for="name">Fecha de inicio</label>
                <input type="date" id="quantity" name="starting_date" class="block" placeholder="Introduzca la categoría...">
            </div>
            <div>
                <label for="name">Fecha de fin</label>
                <input type="date" id="quantity" name="ending_date" class="block" placeholder="Introduzca la categoría...">
            </div>
            <div>
                <label for="name">Hora de inicio</label>
                <input type="time" id="quantity" name="date[0][starting_time][]" class="block" placeholder="Introduzca la categoría...">
            </div>
            <div>
                <label for="name">Hora de fin</label>
                <input type="time" id="quantity" name="date[0][ending_time][]" class="block" placeholder="Introduzca la categoría...">
            </div>
            -->
            <div>
                <label for="">Importante</label>
                <input type="checkbox" name="important" value="1">
            </div>

            <!--Campos Adicionales-->
            <div class="flex items-center justify-right col-span-2">
                <div id="add-date" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition w-[25%] self-center justify-center">
                    Agregar Fecha
                </div>
            </div>

            <div class="flex items-center justify-right col-span-2">
                <div id="add-good" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition w-[25%] self-center justify-center">
                    Agregar Bien
                </div>
            </div>

            <div class="flex items-center justify-right col-span-2 text-nowrap">
                <div id="add-organizer" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 hover:bg-yellow-800 transition w-[25%] self-center justify-center">
                    Agregar Organizador
                </div>
            </div>
        </div>
    <div class="flex justify-center w-full items-end p-[5vh]">
        <button class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Registrar</button>
    </div>
    </form>

    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

    <x-slot name="script2">
        {{ asset("js/activityCreation.js") }}
    </x-slot>

    <script>
        const goods = @json($goods);
        const inventories = @json($inventories);
    </script>

</x-app-layout>
