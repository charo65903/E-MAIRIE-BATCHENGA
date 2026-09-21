<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Toujours le même message, que l'email existe ou non (évite de
        // révéler si une adresse est enregistrée — bonne pratique sécurité).
        Password::sendResetLink($request->only('email'));

        return back()->with('success', "Si cette adresse est enregistrée, un lien de réinitialisation vient de lui être envoyé.");
    }
}
