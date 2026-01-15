<?php

namespace App\Http\Controllers\Services;
use App\Models\Movement;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;
use App\Models\Good;

class MovementService implements MovementServiceInterface {
    public function registerMovement(array $data){
        $good = Good::find($data['good_id']);

        if (!$good) {
            return ["id" => 0, "error" => "El bien no existe"];
        }

        $value = ($data['type'] == "retire") ? -$data['quantity'] : $data['quantity'];

        $newAmount = $good -> available_amount + $value;

        if($newAmount < 0) {
            return ["id" => 0,
            "error" => "No hay suficiente cantidad de este bien en el inventario para efectuar la operación"];
        }

        $good->update(["available_amount" => $newAmount]);

        $result = Movement::create($data);

        $result->newValue = $newAmount;

        return $result;
    }
    public function totalMovementQuantity($inventoryId){
        return Movement::where("inventory_id", "=", $inventoryId)->get();
    }
    public function listMovements($inventoryId){
        return Movement::where("inventory_id", "=", $inventoryId)->get();
    }
}
