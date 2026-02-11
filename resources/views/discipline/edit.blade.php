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
                <option class="bg-black2 redirectOption" value="{{ route("permission.index") }}">Permisos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>

        <h3 class="absolute text-center w-full">
            <a href="{{ route("discipline.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Editar disciplina
            </a>
        </h3>

    </x-slot>

    <form action="{{ route('discipline.patch') }}" method="POST">
    @method('PATCH')
    @csrf
    <div class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
        <div>
        <label for="id">Disciplina</label>
        <select name="id" class="block">
                <option value="{{ $discipline->id }}">{{ $discipline->name }}</option>
            @foreach ($disciplines as $discipline)
                <option value="{{ $discipline->id }}">{{ $discipline->name }}</option>
            @endforeach
        </select>
        </div>

        <div>
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="block" placeholder="Introduzca el nombre..." required>
        </div>

        <div>
            <label for="name">Estado</label>
            <select name="status" id="status" class="block">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
    </div>
    <div class="flex justify-center w-full h-full items-end p-[5vh]">
        <button type="submit" class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Actualizar</button>
    </div>
    </form>
    <x-slot name="script">
        {{ "../js/redirect.js" }}
    </x-slot>
</x-app-layout>
</div>
