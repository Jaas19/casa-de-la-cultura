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
        $inventories = $this -> inventoryService -> listInventories(Auth::id());
        $inventoriesAttributes = [];
        foreach($inventories as $inventory){
            $inventoriesAttributes[$inventory->id] = $this->inventoryService->getInventoryAttributes($inventory->id);
        }
        return view("good.create", compact("inventories", "inventoriesAttributes"));
    }

    public function store(Request $data) {
        $this->goodService->createGood($data);
        return redirect(route("inventory.index"));
}
    public function patch(Request $data){
        return $this->goodService->updateGoodStatus($data->id, $data->status);
    }
}
