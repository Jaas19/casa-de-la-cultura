<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Services\LoanServiceInterface;
use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\PersonServiceInterface;
use App\Http\Controllers\Services\InventoryServiceInterface;
use Illuminate\Support\Facades\Log;

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
    $request->validate([
        'id' => 'required|exists:loans,id',
        'status' => 'required|in:given,returned,overdue'
    ]);

    try {
        $response = $this->loanService->updateStatus($request->status, $request->id);

        if (isset($response['error'])) {
            return response()->json(['success' => false, 'message' => $response['error']], 400);
        }

        return response()->json(['success' => true, 'message' => 'Estado actualizado.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error en el servidor.'], 500);
    }
    }

    public function create(){
        $ids = Auth::user()->keys();
        $goods = $this->goodService->listGoodsWithInventory($ids);
        $inventories = $this->inventoryService->listInventories($ids);
        $persons = $this->personService->listPersons();
        return view("loan.create", compact("goods", "persons", "inventories"));
    }

    public function store(Request $request){
    $request->validate([
        'good_id' => [
            'required',
            Rule::exists('goods', 'id')->where(function ($query) use ($request) {
                return $query->where('inventory_id', $request->inventory_id);
            }),
        ],
        'person_id' => 'required|exists:people,id',
        'loan_date' => 'required|date',
        'retrieval_date' => 'required|date|after_or_equal:loan_date',
        'quantity_requested' => 'required|integer|min:1',
        'status' => 'required|in:given,returned,overdue,requested',
    ], [
        'good_id.required' => 'Debe seleccionar un bien del inventario.',
        'good_id.exists' => 'El bien seleccionado no pertenece al inventario indicado.',
        'person_id.required' => 'Debe seleccionar a la persona que solicita el préstamo.',
        'person_id.exists' => 'La persona seleccionada no está registrada.',

        'loan_date.required' => 'La fecha de préstamo es obligatoria.',
        'loan_date.date' => 'La fecha de préstamo no tiene un formato válido.',
        'retrieval_date.required' => 'La fecha de devolución es obligatoria.',
        'retrieval_date.after_or_equal' => 'La fecha de devolución no puede ser anterior a la fecha en que se entregó el bien.',

        'quantity_requested.required' => 'Debe indicar la cantidad a prestar.',
        'quantity_requested.integer' => 'La cantidad debe ser un número entero.',
        'quantity_requested.min' => 'La cantidad mínima para un préstamo es 1.',
        'status.required' => 'El estado del préstamo es obligatorio.',
        'status.in' => 'El estado seleccionado no es válido para este registro.',
    ]);

    try {
        $result = $this->loanService->createLoan($request);

        if (isset($result['error'])) {
            return back()->withInput()->with('error', $result['error']);
        }

        return redirect()->route("loan.index")->with('success', 'Préstamo registrado correctamente.');
    } catch (\Exception $e) {
        dd($e);
        Log::error("Error en LoanStore: " . $e->getMessage());
        return back()->withInput()->with('error', 'Ocurrió un error inesperado.');
    }
    }
}
