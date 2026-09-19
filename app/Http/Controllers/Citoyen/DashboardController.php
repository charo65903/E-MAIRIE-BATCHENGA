<?php

namespace App\Http\Controllers\Citoyen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $citoyen = Auth::user();

        $stats = [
            'demandes_total' => $citoyen->demandes()->count(),
            'demandes_en_cours' => $citoyen->demandes()->whereIn('statut', ['en_attente', 'en_cours'])->count(),
            'demandes_validees' => $citoyen->demandes()->where('statut', 'validee')->count(),
            'rendez_vous_a_venir' => $citoyen->rendezVous()->where('date_rdv', '>=', now()->toDateString())->where('statut', '!=', 'annule')->count(),
            'notifications_non_lues' => $citoyen->notificationsApp()->where('lu', false)->count(),
        ];

        $dernieresDemandes = $citoyen->demandes()->with('service')->latest()->take(5)->get();
        $prochainRdv = $citoyen->rendezVous()->where('date_rdv', '>=', now()->toDateString())->where('statut', '!=', 'annule')->orderBy('date_rdv')->first();

        return view('citoyen.dashboard', compact('stats', 'dernieresDemandes', 'prochainRdv'));
    }
}
