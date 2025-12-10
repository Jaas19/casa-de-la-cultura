<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good_Attribute extends Model
{
        protected $fillable = [
        'id_good',
        'id_key',
        'value',
    ];
}