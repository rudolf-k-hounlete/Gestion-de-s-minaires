<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs ET leurs rôles actuels.
     * Si l’utilisateur connecté n’est pas admin, on renvoie 403.
     */
    public function index()
    {
        // Vérification du rôle
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::orderBy('name')->get();
        $roles = ['admin', 'secretary', 'presenter', 'student'];

        return view('admin.users_index', compact('users', 'roles'));
    }

    /**
     * Met à jour le rôle de l’utilisateur donné.
     * Si l’utilisateur connecté n’est pas admin, on renvoie 403.
     */
    public function updateRole(Request $request, User $user)
    {
        // Vérification du rôle
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Validation du rôle envoyé
        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'secretary', 'presenter', 'student'])],
        ]);

        // L’admin ne peut pas rétrograder son propre compte hors de 'admin'
        if ($user->id === Auth::id() && $data['role'] !== 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas changer votre propre rôle.');
        }

        $user->role = $data['role'];
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Rôle de « {$user->name} » mis à jour en « {$data['role']} ».");
    }
}
