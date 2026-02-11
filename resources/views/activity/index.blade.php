<x-app-layout>
    <div class="activity px-10 py-14 flex flex-col gap-y-14">

        <x-slot name="header">
            <div class="flex flex-wrap justify-between items-center gap-4 w-full">

                <form action="" id="redirectForm">
                    <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
                    style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                        <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}" selected disabled>Actividades</option>
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

                <form action="{{ route('activity.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar actividad..."
                           class="bg-black2 text-white2 placeholder-gray-400 rounded-md border-0 black_contour px-4 py-2 focus:ring-2 focus:ring-yellow-600">

                    <select name="status" onchange="this.form.submit()"
                            class="dropdown-arrow font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
                            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}')">

                        <option class="bg-black2" value="Todas" {{ request('status') == 'Todas' ? 'selected' : '' }}>Todas</option>
                        <option class="bg-black2" value="Activa" {{ request('status') == 'Activa' ? 'selected' : '' }}>Activas</option>
                        <option class="bg-black2" value="En Espera" {{ request('status') == 'En Espera' ? 'selected' : '' }}>En Espera</option>
                        <option class="bg-black2" value="En Progreso" {{ request('status') == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option class="bg-black2" value="Completada" {{ request('status') == 'Completada' ? 'selected' : '' }}>Completadas</option>
                        <option class="bg-black2" value="Pospuesta" {{ request('status') == 'Pospuesta' ? 'selected' : '' }}>Pospuestas</option>
                        <option class="bg-black2" value="Suspendida" {{ request('status') == 'Suspendida' ? 'selected' : '' }}>Suspendidas</option>
                    </select>
                </form>
            </div>
        </x-slot>

        <div class="opacity-0 hidden outline outline-1 dark:outline-gray-600 flex-col text-black2 dark:text-white2 transition-opacity details-window fixed w-svw sm:w-[30vw] h-svh bg-white-2 dark:bg-black2 top-0 right-0 z-10 px-7 py-5">
            <header class="relative flex items-center justify-center mb-6">
                <h3 class="details-header text-center text-3xl">Fechas y Horas</h3>
            </header>
            <main id="details-body" class="overflow-auto flex flex-col gap-6">
            </main>
        </div>

        <div class="flex flex-wrap justify-evenly gap-y-14 w-full">

            @if($activities->isEmpty())
                <div class="text-white2 text-xl text-center w-full py-10">
                    No se encontraron actividades.
                </div>
            @endif

            @foreach ($activities as $activity)
                <x-activity>
                    <x-slot name="title">{{ $activity->name }}</x-slot>

                    @if ($activity->hasMultipleGoods)
                        <li data-activity-id="{{ $activity->id }}" data-header="Bienes" class="clickable-element cursor-pointer text-blue-400 border-b w-min border-blue-400">Bienes Solicitados</li>
                    @endif

                    @if ($activity->hasPersons)
                        <li data-activity-id="{{ $activity->id }}" data-header="Organizadores" class="clickable-element cursor-pointer text-blue-400 border-b w-min border-blue-400">Organizadores</li>
                    @endif

                    @if ($activity->hasMultipleDates)
                        <li data-activity-id="{{ $activity->id }}" data-header="Fechas y Horas" class="clickable-element cursor-pointer text-blue-400 border-b w-min border-blue-400">Fechas y Horas</li>
                    @else
                        <li>No se encontraron fechas.</li>
                    @endif

                    <x-slot name="status">{{ $activity->status }}</x-slot>
                    <x-slot name="activityId">{{ $activity->id }}</x-slot>
                    <x-slot name="activityName">{{ $activity->name }}</x-slot>
                    <x-slot name="color">{{ $activity->color1 }}</x-slot>
                    <x-slot name="color2">{{ $activity->color2 }}</x-slot>
                </x-activity>
            @endforeach
        </div>



        <x-slot name="script">
            {{ asset("js/redirect.js") }}
        </x-slot>

        <x-slot name="script2">
            {{ asset("js/activity.js") }}
        </x-slot>

        <x-slot name="scriptAjax">
            {{ asset("js/activityAjax.js") }}
        </x-slot>

    </div>
        <div class="w-full flex justify-center mt-4">
            {{ $activities->appends(request()->query())->links() }}
        </div>
    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-center">
            <a href="activity/create" class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-[15%]">Registrar</a>
        </div>
    </x-slot>
</x-app-layout>
