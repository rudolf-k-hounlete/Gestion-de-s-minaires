<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }



public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'current_password' => ['nullable'],
        'password' => ['nullable', 'confirmed', 'min:8'],
    ]);

    // Met à jour le nom
    $user->name = $request->name;

    // S'il veut changer le mot de passe
    if ($request->filled('password')) {
        if (!$request->filled('current_password')) {
            return back()->with('error', 'Vous devez fournir le mot de passe actuel pour en définir un nouveau.');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Le mot de passe actuel est incorrect.');
        }

        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Profil mis à jour avec succès.');
}




public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Le mot de passe actuel est incorrect.');
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Mot de passe mis à jour avec succès.');
}

}
