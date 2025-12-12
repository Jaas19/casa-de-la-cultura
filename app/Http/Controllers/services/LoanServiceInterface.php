<?php

namespace App\Http\Controllers\Services;

interface LoanServiceInterface {
    public function getLoans($userId);
}