<?php
namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;


interface DisciplineServiceInterface{
    public function storeDiscipline($data, $user);
    public function updateDiscipline($discipline, $data);
}
