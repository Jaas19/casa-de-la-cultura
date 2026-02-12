<?php

namespace App\Http\Controllers\Services;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $oldInventory = $inventory->replicate();
        $inventoryName = $oldInventory->name;
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
        if($inventory->user_id != Auth::id()){
            AuditLog::create([
            "giver_id" => $inventory->user_id,
            "collaborator_id" => Auth::id(),
            "model_changed" => "Inventario: $inventoryName",
            "type" => "Actualización"
        ]);
        }
    }
    public function listInventories($ids){
        $inventories = Inventory::whereIn("user_id", $ids)->with('user')->get();
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
