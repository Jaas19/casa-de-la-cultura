<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryAttribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];


    public function attributes(): HasMany{
        return $this->hasMany(InventoryAttribute::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
