<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Good extends Model
{
        protected $fillable = [
        'inventory_id',
        'name',
        'description',
        'photo',
        'available_amount'
    ];

    public function inventory(): BelongsTo {
        return $this->belongsTo(inventory::class);
    }
}
