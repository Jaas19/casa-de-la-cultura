<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Services\PersonServiceInterface;
use App\Models\AssistancePerson;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PersonService implements PersonServiceInterface{
    public function listPersons(){
        return Person::with('position')->get();
    }

    public function findPerson($id){
        return Person::with('position')->find($id);
    }
    public function updatePerson($request){
        $person = $this->findPerson($request->id);
        $rules = [
            'name' => 'required|string|max:40',
            'lastname' => 'required|string|max:40',
            'dni' => 'required|numeric|unique:people,dni,' . $request->id,
            'sex' => 'required|in:Masculino,Femenino,Otro',
            'image' => 'nullable|image|max:4096',
            'phone_number' => 'required|string|max:12',
            'position_id' => 'required|exists:positions,id',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'lastname.required' => 'El apellido es obligatorio.',
            'dni.required' => 'La cédula es obligatoria.',
            'phone_number.required' => 'El número de teléfono es obligatorio.',
            'dni.numeric' => 'La cédula debe contener solo números.',
            'dni.digits' => 'La cédula debe tener exactamente 8 dígitos.',
            'dni.unique' => 'La cédula ya está registrada',
            'sex.required' => 'El sexo es obligatorio.',
            'sex.in' => 'El sexo debe ser Masculino, Femenino u Otro',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.max' => 'La imagen no debe superar los 4MB.',
            'phone_number.max' => 'El número de teléfono es demasiado largo.',
            'position_id.required' => 'Debe seleccionar un cargo.',
            'position_id.exists' => 'El cargo seleccionado no existe en la base de datos.',
    ];

        $result = $request->validate($rules, $messages);

        $data = [
            "name" => $result['name'],
            "lastname" => $result['lastname'],
            "dni" => $result['dni'],
            "sex" => $result['sex'],
            "phone_number" => $result['phone_number'],
            "position_id" => $result['position_id']
        ];

        if ($request->hasFile('image')) {

            if ($person->image) {
                Storage::disk('public')->delete($person->image);
            }

            $image = $request->file('image')->store('persons', 'public');
            $data["image"] = $image;
        }

        $person->update($data);
    }

    public function createPerson(Request $request){
        $rules = [
            'name' => 'required|string|max:40',
            'lastname' => 'required|string|max:40',
            'dni' => 'required|numeric|unique:people,dni',
            'sex' => 'required',
            'image' => 'nullable|image|max:4096',
            'phone_number' => 'required|string|max:12',
            'position_id' => 'required|exists:positions,id',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'lastname.required' => 'El apellido es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'phone_number.required' => 'El número de teléfono es obligatorio.',
            'dni.numeric' => 'El DNI debe contener solo números.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.unique' => 'El DNI ya está registrado.',
            'sex.required' => 'El sexo es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.max' => 'La imagen no debe superar los 4MB.',
            'phone_number.max' => 'El número de teléfono es demasiado largo.',
            'position_id.required' => 'Debe seleccionar un cargo.',
            'position_id.exists' => 'El cargo seleccionado no existe en la base de datos.',
    ];

        $result = $request->validate($rules, $messages);

        $image = null;
        if ($request->hasFile('image')) {



            $image = $request->file('image')->store('persons', 'public');
        }

        $data = [
            "name" => $result['name'],
            "lastname" => $result['lastname'],
            "dni" => $result['dni'],
            "sex" => $result['sex'],
            "image" => $image,
            "phone_number" => $result['phone_number'],
            "position_id" => $result['position_id']
        ];
        return Person::create($data);
    }

    public function toggleStatus($id){
        $person = $this->findPerson($id);
        if(!$person){
            return response()->json([
            'success' => false,
            'message' => 'Persona no encontrada'
        ], 404);
        }
        $result = DB::transaction(function() use ($person){
            if($person->status == 'active'){
                $person->status = 'inactive';
                $assistance = AssistancePerson::where("person_id", "=", $person->id)->first();
            if($assistance){
                $assistance -> status = 0;
                $assistance->save();
            }
            } else {
            $person->status = 'active';
        }
        $person->save();
        return $person;
        });
        return response()->json([
            'success' => true,
            'status' => $result->status,
            'person' => $result
        ]);
    }

    public function getControlledPersons($user_id){
        return $persons = AssistancePerson::where("user_id", "=", $user_id)
        ->where("status", "=", 1)->with('person')->get();
    }

    public function toggleAssistanceStatus($person_id, $user_id){
        $person = AssistancePerson::where("user_id", "=", Auth::id())
        ->where("person_id", "=", $person_id)->first();

        if(!$person){
            AssistancePerson::create(
                [
                    "user_id" => Auth::id(),
                    "person_id" => $person_id,
                    "status" => 1
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'transacción exitosa',
                ]);
        } else {
            $person->status ? $person->status = 0 : $person->status = 1;
            $person->save();
            return response()->json([
                'success' => true,
                'message' => 'transacción exitosa',
            ]);
        }
    }
}
