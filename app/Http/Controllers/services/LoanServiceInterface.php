<?php

namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;

interface LoanServiceInterface {
    public function getLoans($userId);
    public function updateStatus($status, $loanId);
    public function createLoan($request);
}
