<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option value="" selected disabled>Volver</option>
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>
    </x-slot>

    <form class="flex flex-col justify-between h-full" action='{{ route('discipline.store') }}' method="POST">
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
            <label for="name">Nombre de la disciplina</label>
            <input type="text" required id="name" name="name" class="block" placeholder="Introduzca el nombre..." value="{{ old('name') }}">
        </div>
    </div>



    <div class="flex justify-center w-full items-end p-[5vh]">
        <button class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Registrar</button>
    </div>
    </form>
    <x-slot name="script">
    {{ "../js/redirect.js" }}
    </x-slot name="script">

</x-app-layout>
