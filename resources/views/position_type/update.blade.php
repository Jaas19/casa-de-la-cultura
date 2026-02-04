<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option value="" selected disabled>Volver</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
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

        <h3 class="absolute text-right sm:text-center w-full">
            <a href="{{ route("person.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Editar vinculación
            </a>
        </h3>
    </x-slot>

    <form action='{{ route('position_type.update') }}' method="POST" enctype="multipart/form-data">
    @csrf
    @method("PATCH")
    <div id="login-div" class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
        <div>
            <label for="id">Vinculación</label>
            <select class="block" name="id" id="id" required>
                <option value="" disabled selected class="text-gray-500">Seleccionar...</option>
                @foreach ($positionTypes as $positionType)
                    <option {{ old("id") ? "selected" : "" }} value="{{ $positionType->id }}">{{ $positionType->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="name">Nombre</label>
            <input type="text" value="{{ old("name") }}" required id="name" name="name" class="block" placeholder="Introduzca el nombre...">
        </div>
    </div>

    <div class="flex justify-center w-full items-end p-[5vh]">
        <button class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Confirmar</button>
    </div>
    </form>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

    <x-slot name="script2">
        {{ asset("js/inventoryCreation.js") }}
    </x-slot>
</x-app-layout>
