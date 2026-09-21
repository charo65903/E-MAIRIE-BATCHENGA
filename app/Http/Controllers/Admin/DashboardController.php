<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acte;
use App\Models\Demande;
use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'citoyens' => User::where('role', 'citoyen')->count(),
            'agents' => User::where('role', 'agent')->count(),
            'services_actifs' => Service::where('actif', true)->count(),
            'demandes_total' => Demande::count(),
            'demandes_en_attente' => Demande::where('statut', 'en_attente')->count(),
            'demandes_validees' => Demande::where('statut', 'validee')->count(),
            'rendez_vous_total' => RendezVous::where('statut', '!=', 'annule')->count(),
            'actes_enregistres' => Acte::count(),
        ];

        $dernieresDemandes = Demande::with(['citoyen', 'service'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'dernieresDemandes'));
    }
}
