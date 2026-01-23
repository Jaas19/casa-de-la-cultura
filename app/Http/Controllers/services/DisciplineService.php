<?php

namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Discipline;
use App\Models\User;

class DisciplineService implements DisciplineServiceInterface{
    public function storeDiscipline($data, $user){
        return Discipline::create([
            'name' => $data['name'],
            'administrator_id' => $user->id
        ]);
    }

    public function updateDiscipline($discipline, $data){
        if (!$discipline->update($data)) {
            throw new Exception("No se pudo actualizar la disciplina.");
        }
        return $discipline->fresh();
    }
}
