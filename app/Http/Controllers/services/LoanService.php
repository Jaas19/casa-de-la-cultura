<?php

namespace App\Http\Controllers\Services;
use App\Models\Loan;
class LoanService implements LoanServiceInterface{
    public function getLoans($userId){
        Loan::where("user_id", $userId)->get();
    }
}