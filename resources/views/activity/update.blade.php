<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm" class="z-10">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
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
            <a href="{{ route("activity.index") }}"
                class="text-white2
                text-2xl black_contour font-black mr-5">
                Editar actividad
            </a>
        </h3>

    </x-slot>
    <form action="{{ route('activity.patch') }}" method="POST">
        @method("PATCH")
        @csrf
        <div id="activity-form-div" class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
            <input type="hidden" name="id" value="{{ $activity->id }}">
            <div>
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" value="{{ $activity->name }}" class="block" placeholder="Introduzca el nombre...">
            </div>
            <div>
                <label for="status">Estado</label>
                <select name="status" class="block">
                    <option value="Suspendida" {{ $activity->status == "Suspendida" ? "selected" : ""}}>Suspendida</option>
                    <option value="Activa" {{ $activity->status == "Activa" ? "selected" : ""}}>Activa</option>
                    <option value="En Espera" {{ $activity->status == "En Espera" ? "selected" : ""}}>En Espera</option>
                    <option value="Completada" {{ $activity->status == "Completada" ? "selected" : ""}}>Completada</option>
                    <option value="Pospuesta" {{ $activity->status == "Pospuesta" ? "selected" : ""}}>Pospuesta</option>
                    <option value="En Progreso" {{ $activity->status == "En Progreso" ? "selected" : ""}}>En Progreso</option>
                </select>
            </div>
            <div>
                <label for="">Importante</label>
                <input type="checkbox" name="important" value="1" {{ $activity->important == 1 ? "checked" : "" }}>
            </div>


            <!--Campos Adicionales-->

            @php
                $i = 1
            @endphp
            @foreach ($activityDates['dates'] as $date)
                <div class="col-span-2">
                    <h1 class="text-white2 font-black text-center border-b pb-2 my-8 text-xl">Fecha {{ $i }}</h1>
                </div>

                <div class="col-start-1">
                    <label>Fecha</label>
                    <input required class="block" type="date" name="date[{{ $date->id }}][date]" placeholder="Introduzca la Fecha..." value="{{ \Carbon\Carbon::createFromFormat('d/m/Y', $date->date)->format('Y-m-d') }}">
                </div>

                @foreach ($activityDates['hours'][$date->id] as $hour)

                <div class="col-start-1">
                    <label>Hora de inicio</label>
                    <input required class="block" type="time" name="date[{{ $date->id }}][starting_time][]" value="{{ \Carbon\Carbon::parse($hour->starting_time)->format('H:i') }}">
                </div>

                <div>
                    <label>Hora de fin</label>
                    <input required class="block" type="time" name="date[{{ $date->id }}][ending_time][]" value="{{ \Carbon\Carbon::parse($hour->ending_time)->format('H:i') }}">
                </div>
                @endforeach

                <div class="new-hour-update-button col-span-2 bg-yellow-900 text-md
                text-center font-bold text-white2 black_contour
                py-3 hover:bg-yellow-800 transition w-[25%]
                self-center justify-center" data-date-id="{{ $date->id }}">
                Agregar Hora
                </div>


                @php
                    $i += 1
                @endphp
            @endforeach
            <div id="number-of-dates" class="hidden" data-date-count="{{ $i - 1 }}"></div>

            <div class="flex items-center justify-right col-span-2">
                <div id="add-date" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition w-[25%] self-center justify-center">
                    Agregar Fecha
                </div>
            </div>


            @php
                $i = 1
            @endphp

            @foreach ($activityGoods as $activityGood)
                <div class="col-span-2">
                    <h1 class="text-white2 font-black text-center border-b pb-2 my-8 text-xl">Bien {{ $i }}</h1>
                </div>
                    <div>
                        <label>Bien</label>
                        <select class="block" name="good_id[]" id="">
                            <option disabled="true" value="">Seleccionar...</option>
                            @foreach ($goods as $inventory_goods)
                                @foreach ($inventory_goods as $good)
                                    <option {{ $good->id == $activityGood->good_id ? 'selected' : '' }} class="selectable-good-option" value="{{ $good->id }}" data-inventory-id="{{ $good->inventory_id }}" data-good-count="{{ $i }}">{{ $good->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Inventario</label>
                        <select class="inventory-select-input block" data-good-count="{{ $i }}" disabled="true">
                            <option></option>
                        </select>
                    </div>

                    <div>
                        <label>Cantidad</label>
                        <input
                        class="block"
                        type="text"
                        name="quantity_requested[]"
                        placeholder="Introducir Cantidad..."
                        value="{{ $activityGood->quantity_requested }}">
                    </div>
                @php
                    $i += 1
                @endphp
            @endforeach
            <div id="number-of-goods" class="hidden" data-good-count="{{ $i - 1 }}"></div>

            <div class="flex items-center justify-right col-span-2">
                <div id="add-good" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition w-[25%] self-center justify-center">
                    Agregar Bien
                </div>
            </div>

            @php
                $i = 1
            @endphp
            @foreach ($activityOrganizers as $organizer)
                <div class="col-span-2 col-start-1">
                    <h1 class="text-white2 font-black text-center border-b pb-2 my-8 text-xl">Organizador {{ $i }}</h1>
                </div>
                <div>
                    <label>Organizador</label>
                    <input value="{{ $organizer->name }}" class="block" type="text" name="organizer_name[]" placeholder="Indique el Organizador...">
                </div>
                @php
                    $i += 1
                @endphp
            @endforeach
            <div id="number-of-organizers" class="hidden" data-organizer-count="{{ $i - 1 }}"></div>

            <div class="flex items-center justify-right col-span-2 text-nowrap">
                <div id="add-organizer" class="bg-yellow-900 text-md text-center font-bold text-white2 black_contour py-3 hover:bg-yellow-800 transition w-[25%] self-center justify-center">
                    Agregar Organizador
                </div>
            </div>

        </div>





    <div class="flex justify-center w-full items-end p-[5vh]">
        <button class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">
            Guardar Cambios
        </button>
    </div>
    </form>

    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

    <x-slot name="script2">
        {{ asset("js/activityCreation.js") }}
    </x-slot>

    <x-slot name="script3">
        {{ asset("js/activityUpdate.js") }}
    </x-slot>

    <script>
        const goods = @json($goods);
        const inventories = @json($inventories);
    </script>

</x-app-layout>
