<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAgentRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Liste + recherche + filtre par rôle.
     */
    public function index(Request $request)
    {
        $utilisateurs = User::query()
            ->when($request->role, fn ($q, $role) => $q->where('role', $role))
            ->when($request->q, function ($q, $terme) {
                $q->where(fn ($q2) => $q2->where('nom', 'like', "%{$terme}%")
                    ->orWhere('prenom', 'like', "%{$terme}%")
                    ->orWhere('email', 'like', "%{$terme}%"));
            })
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();

        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Cas d'utilisation "Consulter compte utilisateur" du rapport :
     * l'administrateur active/désactive le statut d'accès d'un compte.
     */
    public function basculerActif(User $utilisateur)
    {
        abort_if($utilisateur->id === auth()->id(), 403, 'Vous ne pouvez pas désactiver votre propre compte.');

        $utilisateur->update(['actif' => ! $utilisateur->actif]);

        return back()->with('success', $utilisateur->actif ? 'Compte activé.' : 'Compte désactivé.');
    }

    /**
     * Création d'un compte agent — pas d'auto-inscription pour ce rôle
     * (voir §8 : seul l'admin crée les comptes agent).
     */
    public function createAgent()
    {
        return view('admin.utilisateurs.create-agent');
    }

    public function storeAgent(StoreAgentRequest $request)
    {
        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => $request->password,
            'role' => 'agent',
            'actif' => true,
        ]);

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Compte agent créé.');
    }
}
