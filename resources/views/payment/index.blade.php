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
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}" selected disabled>Prestamos</option>
                <option class="bg-black2 redirectOption" value="{{ route("permission.index") }}">Permisos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>

        <h3 class="absolute text-right sm:text-center w-full">
            <a href="{{ route("discipline.index") }}"
                class="text-white2
                text-2xl black_contour font-black">
                {{ $discipline->name }}
            </a>
        </h3>
    </x-slot>

    <table class="w-full grid-cols-[auto-fill] table-fixed overflow-auto grow-0">
        <thead class="relative isolate w-full text-white2
              after:content-[''] after:absolute after:inset-0 after:-z-10
              after:bg-gradient-to-r after:from-yellow-900 after:to-yellow-700">
            <tr class="w-full">
                <th>Estudiante</th>
                <th>Fecha de Pago</th>
                <th>Método de Pago</th>
                <th>Número de referencia</th>
                <th>Recibo</th>
            </tr>
        </thead>
        <tbody class="overflow-auto w-full relative">
            @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->student->person->name }}</td>
                <td>{{ $payment->date->format("d/m/Y") }}</td>
                <td>{{ $payment->method }}</td>
                <td>{{ $payment->reference_number ?? "-" }}</td>
                <td>{{ $payment->receipt_path ?? "-" }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-center">
            <a href="{{ route("payment.create", $discipline) }}" class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-[15%]">Registrar pago</a>
        </div>
    </x-slot>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>
    <x-slot name="script2">
        {{ asset("js/loanAjax.js") }}
    </x-slot>
</x-app-layout>
