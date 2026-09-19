<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'demandes_en_attente' => Demande::where('statut', 'en_attente')->count(),
            'mes_demandes_en_cours' => Demande::where('agent_id', Auth::id())->where('statut', 'en_cours')->count(),
            'demandes_traitees_par_moi' => Demande::where('agent_id', Auth::id())->whereIn('statut', ['validee', 'rejetee'])->count(),
            'rendez_vous_aujourdhui' => RendezVous::whereDate('date_rdv', now()->toDateString())->where('statut', '!=', 'annule')->count(),
        ];

        $demandesATraiter = Demande::with(['citoyen', 'service'])
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        return view('agent.dashboard', compact('stats', 'demandesATraiter'));
    }
}
