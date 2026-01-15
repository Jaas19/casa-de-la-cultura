<?php

namespace App\Http\Controllers\Services;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanService implements LoanServiceInterface{

    protected $movementService;
    public function __construct(MovementServiceInterface $movementService) {
        $this->movementService = $movementService;
    }

    public function getLoans($userId){
        return Loan::where("user_id", $userId)->with('good')->with('user')->with('person')->get();
    }

    public function updateStatus($status, $loanId){
        $loan = Loan::with(['good.inventory'])->findOrFail($loanId);
        if(($loan->status == "given" || $loan->status == "overdue") && $status == "returned"){
            $data = [
            'good_id'  => $loan->good_id,
            'user_id'  => Auth::user()->id,
            'type'     => 'deposit',
            'quantity' => $loan->quantity_requested,
            'inventory_id' => $loan->good->inventory->id];

            $response = $this->movementService->registerMovement($data);
            if (isset($response['error'])) {
            return $response;
            }
        }

        if($loan->status == "returned" && ($status == "given" or $status == "overdue")){
            $data = [
            'good_id'  => $loan->good_id,
            'user_id'  => Auth::user()->id,
            'type'     => 'retire',
            'quantity' => $loan->quantity_requested,
            'inventory_id' => $loan->good->inventory->id];

            $response = $this->movementService->registerMovement($data);

            if (isset($response['error'])) {
            return $response;
        }
        }

        $loan->update(["status" => $status]);

        return $loan->save();
        }


    public function createLoan($request){

        $common_keys = [
        "good_id",
        "person_id",
        "loan_date",
        "retrieval_date",
        "quantity_requested",
        "status"];

        $loan = $request->only($common_keys);
        $loan["user_id"] = Auth::user()->id;

        if($loan['status'] == "given" or $loan['status'] == 'overdue'){

            $data = [
                "good_id" => $loan['good_id'],
                "type" => "retire",
                "quantity" => $loan['quantity_requested']
            ];

            $this->movementService->registerMovement($data);
        }

        return $loan = Loan::create($loan);
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
