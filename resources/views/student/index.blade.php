<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm" class="z-20">
            <select id="redirect-select" class="dropdown-arrow font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option value="" selected disabled>Volver</option>
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>

        <h3 class="absolute text-center w-full">
            <a href="{{ route("discipline.index") }}"
                class="text-white2
                text-2xl black_contour font-black">
                {{ $discipline->name }}
            </a>
        </h3>
        <select id="filter-activity-select" class="dropdown-arrow z-20 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}')">
                <option class="bg-black2 filter-activity-option" value="Todas">Predeterminado</option>
                <option class="bg-black2 filter-activity-option" value="Activa">Atrasados</option>
                <option class="bg-black2 filter-activity-option" value="En Espera">Al día</option>
                <option class="bg-black2 filter-activity-option" value="En Progreso">Para hoy</option>
        </select>

    </x-slot>

    <table class="w-full grid-cols-[auto-fill] table-fixed overflow-auto grow-0">
        <thead class="relative isolate w-full text-white2
              after:content-[''] after:absolute after:inset-0 after:-z-10
              after:bg-gradient-to-r after:from-yellow-900 after:to-yellow-700">
            <tr class="w-full">
                <th>Estudiante</th>
                <th>Estado</th>
                <th>Fecha de pago</th>
                <th>Registrar pago</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody class="overflow-auto w-full relative">
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->person->name }}</td>
                <td>
                    <select name="" data-route="{{ route('student.toggle', [$discipline->id, $student->id]) }}" data-discipline-id="{{ $discipline->id }}" data-student-id="{{ $student->id }}" class="studentSelectStatus bg-black2 border-yellow-900 border-0 text-center">
                        <option value="active" {{ $student->status == "active" ? "selected" : "" }}>Activo</option>
                        <option value="inactive" {{ $student->status == "inactive" ? "selected" : "" }}>Suspendido</option>
                    </select>
                </td>
                <td data-student-id="{{ $student->id }}" class="student-next-payment-field">{{ $student->next_payment->format("d/m/Y") }}</td>
                <td>
                    <div class="flex justify-center align-center">
                        <a href={{ route("payment.create", ['discipline' => $discipline->id, 'student' => $student->id]) }} class="cursor-pointer"><img src="{{ asset("images/save.png") }}" class="size-6"></a>
                    </div>
                </td>
                <td>
                    <div class="flex justify-center align-center">
                        <a href={{ route("student.edit", [$discipline->id, $student->id]) }} class="cursor-pointer"><img src="{{ asset("images/edit_light.png") }}" class="size-6"></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-between">
            <div class="w-48"></div>
            <a href={{ route("student.create", $discipline->id) }} class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-[15%]">Registrar estudiante</a>
            <input type="text" class="w-48" placeholder="Buscar estudiante...">
        </div>
    </x-slot>
    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>
    <x-slot name="script2">
        {{ asset("js/student-status.js") }}
    </x-slot>
    <x-slot name="scriptAjax">
        {{ asset("js/student-payment.js") }}
    </x-slot>
</x-app-layout>
