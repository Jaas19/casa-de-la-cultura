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
            </select>
        </form>
    </x-slot>

    <table class="w-full grid-cols-[auto-fill] table-fixed overflow-auto grow-0">
        <tbody class="overflow-auto w-full relative">
            <tr class="w-full">
                <th>Nombre</th>
                <th>Bien</th>
                <th>Inventario</th>
                <th>Entrega</th>
                <th>Recepción</th>
                <th>Estado</th>
            </tr>
            <tr>
                <td>Teresa</td>
                <td>1 Piano</td>
                <td>Academia</td>
                <td>11/12/25</td>
                <td>12/12/25</td>
                <td>
                    <select name="" id="" data-loan-id="" class="bg-black2 border-yellow-900 border-0">
                        <option value="">Seleccionar</option>
                        <option value="">Seleccionar</option>
                        <option value="">Seleccionar</option>
                        <option value="">Seleccionar</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <x-slot name="script">
        {{ "../js/redirect.js" }}
    </x-slot>
</x-app-layout>