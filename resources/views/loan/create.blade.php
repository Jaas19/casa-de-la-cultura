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
                <option class="bg-black2 redirectOption" value="{{ route("permission.index") }}">Permisos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>
    </x-slot>

    <form action="{{ route('loan.store') }}" method="POST">
    @csrf
    <div class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">

                <div>
                    <label for="name">Persona</label>
                    <select name="person_id" id="person_id" class="block">
                        <option value="" disabled selected>Seleccionar...</option>
                        @foreach ($persons as $person)
                            <option value="{{ $person->id }}">{{ $person->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="loan_date">Fecha de despacho</label>
                    <input type="date" id="loan_date" name="loan_date" class="block" value="{{ now()->format("Y-m-d") }}">
                </div>

                <div>
                    <label for="status">Estado</label>
                    <select name="status" id="status" class="block">
                        <option value="given" selected>Entregado</option>
                        <option value="returned">Devuelto</option>
                        <option value="overdue">Atrasado</option>
                    </select>
                </div>

                <div>
                    <label for="retrieval_date">Fecha de devolucion</label>
                    <input type="date" id="retrieval_date" name="retrieval_date" class="block">
                </div>

                <div>
                    <label for="inventory_id">Inventario</label>
                    <select id="inventory_id" name="inventory_id" class="block" required>
                        <option id="selectGoodOption" selected>Seleccionar...</option>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantity_requested">Cantidad</label>
                    <input type="number" id="quantity_requested" name="quantity_requested" class="block" placeholder="Ingresar monto...">
                </div>

                <div>
                    <label for="good">Bien</label>
                    <select id="good" name="good_id" class="block" required>
                        <option selected>Seleccionar...</option>
                        @foreach($goods as $good)
                            <option value="{{ $good->id }}" data-inventory-id="{{ $good->inventory->id }}" class="goodOptions">{{ $good->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="flex justify-center w-full items-end p-[5vh]">
                <button type="submit" class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Registrar</button>
            </div>
    </form>

    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

    <x-slot name="script2">
        {{ asset("js/loanCreation.js") }}
    </x-slot>
</x-app-layout>
