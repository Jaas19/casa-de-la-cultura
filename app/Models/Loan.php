<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Loan extends Model
{
    protected $fillable = [
        "user_id",
        "good_id",
        "person_id",
        "loan_date",
        "retrieval_date",
        "quantity_requested",
        "status"
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function good(): BelongsTo {
        return $this->belongsTo(Good::class);
    }

    public function person(): BelongsTo {
        return $this->belongsTo(Person::class);
    }
}
