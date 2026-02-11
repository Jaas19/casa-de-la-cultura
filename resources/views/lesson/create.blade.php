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
        </div>
    </x-slot>

    <form class="flex flex-col justify-between h-full" action='{{ route('lesson.store', $discipline->id) }}' method="POST">
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
            <input type="text" required id="name" name="name" class="block" placeholder="Introduzca el nombre..." value="{{ old('name') }}">
        </div>
        <div>
            <label for="description">Descripción (opcional)</label>
            <textarea id="description" name="description" class="block resize-none" placeholder="Escriba aquí...">{{ old('description') }}</textarea>
        </div>
        <div>
            <label for="color">Color</label>
            <select name="color" id="color" class="block" required>
                <option value="" disabled selected>Seleccione...</option>
                <option value="blue">Azúl</option>
                <option value="cyan">Celeste</option>
                <option value="brown">Marrón</option>
                <option value="green">Verde</option>
                <option value="lime">Lima</option>
                <option value="yellow">Amarillo</option>
                <option value="purple">Morado</option>
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
