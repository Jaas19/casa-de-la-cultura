<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(Inventory::class);
    }

    public function attributes(): HasMany {
        return $this->hasMany(Good_Attribute::class, 'id_good');
    }
}
