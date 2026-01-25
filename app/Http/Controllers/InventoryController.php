<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\InventoryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryAttribute;
use App\Models\Inventory;

class InventoryController extends Controller
{
    protected $goodService;
    protected $inventoryService;
    public function __construct(InventoryServiceInterface $inventoryService, GoodServiceInterface $goodService){
        $this -> inventoryService = $inventoryService;
        $this -> goodService = $goodService;
    }
    public function index(){
        $inventories = $this -> inventoryService -> listInventories(Auth::id());
        $inventoryGoods = [];
        $inventoryAttributes = [];
        $goodsAttributes = [];
        foreach($inventories as $inventory){
            $inventoryGoods[$inventory->id] = $this -> goodService -> listGoods($inventory->id);
            $inventoryAttributes[$inventory->id] = $this -> inventoryService -> getInventoryAttributes($inventory->id);
            $goodsAttributes[$inventory->id] = $this -> goodService -> listGoodsAttributes($inventory->id);

            if($goodsAttributes[$inventory->id] == null) {
                unset($goodsAttributes[$inventory->id]);
            }
        }
        $user_id = Auth::id();
        return view('inventory.index', compact("inventories", "inventoryGoods", "inventoryAttributes", "goodsAttributes", 'user_id'));
    }

    public function create() {
        $userId = Auth::id();
        return view('inventory.create', compact('userId'));
    }
    public function update() {
        $userId = Auth::id();
        $inventories = $this->inventoryService -> listInventories($userId);
        return view('inventory.update', compact('userId', 'inventories'));
    }

    public function store(Request $data) {
            $validatedData = $data->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'attributes' => 'nullable|array',
            'attributes.*.key_name' => 'required|string|max:255',
            'attributes.*.type' => 'required|in:text,paragraph,numeric,boolean',
        ],
        [
            'name.required' => 'El nombre del inventario es obligatorio.',
            'name.string' => 'El nombre no es válido.',
            'name.max' => 'El nombre es muy largo.',
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.exists' => 'El usuario seleccionado no es existe.',
            'attributes.array' => 'El formato de los atributos es incorrecto.',
            'attributes.*.key_name.required' => 'El nombre del atributo es obligatorio.',
            'attributes.*.key_name.string' => 'El nombre del atributo no es válido.',
            'attributes.*.key_name.max' => 'El nombre del atributo no puede superar los 255 caracteres.',
            'attributes.*.type.required' => 'El tipo de dato es obligatorio para cada atributo.',
            'attributes.*.type.in' => 'El tipo de atributo seleccionado no es válido.',
        ]);
        try {
            $this->inventoryService->createInventory($validatedData);
            return redirect()->route('inventory.index')->with('success', 'Inventario creado con éxito');
        } catch(\Exception $e){
            return back()->with("error", "No se pudo crear el inventario, intente más tarde.")->withInput();
        }

    }

    public function patch(Request $data){
        $this -> inventoryService -> updateInventory($data);
        return redirect(route('inventory.index'));
    }

    public function attributes(Request $request){
        $inventory = Inventory::find($request->inventory_id);
        if(!$inventory || $inventory->user_id != Auth::id()){
            return;
        }
        $attributes = InventoryAttribute::where("inventory_id", $request->inventory_id)->get();
        return response()->json($attributes);
    }
}
