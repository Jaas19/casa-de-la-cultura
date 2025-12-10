<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Position;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    protected $fillable = [
        'name',
        'lastname',
        'dni',
        'sex',
        'image',
        'phone_number',
        'position_id',
        'status'
    ];

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class);
    }
}
