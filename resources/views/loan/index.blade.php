<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}" selected disabled>Prestamos</option>
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>
    </x-slot>

    <table class="w-full grid-cols-[auto-fill] table-fixed overflow-auto grow-0">
        <tbody class="overflow-auto w-full relative">
            <tr class="w-full">
                <th>Persona</th>
                <th>Bien</th>
                <th>Inventario</th>
                <th>Entrega</th>
                <th>Recepción</th>
                <th>Estado</th>
            </tr>
            @foreach ($loans as $loan)
            <tr>
                <td>{{ $loan->person->name }}</td>
                <td>{{ $loan->quantity_requested . " " . $loan->good->name }}</td>
                <td>{{ $loan->good->inventory->name }}</td>
                <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                <td>{{ $loan->retrieval_date->format('d/m/Y') }}</td>
                <td>
                    <select name="status" id="" data-loan-id="{{ $loan->id }}" class="loanSelectStatus bg-black2 border-yellow-900 border-0">
                        <option selected disabled>Seleccionar</option>
                        <option value="given" {{ $loan->status == "given" ? "selected" : "" }} >Entregado</option>
                        <option value="returned" {{ $loan->status == "returned" ? "selected" : "" }} >Devuelto</option>
                        <option value="overdue" {{ $loan->status == "overdue" ? "selected" : "" }} >Atrasado</option>
                    </select>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-center">
            <a href="loan/create" class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-[15%]">Registrar</a>
        </div>
    </x-slot>
    <x-slot name="script">
        {{ "../js/redirect.js" }}
    </x-slot>

    <x-slot name="script2">
        {{ "../js/loanAjax.js" }}
    </x-slot>
</x-app-layout>
