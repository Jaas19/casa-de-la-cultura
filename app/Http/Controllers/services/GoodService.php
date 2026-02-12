<?php

namespace App\Http\Controllers\Services;
use App\Models\Good;
use App\Models\Good_Attribute;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodService implements GoodServiceInterface {
    public function createGood (Request $data){

            $common_keys = ['inventory_id', 'name', 'description', 'photo', 'available_amount'];
            $modelId = Good::create($data->only($common_keys))->id;
            $goodAttributes = [];
            $values = $data -> input("value");
            $keys = $data -> input("id_key");
            $now = now();

            if(is_array($values) && is_array($keys)){


            foreach($values as $key => $value){
                $goodAttributes[] = [
                    "id_good" => $modelId,
                    "id_key" => $keys[$key],
                    "value" => $value,
                    "created_at" => $now,
                    "updated_at" => $now,
                ];
            }
        }
        if(!empty($goodAttributes)){
            Good_Attribute::insert($goodAttributes);
        }
    }

    public function updateGood(Request $request, $id)
{
return DB::transaction(function () use ($request, $id) {
        $good = Good::findOrFail($id);

        $common_keys = ['inventory_id', 'name', 'description', 'photo', 'available_amount'];
        $good->update($request->only($common_keys));

        $values = $request->input("value", []);
        $keys = $request->input("id_key", []);

        if (is_array($values) && is_array($keys)) {
            foreach ($keys as $index => $key_id) {
                Good_Attribute::updateOrCreate(
                    [
                        'id_good' => $good->id,
                        'id_key'  => $key_id
                    ],
                    [
                        'value' => $values[$index] ?? null
                    ]
                );
            }
        }

        return $good;
    });
}

    public function listGoodsWithInventory ($ids){
        return Good::whereHas('inventory', function ($query) use ($ids){
            $query->whereIn('user_id', $ids);
        })->get();
    }

    public function listGoods (int $inventoryId){
        return Good::where("inventory_id", "=", $inventoryId)->get();
    }

    public function listGoodsWithAttributes(int $inventoryId) {
        return DB::table('goods')
                            ->leftJoin('good__attributes', 'goods.id', '=', 'good__attributes.id_good')
                            ->get('id_key')
                            ->as();
    }

    public function listGoodsAttributes($inventory_id) {
        $attributes = InventoryAttribute::where("inventory_id", "=", $inventory_id)->get();
            if ($attributes->count() == 0){
                return;
            }
            $whereArray = [];
            if(isset($attributes)){
            foreach($attributes as $attribute){
                if(isset($attribute->id)){
                    $whereArray[] = ['id_key', '=', $attribute->id];
                }
            }
            return Good_Attribute::orWhere($whereArray)->get();
        }
    }

    public function updateGoodStatus(int $goodId, string $status){
        $good = Good::where("id", "=", $goodId)->first();
        $good->status = $status;
        return $good->save();
    }

    public function checkInventoryAttribute(int $inventoryId){

    }
    public function getInventoryAttributeKeys(){

    }
}
