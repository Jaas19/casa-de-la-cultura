<?php

namespace App\Http\Controllers\Services;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;

class InventoryService implements InventoryServiceInterface {
    public function createInventory($data) {
        
        $inventory = Inventory::create($data->toArray());
        if(isset($data->key_name) && isset($inventory)){
            foreach($data->key_name as $key){
                InventoryAttribute::create(
            ["inventory_id" => $inventory->id,
            "key_name" => $key]);

            }
        }
        return $inventory;
    }
    public function updateInventory($data){
        $inventory = Inventory::find($data->id);
        $inventory->update(["name" => $data->name]);
        return $inventory->save();
    }
    public function listInventories($id){
        $inventories = Inventory::where("user_id", "=", $id)->get();
        return $inventories;
    }

    public function getInventoryAttributes($id){
        return InventoryAttribute::where('inventory_id', '=', $id)->get();
    }

    public function createInventoryAttribute($data){
        return InventoryAttribute::create($data->toArray());
    }
    public function updateInventoryAttribute($data){
        return InventoryAttribute::update($data->toArray());
    }
}