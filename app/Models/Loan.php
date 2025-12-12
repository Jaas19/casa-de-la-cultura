<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations;

class Loan extends Model
{
    protected $fillable = [
        "user_id",
        "good_id",
        "person_id",
        "loan_date",
        "retrieval_date",
        "quantity_requested"
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function good_id(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }
    public function person_id(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
