<?php

namespace App\Http\Controllers;
use App\Models\Position;
use App\Models\PositionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    protected $messages = [
        "name.regex" => "El nombre solo puede contener letras, números y puntuación básica.",
        "name.string" => "El nombre no es válido.",
        "name.required" => "Por favor, escriba el nombre.",
        "name.min" => "El nombre es muy corto.",
        "name.max" => "El nombre es muy largo",
        "name.unique" => "El nombre ya existe",
        "position_type_id.required" => "Por favor, seleccione una vinculación.",
        "position_type_id.exists" => "La vinculación seleccionada no existe."
    ];
    public function create(){
        $positionTypes = PositionType::all();
        return view("position.create", compact("positionTypes"));
    }

    public function edit(){
        $positions = Position::all();
        $positionTypes = PositionType::all();
        return view("position.update", compact("positionTypes", "positions"));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            "name" => ["regex:/^[\pL\s\d\.\(\)\-]+$/u", "string", "required", "min:3", "max:100", "unique:positions,name"],
            "position_type_id" => ["required", "exists:position_types,id"],
        ], $this->messages);
        try{
            Position::create($validatedData);
            return redirect()->route("person.index")->with("success", "Perfil creado exitosamente.");
        } catch(\Exception $e) {
            return back()->with("error", "Hubo un error, intente de nuevo más tarde.")->withInput();
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            "name" => ["regex:/^[\pL\s\d\.\(\)\-]+$/u", "string", "required", "min:3", "max:100", "unique:positions,name," . $request->name],
            "position_type_id" => ["required", "exists:position_types,id"],
            "id" => ["required", "exists:positions,id"],
        ], $this->messages);
        try{
            $position = Position::find($validatedData["id"]);
            $position->update($validatedData);
            return redirect()->route("person.index")->with("success", "Perfil actualizado exitosamente.");
        } catch(\Exception $e) {
            return back()->with("error", "Hubo un error, intente de nuevo más tarde.")->withInput();
        }
    }
}
