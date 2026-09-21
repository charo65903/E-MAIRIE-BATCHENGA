<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function __construct(private NotificationService $notifications) {}

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

    public function annuler(RendezVous $rendezVous)
    {
        $rendezVous->update(['statut' => 'annule']);

        $this->notifications->notifier(
            $rendezVous->citoyen,
            'Rendez-vous annulé',
            "Votre rendez-vous du ".$rendezVous->date_rdv->format('d/m/Y')." a été annulé par la mairie.",
            'rendez_vous'
        );

        return back()->with('success', 'Rendez-vous annulé.');
    }
}
