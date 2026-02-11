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
            <a href="{{ route("lesson.index", $discipline->id) }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                {{ $discipline->name }}
            </a>
        </h3>

    </x-slot>

    <form class="flex flex-col justify-between h-full" action='{{ route('lesson.update', ["lesson" => $lesson->id, "discipline" => $discipline->id]) }}' method="POST">
    @method("PATCH")
    @csrf
    <div id="login-div" class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
            @if($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        <div>
            <label for="name">Nombre</label>
            <input type="text" required id="name" name="name" class="block" placeholder="Introduzca el nombre..." value="{{ old('name') ?? $lesson->name }}">
        </div>
        <div class="row-span-2">
            <label for="date">Descripción (opcional)</label>
            <textarea id="description" name="description" class="block resize-none" placeholder="Escriba aquí...">{{ old('description') ?? $lesson->description }}</textarea>
        </div>
        <div>
            <label for="status">Estado</label>
            <select name="status" id="status" class="block">
                <option value="1" {{ $lesson->status == 1 ? "selected" : "" }}>Activo</option>
                <option value="0" {{ $lesson->status == 0 ? "selected" : "" }}>Inactivo</option>
            </select>
        </div>
        <div>
            <label for="color">Color</label>
            <select name="color" id="color" class="block" required>
                <option value="" disabled selected>Seleccione...</option>
                <option value="blue" {{ $lesson->color == "blue" ? "selected" : "" }}>Azúl</option>
                <option value="cyan" {{ $lesson->color == "cyan" ? "selected" : "" }}>Celeste</option>
                <option value="brown" {{ $lesson->color == "brown" ? "selected" : "" }}>Marrón</option>
                <option value="green" {{ $lesson->color == "green" ? "selected" : "" }}>Verde</option>
                <option value="lime" {{ $lesson->color == "lime" ? "selected" : "" }}>Lima</option>
                <option value="yellow" {{ $lesson->color == "yellow" ? "selected" : "" }}>Amarillo</option>
                <option value="purple" {{ $lesson->color == "purple" ? "selected" : "" }}>Morado</option>
            </select>
        </div>
    </div>



    <div class="flex justify-center w-full items-end p-[5vh]">
        <button class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Actualizar</button>
    </div>
    </form>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

</x-app-layout>
