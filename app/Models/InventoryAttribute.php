<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryAttribute extends Model
{
    protected $fillable = [
        'inventory_id',
        'key_name',
    ];
}
