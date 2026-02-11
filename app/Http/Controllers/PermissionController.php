<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index()
    {
        // Solo muestro los permisos que YO (Auth) he otorgado a otros
        $permissions = Permission::where('giver_id', Auth::id())
            ->with('collaborator')
            ->get();
        return view("permission.index", compact('permissions'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view("permission.create", compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'collaborator_id' => ['required', 'exists:users,id'],
        ]);
        try {
            $exists = Permission::where('giver_id', Auth::id())
                        ->where('collaborator_id', $validatedData['collaborator_id'])
                        ->exists();

            if ($exists) {
                return redirect()->back()->with("error", "Ya has autorizado a este usuario antes.");
            }
            Permission::create([
                'giver_id' => Auth::id(),
                'collaborator_id' => $validatedData['collaborator_id'],
            ]);
            return redirect()->route("permission.index")->with("success", "Permiso creado exitosamente");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with("error", "Hubo un error al crear el permiso");
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            if ($permission->giver_id !== Auth::id()) {
                return redirect()->route("permission.index")->with("error", "No tienes autorización para eliminar este permiso.");
            }
            $permission->delete();
            return redirect()->route("permission.index")->with("success", "Permiso revocado correctamente");
        } catch (\Exception $e) {
            return redirect()->route("permission.index")->with("error", "Hubo un error al eliminar.");
        }
    }
}
