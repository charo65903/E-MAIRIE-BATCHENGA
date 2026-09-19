<?php

namespace App\Http\Controllers\Citoyen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Citoyen\StoreRendezVousRequest;
use App\Models\RendezVous;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    /**
     * Créneaux proposés — non spécifiés dans le rapport, plage horaire de
     * bureau standard retenue comme PROPOSITION (à valider si besoin).
     */
    private const CRENEAUX = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];

    public function index()
    {
        $rendezVous = Auth::user()->rendezVous()->with('service')->orderByDesc('date_rdv')->paginate(10);

        return view('citoyen.rendez-vous.index', compact('rendezVous'));
    }

    public function create()
    {
        $services = Service::where('actif', true)->orderBy('nom')->get();

        return view('citoyen.rendez-vous.create', [
            'services' => $services,
            'creneaux' => self::CRENEAUX,
        ]);
    }

    public function store(StoreRendezVousRequest $request)
    {
        RendezVous::create([
            'citoyen_id' => Auth::id(),
            'service_id' => $request->service_id,
            'motif' => $request->motif,
            'date_rdv' => $request->date_rdv,
            'creneau' => $request->creneau,
            'statut' => 'confirme',
        ]);

        return redirect()->route('citoyen.rendez-vous.index')
            ->with('success', 'Votre rendez-vous a été confirmé.');
    }

    public function edit(RendezVous $rendezVous)
    {
        abort_unless($rendezVous->citoyen_id === Auth::id(), 403);
        abort_if($rendezVous->statut === 'annule', 403);

        $services = Service::where('actif', true)->orderBy('nom')->get();

        return view('citoyen.rendez-vous.edit', [
            'rendezVous' => $rendezVous,
            'services' => $services,
            'creneaux' => self::CRENEAUX,
        ]);
    }

    public function update(StoreRendezVousRequest $request, RendezVous $rendezVous)
    {
        abort_unless($rendezVous->citoyen_id === Auth::id(), 403);

        $rendezVous->update([
            'service_id' => $request->service_id,
            'motif' => $request->motif,
            'date_rdv' => $request->date_rdv,
            'creneau' => $request->creneau,
            'statut' => 'modifie',
        ]);

        return redirect()->route('citoyen.rendez-vous.index')
            ->with('success', 'Votre rendez-vous a été modifié.');
    }

    /**
     * Annulation = passage au statut "annule" (pas de suppression, pour garder
     * l'historique, conformément à la table des statuts définie en migration).
     */
    public function destroy(RendezVous $rendezVous)
    {
        abort_unless($rendezVous->citoyen_id === Auth::id(), 403);

        $rendezVous->update(['statut' => 'annule']);

        return redirect()->route('citoyen.rendez-vous.index')
            ->with('success', 'Votre rendez-vous a été annulé.');
    }
}
