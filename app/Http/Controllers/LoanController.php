<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\LoanServiceInterface;

class LoanController extends Controller
{
    protected $loanService;
        public function __construct(LoanServiceInterface $loanService) {
        $this->loanService = $loanService;
    }
    
    public function index() {
        $userId = Auth::id();
        $loans = $this->loanService->getLoans($userId);
        return view('loan.index', compact("loans"));
    }
}
