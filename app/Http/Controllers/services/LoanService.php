<?php

namespace App\Http\Controllers\Services;
use App\Models\Loan;
class LoanService implements LoanServiceInterface{
    public function getLoans($userId){
        return Loan::where("user_id", $userId)->with('good')->with('user')->with('person')->get();
    }
}