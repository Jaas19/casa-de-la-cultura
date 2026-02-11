<x-app-layout>
    <x-slot name="header">
            <form action="" id="redirectForm" class="z-20">
                <select id="redirect-select" class="bg-black2 dropdown-arrow font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
                style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                    <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                    <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                    <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                    <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                    <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                    <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                    <option class="bg-black2 redirectOption" value="{{ route("permission.index") }}" selected disabled>Permisos</option>
                    @can('is-admin')
                        <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                    @endcan
                    <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
                </select>
            </form>

        <h3 class="absolute text-right sm:text-center w-full">
            <a href="{{ route("dashboard.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Permisos
            </a>
        </h3>
    </x-slot>

    <table class="w-full grid-cols-[auto-fill] table-fixed overflow-auto grow-0">
        <thead class="relative isolate w-full text-white2
              after:content-[''] after:absolute after:inset-0 after:-z-10
              after:bg-gradient-to-r after:from-yellow-900 after:to-yellow-700">
            <tr class="w-full">
                <th>Colaborador (Autorizado)</th>
                <th>Correo Electrónico</th>
                <th>Fecha de Asignación</th>
                <th>Revocar</th>
            </tr>
        </thead>
        <tbody class="overflow-auto w-full relative">
            @foreach ($permissions as $permission)
            <tr>
                <td class="text-center py-2">{{ $permission->collaborator->name }}</td>
                <td class="text-center py-2">{{ $permission->collaborator->email }}</td>
                <td class="text-center py-2">{{ $permission->created_at->format('d/m/Y') }}</td>
                <td class="text-center py-2">
                    <form action="{{ route('permission.destroy', $permission->id) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de que deseas revocar el permiso a este usuario?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="text-red-400 font-bold hover:text-red-600 transition">
                            <img src="{{ asset("images/delete.png") }}" class="size-6">
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($permissions->isEmpty())
            <tr>
                <td colspan="4" class="text-center py-4 text-gray-400">
                    No has otorgado permisos a ningún usuario todavía.
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-center">
            <a href="{{ route('permission.create') }}" class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-[20%]">
                Otorgar Nuevo Permiso
            </a>
        </div>
    </x-slot>

    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>
    <x-slot name="script2">
        </x-slot>
</x-app-layout>
