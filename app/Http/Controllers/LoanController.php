<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\LoanServiceInterface;
use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\PersonServiceInterface;
use App\Http\Controllers\Services\InventoryServiceInterface;

class LoanController extends Controller
{
    protected $loanService;
    protected $goodService;
    protected $inventoryService;
    protected $personService;

    public function __construct(LoanServiceInterface $loanService, GoodServiceInterface $goodService, PersonServiceInterface $personService, InventoryServiceInterface $inventoryService) {
        $this->loanService = $loanService;
        $this->goodService = $goodService;
        $this->inventoryService = $inventoryService;
        $this->personService = $personService;
    }

    public function index() {
        $ids = Auth::user()->keys();
        $loans = $this->loanService->getLoans($ids);
        return view('loan.index', compact("loans"));
    }

    public function patch(Request $request) {
        $this->loanService->updateStatus($request->status, $request->id);
    }

    public function create(){
        $ids = Auth::user()->keys();
        $goods = $this->goodService->listGoodsWithInventory($ids);
        $inventories = $this->inventoryService->listInventories($ids);
        $persons = $this->personService->listPersons();
        return view("loan.create", compact("goods", "persons", "inventories"));
    }

    public function store(Request $request){
        $this->loanService -> createLoan($request);
        return redirect(route("loan.index"));
    }
}
