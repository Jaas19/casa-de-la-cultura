<?php

namespace App\Http\Controllers\Services;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryService implements InventoryServiceInterface {
    public function createInventory($data) {
        return DB::transaction(function () use ($data){
            $inventory = Inventory::create([
                'name' => $data['name'],
                'user_id' => $data['user_id'],
            ]);

            if(!empty($data['attributes'])){
                $inventory->attributes()->createMany($data['attributes']);
            }
        });

    }
    public function updateInventory($data){
        $inventory = Inventory::find($data->id);
        $inventory->update(["name" => $data->name]);

        $attributes = $data->input('attributes', []);
        $ids = collect($attributes)->pluck('id')->filter();
        $inventory->attributes()->whereNotIn('id', $ids)->delete();

        $toInsert = [];
        $toUpdate = [];
        $now = Carbon::now();

        foreach ($attributes as $attribute) {
            if (empty($attribute['id'])) {
                $toInsert[] = [
                    'inventory_id' => $inventory->id,
                    'key_name' => $attribute['key_name'],
                    'type' => $attribute['type'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            } else {
                $toUpdate[] = [
                    'id' => $attribute['id'],
                    'inventory_id' => $inventory->id,
                    'key_name' => $attribute['key_name'],
                    'type' => $attribute['type'],
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($toInsert)) {
            InventoryAttribute::insert($toInsert);
        }

        if (!empty($toUpdate)) {
            InventoryAttribute::upsert(
                $toUpdate, ['id'], ['key_name', 'type', 'updated_at']
            );
        }
        $inventory->save();
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
