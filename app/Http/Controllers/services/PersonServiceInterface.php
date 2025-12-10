<?php

namespace App\Http\Controllers\Services;
use App\Models\Person;
use Illuminate\Http\Request;

interface PersonServiceInterface {
    public function listPersons();
    public function findPerson($id);
    public function createPerson(Request $request);
    public function updatePerson(Request $request);
    public function toggleStatus($id);
    public function getControlledPersons($user_id);
    public function toggleAssistanceStatus($person_id, $user_id);
}