<?php

namespace App\Http\Controllers\Citoyen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('citoyen.profil.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'telephone' => ['nullable', 'string', 'max:20'],
            'nouveau_mot_de_passe' => ['nullable', 'confirmed', Password::min(8)],
            'mot_de_passe_actuel' => ['nullable', 'required_with:nouveau_mot_de_passe'],
        ]);

        if ($request->filled('nouveau_mot_de_passe')) {
            if (! Hash::check($request->mot_de_passe_actuel, $user->password)) {
                return back()->withErrors(['mot_de_passe_actuel' => 'Mot de passe actuel incorrect.']);
            }
            $user->password = $request->nouveau_mot_de_passe;
        }

        $user->fill([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
        ])->save();

        return back()->with('success', 'Profil mis à jour.');
    }
}
