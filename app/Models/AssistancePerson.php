<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AssistancePerson extends Model
{
    protected $fillable = [
        'user_id',
        'person_id'
    ];

    public function person(): BelongsTo {
        return $this->belongsTo(Person::class);
    }
}
