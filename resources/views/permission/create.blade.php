<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm" class="z-10">
            <select id="redirect-select" class="bg-black2 dropdown-arrow font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option class="bg-black2 redirectOption" value="" disabled selected>Volver</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                <option class="bg-black2 redirectOption" value="{{ route("permission.index") }}">Permisos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>


        <h3 class="absolute text-right sm:text-center w-full">
            <a href="{{ route("person.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Registrar permiso
            </a>
        </h3>
    </x-slot>


    <form action="{{ route('permission.store') }}" method="POST">
    @csrf

    <div class="px-[10vw] py-[10vh] flex flex-col items-center justify-center gap-5">

        <div class="w-full md:w-1/2">
            <h2 class="text-white2 text-xl mb-4 font-bold text-center">Autorizar a un Colaborador</h2>
            <p class="text-gray-400 text-sm mb-6 text-center">
                El usuario seleccionado podrá ver y gestionar tus inventarios, disciplinas y préstamos como si fueras tú.
            </p>
        </div>

        <div class="w-full md:w-1/2">
            <label for="collaborator_id" class="text-white2 font-bold mb-2 block">Usuario</label>

            <select name="collaborator_id" id="collaborator_id" class="block" required>
                <option value="" disabled selected>Seleccione...</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>

            @error('collaborator_id')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <div class="flex justify-center w-full items-end p-[5vh]">
        <button type="submit" class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">
            Autorizar
        </button>
    </div>

    </form>

    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

    <x-slot name="script2">
        </x-slot>
</x-app-layout>
