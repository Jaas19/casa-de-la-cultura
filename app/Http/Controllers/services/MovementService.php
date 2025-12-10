<?php

namespace App\Http\Controllers\Services;
use App\Models\Movement;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;
use App\Models\Good;

class MovementService implements MovementServiceInterface {
    public function registerMovement(Request $data){
        $good = Good::where("id", "=", $data->good_id)->first();
        $data -> type == "retire" ? $value = 0 - $data->quantity : $value = $data->quantity;
        $newAmount = $good -> available_amount + $value;
        if($newAmount < 0) {
            return ["id" => 0, 
            "error" => "No hay suficiente cantidad de este bien en el inventario para efectuar la operación"];
        }
        $good->update(["available_amount" => $newAmount]);
        $result = Movement::create($data->toArray());
        $result['newValue'] = $newAmount;
        return $result;
    }
    public function totalMovementQuantity($inventoryId){
        return Movement::where("inventory_id", "=", $inventoryId)->get();
    }
    public function listMovements($inventoryId){
        return Movement::where("inventory_id", "=", $inventoryId)->get();
    }
}