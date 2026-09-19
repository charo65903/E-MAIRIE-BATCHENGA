<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPathForRole(Auth::user()->role));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Un citoyen ne doit jamais atterrir sur un espace agent/admin, et inversement.
     */
    protected function redirectPathForRole(string $role): string
    {
        return match ($role) {
            'administrateur' => route('admin.dashboard'),
            'agent' => route('agent.dashboard'),
            default => route('citoyen.dashboard'),
        };
    }
}
