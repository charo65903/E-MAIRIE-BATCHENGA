<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    /**
     * L'inscription publique ne crée que des comptes citoyens.
     * Les comptes agent/administrateur sont créés par l'administrateur
     * (aucun cas d'utilisation d'auto-inscription pour ces rôles dans le rapport).
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => $request->password,
            'role' => 'citoyen',
            'actif' => true,
        ]);

        Auth::login($user);

        return redirect()->route('citoyen.dashboard');
    }
}
