<x-app-layout>
    <x-slot name="header">
        {{ __("Creación de atributos") }}
    </x-slot>
    <div class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">
        <div>
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="block" placeholder="Introduzca el nombre...">
        </div>
        <div>
            <label for="inventory">Inventario</label>
            <select name="inventory" id="inventory" class="block">
                <option value="1">Muebles</option>
                <option value="2">Routers</option>
            </select>
        </div>
        <div>
            <label for="inventory">Tipo</label>
            <select name="inventory" id="inventory" class="block">
                <option value="1">Números</option>
                <option value="2">Letras/Números/Símbolos</option>
            </select>
        </div>
    </div>
    <div class="flex justify-center w-full h-full items-end p-[5vh]">
        <button class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Registrar</button>
    </div>
    
    

</x-app-layout>