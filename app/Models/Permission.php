<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    protected $fillable = [
        "giver_id",
        "collaborator_id",
    ];


    public function giver(): BelongsTo
    {
        return $this->belongsTo(User::class, "giver_id");
    }
    public function collaborator(): BelongsTo
    {
        return $this->belongsTo(User::class, "collaborator_id");
    }
}
