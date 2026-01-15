<?php

namespace App\Http\Controllers\Services;
use App\Models\Movement;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;

interface MovementServiceInterface {
    public function registerMovement(array $data);
    public function totalMovementQuantity($inventoryId);
    public function listMovements($inventoryId);
}
