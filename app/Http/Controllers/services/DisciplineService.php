<?php

namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Discipline;
use App\Models\User;
use App\Models\AuditLog;
use Exception;

class DisciplineService implements DisciplineServiceInterface{
    public function storeDiscipline($data, $user){
        return Discipline::create([
            'name' => $data['name'],
            'administrator_id' => $user->id
        ]);
    }

public function updateDiscipline($discipline, $data){

    $oldDiscipline = $discipline->replicate();
    $oldName = $oldDiscipline->name;


    if (!$discipline->update($data)) {
        throw new Exception("No se pudo actualizar la disciplina.");
    }


    if ($discipline->administrator_id != Auth::id()) {
        AuditLog::create([
            "giver_id" => $discipline->administrator_id,
            "collaborator_id" => Auth::id(),
            "model_changed" => "Disciplina: $oldName",
            "type" => "Actualización"
        ]);
    }

    return $discipline->fresh();
}
}
