<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\InventoryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->inventoryService->createInventory($data);
        return redirect(route("inventory.index"));
    }

    public function patch(Request $data){
        $this -> inventoryService -> updateInventory($data);
        return redirect(route('inventory.index'));
    }
}
