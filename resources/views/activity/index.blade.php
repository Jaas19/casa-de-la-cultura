<x-app-layout>
    <div class="activity px-10 py-14 flex flex-wrap justify-evenly gap-y-14">
        <x-slot name="header">
            <div class="flex items-center relative w-full">
            <div class="flex w-full justify-between">
            <form action="" id="redirectForm">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                    <option class="bg-black2 redirectOption" selected disabled>Actividades</option>
                    <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                    <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                    <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                    <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                    <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                    <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>

                </select>
            </form>

            <input type="text" placeholder="Buscar..." class="bg-black2">

            <select id="filter-activity-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}')">
                <option class="bg-black2 filter-activity-option" value="Todas">Todas</option>
                <option class="bg-black2 filter-activity-option" value="Activa">Activas</option>
                <option class="bg-black2 filter-activity-option" value="En Espera">En Espera</option>
                <option class="bg-black2 filter-activity-option" value="En Progreso">En Progreso</option>
                <option class="bg-black2 filter-activity-option" value="Completada">Completadas</option>
                <option class="bg-black2 filter-activity-option" value="Pospuesta">Pospuestas</option>
                <option class="bg-black2 filter-activity-option" value="Suspendida">Suspendidas</option>
            </select>
            </div>
            </div>
        </x-slot>


        <div class="opacity-0 hidden outline outline-1 dark:outline-gray-600 flex-col text-black2 dark:text-white2 transition-opacity details-window fixed w-svw sm:w-[30vw] h-svh bg-white-2 dark:bg-black2 top-0 right-0 z-10 px-7 py-5">
            <header class="relative flex items-center justify-center mb-6">
                <h3 class="details-header text-center text-3xl">Fechas y Horas</h3>
            </header>
            <main id="details-body" class="overflow-auto flex flex-col gap-6">
            </main>
        </div>

        <!-- Cargado de clases al archivo css de tailwind
        from-red-500 to-red-300
        from-purple-400 to-purple-200
        from-orange-400 to-orange-200
        from-lime-400 to-lime-200
        from-yellow-400 to-yellow-100
        from-cyan-400 to-cyan-200

        border-red-500 border-red-300
        border-purple-400 border-purple-200
        border-orange-400 border-orange-200
        border-lime-400 border-lime-200
        border-yellow-400 border-yellow-100
        border-cyan-400 border-cyan-200

        text-red-500 text-red-300
        text-purple-400 text-purple-200
        text-orange-400 text-orange-200
        text-lime-400 text-lime-200
        text-yellow-400 text-yellow-100
        text-cyan-400 text-cyan-200

        bg-white2 text-black2 rounded-2xl p-3 text-xl p-3 text-center

        "></div>
        -->
       
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

        <x-slot name="script">
            {{ "./js/redirect.js" }}
        </x-slot>

        <x-slot name="script2">
            {{ "./js/activity.js" }}
        </x-slot>

        <x-slot name="scriptAjax">
            {{ "./js/activityAjax.js" }}
        </x-slot>

    </div>
    <x-slot name="footer">
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-center">
            <a href="activity/create" class="rounded-3xl bg-black2 text-md font-bold text-white2 black_contour p-3 text-center w-[15%]">Registrar</a>
        </div>
    </x-slot>
</x-app-layout>
