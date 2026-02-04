<?php

namespace App\Http\Controllers;
use App\Models\Position;
use App\Models\PositionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionTypeController extends Controller
{
    protected $messages = [
        "" => ""
    ];
    public function create(){
        $positionTypes = PositionType::all();
        return view("position_type.create");
    }

    public function edit(){
        $positionTypes = PositionType::all();
        return view("position_type.update", compact("positionTypes"));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            "name" => ["regex:/^[\pL\s\d\.\(\)\-]+$/u", "string", "required", "min:3", "max:50", "unique:positions_types,name"],
        ], $this->messages);
        try{
            PositionType::create($validatedData);
            return redirect()->route("person.index")->with("success", "Perfil actualizado exitosamente.");
        } catch(\Exception $e) {
            return back()->with("error", "Hubo un error, intente de nuevo más tarde.")->withInput();
        }
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            "name" => ["regex:/^[\pL\s\d\.\(\)\-]+$/u", "string", "required", "min:3", "max:50", "unique:position_types,name," . $request->id],
            "id" => ["required", "exists:position_types,id"],
        ], $this->messages);
        try{
            $positionType = PositionType::find($validatedData["id"]);
            $positionType->update($validatedData);
            return redirect()->route("person.index")->with("success", "Vinculación actualizada exitosamente.");
        } catch(\Exception $e) {
            return back()->with("error", "Hubo un error, intente de nuevo más tarde.")->withInput();
        }
    }
}
