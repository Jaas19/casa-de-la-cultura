<div class="font-sans antialiased flex flex-col justify-center items-center w-full h-full mb-0">

    <x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
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
    </x-slot>

    <form action="{{ route('inventory.patch') }}" method="POST">
    @method('PATCH')
    @csrf
    <input type="hidden" name="user_id" value="{{ $userId }}">
    <div class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
        <div>
        <label for="id">Inventario</label>
        <select name="id" class="block">
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
    </div>
    <div class="flex justify-center w-full h-full items-end p-[5vh]">
        <button type="submit" class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Actualizar</button>
    </div>
    </form>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>
</x-app-layout>
</div>
