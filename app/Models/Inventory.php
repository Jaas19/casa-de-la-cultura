<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryAttribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];


    public function attributes(): HasMany{
        return $this->hasMany(InventoryAttribute::class);
    }

}
