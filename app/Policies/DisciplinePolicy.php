<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Discipline;

class DisciplinePolicy
{
    public function show(User $user, Discipline $discipline){
        return $user->id == $discipline -> administrator_id;
    }

    public function update(User $user, Discipline $discipline){
        return $user->id == $discipline -> administrator_id;
    }

    public function calendar(User $user, Discipline $discipline){
        return $user->id == $discipline -> administrator_id;
    }

    public function index(User $user, Discipline $discipline){
        return $user->id == $discipline -> administrator_id;
    }
}

