<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Position extends Model
{
    protected $fillable = [
        'name',
        'position_type_id',
    ];


    public function type(): BelongsTo
    {
        return $this->belongsTo(PositionType::class, "position_type_id");
    }
}
