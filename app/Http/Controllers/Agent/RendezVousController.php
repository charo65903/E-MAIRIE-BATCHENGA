<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\NotificationApp;
use App\Models\RendezVous;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function index(Request $request)
    {
        $rendezVous = RendezVous::with(['citoyen', 'service'])
            ->when($request->date, fn ($q, $date) => $q->whereDate('date_rdv', $date))
            ->orderBy('date_rdv')
            ->orderBy('creneau')
            ->paginate(15)
            ->withQueryString();

        return view('agent.rendez-vous.index', compact('rendezVous'));
    }

    /**
     * Annulation côté agent (ex : absence du citoyen, empêchement du service).
     */
    public function annuler(RendezVous $rendezVous)
    {
        $rendezVous->update(['statut' => 'annule']);

        NotificationApp::create([
            'user_id' => $rendezVous->citoyen_id,
            'titre' => 'Rendez-vous annulé',
            'message' => "Votre rendez-vous du ".$rendezVous->date_rdv->format('d/m/Y')." a été annulé par la mairie.",
            'type' => 'rendez_vous',
            'lu' => false,
        ]);

        return back()->with('success', 'Rendez-vous annulé.');
    }
}
