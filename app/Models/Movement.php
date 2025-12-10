<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
        protected $fillable = [
        'good_id',
        'inventory_id',
        'user_id',
        'quantity',
        'description',
        'type'
    ];
}
