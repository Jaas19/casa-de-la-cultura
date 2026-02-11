<?php

namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;

interface LoanServiceInterface {
    public function getLoans($ids);
    public function updateStatus($status, $loanId);
    public function createLoan($request);
}
