<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
        protected $fillable = [
        'inventory_id',
        'name',
        'description',
        'photo',
        'available_amount'
    ];
}
