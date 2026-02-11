<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;


class UserController extends Controller
{
    public function create(){
        if(!User::exists()){
            $roles = Role::all();
            return view('auth.register', compact('roles'));

        } elseif(!Auth::check()){
            return redirect()->route('login')
            ->with('error', 'Sesión de administrador no iniciada.');

        } elseif (Auth::user()->role != 1) {
            return redirect()->route('dashboard.index')
            ->with('error', 'Acceso denegado.');

        } else {
            $roles = Role::all();
            return view('auth.register', compact('roles'));
        }
    }
}
