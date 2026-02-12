<?php

namespace App\Http\Controllers;
use App\Models\Good;
use App\Models\Good_Attribute;
use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\InventoryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
{
    protected $goodService;
    protected $inventoryService;
    public function __construct(InventoryServiceInterface $inventoryService, GoodServiceInterface $goodService){
        $this -> inventoryService = $inventoryService;
        $this -> goodService = $goodService;
    }
    public function create(){
        $ids = Auth::user()->keys();
        $inventories = $this -> inventoryService -> listInventories($ids);
        $inventoriesAttributes = [];
        foreach($inventories as $inventory){
            $inventoriesAttributes[$inventory->id] = $this->inventoryService->getInventoryAttributes($inventory->id);
        }
        return view("good.create", compact("inventories", "inventoriesAttributes"));
    }

    public function edit(Good $good){
        $good->load('attributes');
        $ids = Auth::user()->keys();
        $inventories = $this -> inventoryService -> listInventories($ids);
        $inventoriesAttributes = [];
        foreach($inventories as $inventory){
            $inventoriesAttributes[$inventory->id] = $this->inventoryService->getInventoryAttributes($inventory->id);
        }
        return view("good.edit", compact("good", "inventories", "inventoriesAttributes"));
    }

    public function store(Request $data) {
        $request->validate([
        'inventory_id' => 'required|exists:inventories,id',
        'name' => 'required|string|max:255',
        'available_amount' => 'required|integer|min:0',
        'description' => 'nullable|string|max:255',
        'id_key' => 'nullable|array',
        'value' => 'nullable|array',
    ], [
        'inventory_id.required' => "El inventario es obligatorio.",
        'inventory_id.exists' => "El inventario seleccionado no existe.",
        'name.required' => 'El nombre del bien es obligatorio.',
        'name.max' => 'El nombre del bien es muy largo.',
        'name.string' => 'El nombre del bien no es válido.',
        'description.string' => "La descripción no es válida.",
        'description.max' => "La descripción es muy larga.",
        'available_amount.required' => 'La cantidad disponible es obligatoria.',
        'available_amount.integer' => 'La cantidad disponible debe ser un número entero.',
        'available_amount.min' => 'La cantidad disponible no puede ser negativa.',
        'id_key.array' => "Los campos extra son inválidos.",
        'value.array' => "El valor de los campos extra son inválidos.",
    ]);
        $this->goodService->createGood($data);
        return redirect(route("inventory.index"));
}
    public function patch(Request $request, Good $good){
        $request->validate([
        'inventory_id' => 'required|exists:inventories,id',
        'name' => 'required|string|max:255',
        'available_amount' => 'required|integer|min:0',
        'description' => 'nullable|string|max:255',

        'id_key' => 'nullable|array',
        'id_key.*' => 'exists:inventory_attributes,id',
        'value' => 'nullable|array',
        'value.*' => 'nullable|string|max:255',
    ], [
        'inventory_id.required' => "El inventario es obligatorio.",
        'inventory_id.exists' => "El inventario seleccionado no existe.",
        'name.required' => 'El nombre del bien es obligatorio.',
        'name.max' => 'El nombre del bien es muy largo.',
        'name.string' => 'El nombre del bien no es válido.',
        'description.string' => "La descripción no es válida.",
        'description.max' => "La descripción es muy larga.",
        'available_amount.required' => 'La cantidad disponible es obligatoria.',
        'available_amount.integer' => 'La cantidad disponible debe ser un número entero.',
        'available_amount.min' => 'La cantidad disponible no puede ser negativa.',
        'id_key.array' => "Los campos extra son inválidos.",
        'value.array' => "El valor de los campos extra son inválidos.",
    ]);
    try {
        $this->goodService->updateGood($request, $good->id);
        return redirect()->route("inventory.index")
                         ->with('success', 'Bien actualizado correctamente');
    } catch (\Exception $e) {
        Log::error("Error en patch de Good ID {$good->id}: " . $e->getMessage());
        return back()->withInput()
                     ->with('error', 'Ocurrió un error al actualizar el bien.');
    }
    }
}
