<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}" selected disabled>Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>
    </x-slot>
    <x-slot name="element">
        <div class="flex items-center gap-8">
            <select name="" id="statusInput" class="bg-white2 dark:bg-black2 text-black2 dark:text-gray-500">
                <option value="active" selected>Activos</option>
                <option value="inactive">Suspendidos</option>
            </select>
            <select name="" id="positionTypeSelect" class="bg-white2 dark:bg-black2 text-black2 dark:text-gray-500">
                @foreach ($positionTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
                    <option value="{{ route("position_type.create") }}">Crear vinculación</option>
                    <option value="{{ route("position_type.edit") }}">Editar vinculación</option>
            </select>
            <select name="positions" id="positions" class="bg-white2 dark:bg-black2 text-black2 dark:text-gray-500">
                    <option value="" selected>Todos</option>
                    @foreach ($positions as $position)
                    <option class="text-center" value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                    <option value="{{ route("position.create") }}">Crear perfil</option>
                    <option value="{{ route("position.edit") }}">Editar perfil</option>
                </select>
            <!--Barra de búsqueda y botón de filtro-->
            <div class="relative flex items-center justify-center">
                <input id="search-person-input" type="text" class="relative dark:bg-black2 dark:text-white2" placeholder="Buscar persona...">
                <div class="search absolute"></div>
            </div>
            <!--<img src="{{ asset('images/filter.png') }}" alt="" class="cursor-pointer">-->
        </div>
    </x-slot>
    <table class=" grid-cols-[auto-fill] table-fixed overflow-auto grow-0">
        <thead class="relative isolate w-full text-white2
              after:content-[''] after:absolute after:inset-0 after:-z-10
              after:bg-gradient-to-r after:from-yellow-900 after:to-yellow-700">
            <tr class="">
                <th>Foto</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Perfil</th>
                <th class="text-nowrap">Asistencia (pdf)</th>
            </tr>
        </thead>
        <tbody class="overflow-auto  relative">

            @foreach ($persons as $person)
            <tr class="person-data {{ $person->status == "inactive" ? 'hide2' : '' }}" data-status="{{ $person->status }}" data-discipline-id="0" data-person-id="{{ $person->id }}" data-position-id="{{ $person->position->id }}" data-position-type-id="{{ $person->position->type->id }}">
                <td class="person-data-attribute overflow-hidden flex justify-center">
                @if ($person->image)
                    <img src="{{Storage::url($person->image)}}" class="max-h-12">
                @endif
                </td>
                <td class="person-data-attribute">{{$person->dni}}</td>
                <td class="person-data-attribute">{{$person->name}}</td>
                <td class="person-data-attribute">{{$person->lastname}}</td>
                <td class="person-data-attribute">{{$person->sex}}</td>
                <td class="person-data-attribute">{{$person->phone_number}}</td>
                <td class="person-data-attribute">{{$person->position?->name ?? 'Sin cargo.'}}</td>
                <td><input class="person-assistance-status" type="checkbox" value="1"
                    {{ collect($personsAssistance)->contains('person_id', $person->id) ? 'checked' : '' }}
                    >
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-evenly">
            <form action="" id="update-form" method="POST" class="hidden">
                @csrf
                <input type="hidden" id="personId" name="id" value="0">
                <input type="hidden" id="disciplineId" name="discipline" value="0">
                <input type="hidden" id="userId" name="user_id" value="{{ $userId }}">
            </form>

            <a href="person/create" id="register-button" class="rounded-3xl bg-sky-500 text-md font-bold text-white2 black_contour p-3">Registrar Persona</a>
            <a href="person/pdf" target="blank" class="rounded-3xl bg-orange-500 text-md font-bold text-white2 black_contour p-3">Generar Asistencia</a>
            <div id="update-button" class="cursor-pointer rounded-3xl bg-green-500 text-md font-bold text-white2 black_contour p-3">Editar Persona</div>
            <button id="suspend-button" class="rounded-3xl bg-red-600 text-md font-bold text-white2 black_contour p-3">Suspender Persona</button>
        </div>
    </x-slot>
    <x-slot name="script">
        {{ asset("js/person.js") }}
    </x-slot>
    <x-slot name="script2">
        {{ asset("js/redirect.js") }}
    </x-slot>
        <x-slot name="scriptAjax">
        {{ asset("js/personAjax.js") }}
    </x-slot>
</x-app-layout>
