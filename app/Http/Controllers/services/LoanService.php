<?php

namespace App\Http\Controllers\Services;
use App\Models\Loan;
use App\Models\Good;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanService implements LoanServiceInterface{

    protected $movementService;
    public function __construct(MovementServiceInterface $movementService) {
        $this->movementService = $movementService;
    }

    public function getLoans($ids){
        return Loan::whereIn("user_id", $ids)->with('good')->with('user')->with('person')->get();
    }

    public function updateStatus($status, $loanId) {
        return DB::transaction(function () use ($status, $loanId) {
            $loan = Loan::with(['good.inventory'])->findOrFail($loanId);

            $oldLoan = $loan->replicate();
            $oldStatus = $oldLoan->status;

            if (in_array($oldStatus, ['given', 'overdue']) && $status == 'returned') {
                $this->movementService->registerMovement([
                    'good_id' => $loan->good_id,
                    'user_id' => Auth::id(),
                    'type' => 'deposit',
                    'quantity' => $loan->quantity_requested,
                    'inventory_id' => $loan->good->inventory->id
                ]);
            }

            if ($oldStatus == 'returned' && in_array($status, ['given', 'overdue'])) {
                $response = $this->movementService->registerMovement([
                    'good_id' => $loan->good_id,
                    'user_id' => Auth::id(),
                    'type' => 'retire',
                    'quantity' => $loan->quantity_requested,
                    'inventory_id' => $loan->good->inventory->id
                ]);

                if (isset($response['error'])) return $response;
            }

            $loan->update(["status" => $status]);
            if ($loan->user_id != Auth::id()) {
            AuditLog::create([
                "giver_id" => $loan->user_id,
                "collaborator_id" => Auth::id(),
                "model_changed" => "Préstamo ID: " . $loan->id,
                "type" => "Actualización de Estado ($oldStatus -> $status)"
            ]);
            }
            return $loan;
        });
    }


    public function createLoan($request){
    return DB::transaction(function () use ($request) {
        $common_keys = [
            "good_id",
            "person_id",
            "loan_date",
            "retrieval_date",
            "quantity_requested",
            "status"
        ];

        $loanData = $request->only($common_keys);
        $loanData["user_id"] = Auth::user()->id;

        if($loanData['status'] == "given" || $loanData['status'] == 'overdue'){

            $good = Good::findOrFail($loanData['good_id']);

            $movementData = [
                "good_id" => $loanData['good_id'],
                "inventory_id" => $good->inventory_id,
                "user_id" => Auth::id(),
                "type" => "retire",
                "quantity" => $loanData['quantity_requested']
            ];

            $this->movementService->registerMovement($movementData);
        }

        $loan = Loan::create($loanData);
        $good = Good::with('inventory')->find($loan->good_id);
            if ($good->inventory->user_id != Auth::id()) {
                AuditLog::create([
                    "giver_id" => $good->inventory->user_id,
                    "collaborator_id" => Auth::id(),
                    "model_changed" => "Préstamo de: $loan->quantity " . $good->name,
                    "type" => "Creación"
                ]);
            }
        return $loan;
    });
}

    /*

        public function registerMovement(Request $data){
        $good = Good::where("id", "=", $data->good_id)->first();
        $data -> type == "retire" ? $value = 0 - $data->quantity : $value = $data->quantity;
        $newAmount = $good -> available_amount + $value;
        if($newAmount < 0) {
            return ["id" => 0,
            "error" => "No hay suficiente cantidad de este bien en el inventario para efectuar la operación"];
        }
        $good->update(["available_amount" => $newAmount]);
        $result = Movement::create($data->toArray());
        $result['newValue'] = $newAmount;
        return $result;
    }

    */
}
