<div class="font-sans antialiased flex flex-col justify-center items-center w-full h-full mb-0">

    <x-app-layout>
    <x-slot name="header">
        <form class="redirectForm" action="">
            <select class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
                style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option value="" selected disabled>Regresar</option>
                <option class="redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="redirectOption" value="{{ route("person.index") }}">Personas</option>
            </select>
        </form>
    </x-slot>

    <form action="{{ route('good.store') }}" method="POST">
    @csrf
    <div class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">

                <div>
                    <label for="name">Artículo</label>
                    <input type="text" id="name" name="name" class="block" placeholder="Introduzca el artículo...">
                </div>
                                <div class="row-span-2 overflow-hidden flex flex-col">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" placeholder="Escriba aquí..." maxlength="130" class="block resize-none h-full z-10"></textarea>
                </div>

                <div>
                    <label for="name">Cantidad</label>
                    <input type="text" id="available_amount" name="available_amount" class="block" placeholder="Introduzca la cantidad...">
                </div>

                <div>
                    <label for="inventory">Inventario</label>
                    <select id="inventory" name="inventory_id" class="block" placeholder="Introduzca la cantidad..." required>
                        <option value="" disabled selected>Seleccionar...</option>
                        @foreach ($inventories as $inventory)
                            <option value="{{ $inventory->id }}" class="inventory-option">{{ $inventory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="photo">Foto<span class="font-normal text-gray-500">(opcional)</span></label>
                    <input type="file" name="photo" id="photo" class="text-black2 dark:text-white2">
                </div>

                        @foreach ($inventoriesAttributes as $inventoryId => $inventoryAttributes)
                            @foreach($inventoryAttributes as $inventoryAttribute)
                            <div data-inventory-id="{{ $inventoryId }}" class="good-attribute hidden">
                                <label for="name">{{ $inventoryAttribute->key_name }}</label>
                                <input type="text" name="value[]" class="block good-attribute-input" placeholder="Introduzca el valor...">
                                <input type="hidden" name="id_key[]" value="{{ $inventoryAttribute->id }}">
                            </div>
                            @endforeach
                        @endforeach
            


            </div>
            <div class="flex justify-center w-full items-end p-[5vh]">
                <button type="submit" class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Registrar</button>
            </div>
        </form>
    <x-slot name="script">
        {{ "../js/redirect.js" }}
    </x-slot>
    <x-slot name="script2">
        {{ "../js/goodCreation.js" }}
    </x-slot>
</x-app-layout>
</div>