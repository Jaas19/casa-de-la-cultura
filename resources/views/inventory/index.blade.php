<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}" selected disabled>Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
            </select>
        </form>
    </x-slot>
    <x-slot name="element">
        <div class="flex items-center gap-8">
            <button value="{{ route('inventory.update') }}" class="redirect bg-black2 p-[10px] text-md text-gray-500 border border-gray-500">Modificar Inventario</button>
            <select name="inventories" id="inventories" class="bg-white2 dark:bg-black2 text-black2 dark:text-gray-500">
                    <option class="text-center" value="" selected disabled>Seleccionar</option>
                @foreach ($inventories as $inventory)
                    <option class="option" value='{{ $inventory->id }}'>{{ $inventory->name }}</option>
                @endforeach
                    <option value="{{ route('inventory.create') }}">Nuevo inventario</option>
            </select>
            <!--Barra de búsqueda y botón de filtro-->
            <div class="relative flex items-center justify-center">
                <input id="search-good-input" type="text" class="relative dark:bg-black2 dark:text-white2" placeholder="Buscar artículo...">
                <div class="search absolute"></div>
            </div>

            <!--<img src="{{ asset('images/filter.png') }}" alt="" class="cursor-pointer">-->
        </div>

    </x-slot>
    <table class="w-full grid-cols-[auto-fill] table-fixed overflow-auto grow-0">
        <tbody class="overflow-auto w-full relative">
            <tr class="w-full">
                <th>Foto</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                @isset($inventoryAttributes)
                    @foreach ($inventoryAttributes as $Attributes)
                        @foreach ($Attributes as $Attribute)
                        
                        
                    <th class="inventoryHeader hidden" data-inventory-id="{{ $Attribute->inventory_id }}">{{ $Attribute->key_name }}</th>
                        @endforeach
                    @endforeach
                @endisset
            </tr>
                @isset($inventoryGoods)
                    @foreach ($inventoryGoods as $tableGoods)
                        @foreach ($tableGoods as $good)
                            <tr class="inventoryData hidden w-full" data-good-id={{ $good->id }} data-inventory-id="{{ $good->inventory_id }}">
                                <td class="dataField" maxlength="30">{{ $good -> photo }}</td>
                                <td class="dataField" maxlength="30">{{ $good -> name }}</td>
                                <td class="dataField text-balance" maxlength="30">{{ 
                                strlen($good -> description) > 60 
                                ? substr($good -> description, 0, 60) . "..." 
                                : $good -> description 
                                }}</td>
                                <td class="dataField" maxlength="30">{{ $good -> available_amount }}</td>
                                @foreach ($goodsAttributes as $attributes)
                                    @foreach ($attributes as $attribute)
                                        @if ($attribute -> id_good == $good -> id)
                                            <td class="dataField">{{ $attribute -> value }}</td>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                @endisset
        </tbody>
    </table>
    

    <x-slot name="footer">
        @csrf
        <div class="bg-gradient-to-r from-yellow-950 to-yellow-900 min-w-full p-6 text-sm flex items-center justify-evenly">
            <input type="hidden" id="goodId" name="good_id" value="0">
            <input type="hidden" id="inventoryId" name="inventory_id" value="0">
            <input type="hidden" id="userId" name="user_id" value="{{ $user_id }}">
            
            <a href="good/create" id="register-button" class="rounded-3xl bg-sky-500 text-md font-bold text-white2 black_contour p-3">Registrar</a>
            <button id="suspend-button" class="rounded-3xl bg-red-600 text-md font-bold text-white2 black_contour p-3">Suspender</button>
            <input class="sm:w-36 bg-black2 text-gray-500 w-[84px]" type="text" id="quantity" name="quantity" placeholder="Monto...">
            <button id="retire-button" class="rounded-3xl bg-orange-500 text-md font-bold text-white2 black_contour p-3">Retirar</button>
            <button id="deposit-button" class="rounded-3xl bg-green-500 text-md font-bold text-white2 black_contour p-3">Depositar</button>
        </div>
    </x-slot>

    <x-slot name="script">
        {{ "./js/inventory.js" }}
    </x-slot>
    <x-slot name="scriptAjax">
        {{ "./js/inventoryAjax.js" }}
    </x-slot>
    <x-slot name="script2">
    {{ "../js/redirect.js" }}
    </x-slot name="script">

</x-app-layout>