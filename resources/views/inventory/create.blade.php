<x-app-layout>
    <x-slot name="header">
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
                <option class="bg-black2 redirectOption" value="{{ route("permission.index") }}">Permisos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>

        <h3 class="absolute text-right sm:text-center w-full">
            <a href="{{ route("inventory.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Crear inventario
            </a>
        </h3>
    </x-slot>
    <form action='{{ route('inventory.store') }}' method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $userId }}">
    <div id="login-div" class="px-[10vw] py-[10vh] mb-[-5vh] grid sm:grid-cols-2 gap-5">
        <div>
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="block" placeholder="Introduzca el nombre...">
        </div>
    </div>
    <div class="flex justify-left items-center px-[10vw]">
        <div id="add-attribute" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition w-50 self-center justify-center">
            Añadir atributo
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
        {{ asset("js/inventoryCreation.js") }}
    </x-slot>
</x-app-layout>
