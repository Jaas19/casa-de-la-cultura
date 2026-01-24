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
        </form>
    </x-slot>
    <form action='{{ route('person.patch') }}' method="POST" enctype="multipart/form-data">
    @csrf
    @method("PATCH")
    <div id="login-div" class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
            @if($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        <input type="hidden" name="id" value="{{ $person->id }}">
        <div>
            <label for="name">Nombre</label>
            <input type="text" required id="name" name="name" class="block" placeholder="Introduzca el nombre..." value="{{ $person->name }}">
        </div>
                <div>
            <label for="lastname">Apellido</label>
            <input type="text" required id="lastname" name="lastname" class="block" placeholder="Introduzca el apellido..." value="{{ $person->lastname }}">
        </div>
        <div>
            <label for="dni">Cédula</label>
            <input type="text" required id="dni" name="dni" class="block" placeholder="Introduzca la cédula..." value="{{ $person->dni }}">
        </div>
        <div class="">
            <label for="sex">Sexo</label>
            <select class="block" name="sex" id="sex" required>
                <option value="" disabled selected class="text-gray-500">Seleccionar...</option>
                <option value="Masculino" {{ $person->sex == "Masculino" ? "selected" : "" }}>Masculino</option>
                <option value="Femenino" {{ $person->sex == "Femenino" ? "selected" : "" }}>Femenino</option>
                <option value="Otro" {{ $person->sex == "Otro" ? "selected" : "" }}>Otro</option>
            </select>
        </div>
        <div>
            <label for="phone_number">Teléfono</label>
            <input type="text" required id="phone_number" name="phone_number" class="block" placeholder="Introduzca el teléfono..." value="{{ $person->phone_number }}">
        </div>
        <div class="flex flex-col">
            <label for="image">Foto<span class="font-normal text-gray-500">(opcional)</span></label>
            <input class="text-white2" type="file" id="image" name="image" class="block" placeholder="Introduzca el nombre..." value="">
        </div>
        <div>
            <label for="position">Cargo</label>
            <select name="position_id" id="position_id" class="block" required>
                <option value="" disabled required selected class="text-gray-500">Seleccionar...</option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}" {{ $position->id==$person->position_id ? 'selected' : ''}}>
                        {{ $position->name }}
                    </option>
                @endforeach
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

    <x-slot name="script2">
        {{ asset("js/inventoryCreation.js") }}
    </x-slot>
</x-app-layout>
