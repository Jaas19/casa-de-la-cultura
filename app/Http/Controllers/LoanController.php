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
        Auth::id();
        return view('loan.index');
    }
}
