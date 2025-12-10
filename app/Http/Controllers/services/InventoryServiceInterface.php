<?php
namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\InventoryAttribute;

interface InventoryServiceInterface
{
    public function createInventory($data);
    public function updateInventory($data);
    public function listInventories($id);
    public function getInventoryAttributes($id);
    public function createInventoryAttribute($data);
    public function updateInventoryAttribute($data);
}