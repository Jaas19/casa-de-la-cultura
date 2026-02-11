<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    public function create()
    {
        if (!User::exists()) {
            $roles = Role::all();
            return view('auth.register', compact('roles'));
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 1) {
            return redirect()->route('dashboard.index');
        }

        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $isFirstUser = !User::exists();

        $roleToAssign = $isFirstUser ? 1 : $request->role;

        $user = User::create([
            'role' => $roleToAssign,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        if ($isFirstUser) {
            Auth::login($user);
            return redirect(route('dashboard.index', absolute: false));
        } else {
            return redirect()->route('register')
                ->with('success', 'Usuario registrado exitosamente.');
        }
    }
}
