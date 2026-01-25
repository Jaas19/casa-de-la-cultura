<div class="font-sans antialiased flex flex-col justify-center items-center w-full h-full mb-0">

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
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>

        <h3 class="absolute text-center w-full">
            <a href="{{ route("inventory.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Editar inventario
            </a>
        </h3>
    </x-slot>

    <form action="{{ route('inventory.patch') }}" method="POST">
    @method('PATCH')
    @csrf
    <input type="hidden" name="user_id" value="{{ $userId }}" id="user-id-input">
    <div data-attribute-count="0" id="form-div" class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
        <div>
        <label for="id">Inventario</label>
        <select name="id" class="block" id="inventory-id-select">
                <option class="text-gray-500" value="" selected disabled>Seleccione...</option>
            @foreach ($inventories as $inventory)
                <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
            @endforeach
        </select>
        </div>

        <div>
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="block" placeholder="Introduzca el nombre...">
        </div>

        <div class="flex items-center justify-right">
            <div id="add-attribute" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition w-[50%] self-center justify-center">
                Añadir atributo
            </div>
        </div>

    </div>
    <div class="flex justify-center w-full h-full items-end p-[5vh]">
        <button type="submit" class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Actualizar</button>
    </div>
    </form>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>
    <x-slot name="script2">
        {{ asset("js/inventoryUpdate.js") }}
    </x-slot>
</x-app-layout>
</div>
