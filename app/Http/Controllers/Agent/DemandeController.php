<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\RejeterDemandeRequest;
use App\Models\Demande;
use App\Models\NotificationApp;
use App\Services\DocumentGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    /**
     * Liste + recherche intelligente par mots-clés / filtre par statut
     * (besoin fonctionnel "Recherche intelligente des dossiers").
     */
    public function index(Request $request)
    {
        $demandes = Demande::with(['citoyen', 'service'])
            ->when($request->statut, fn ($q, $statut) => $q->where('statut', $statut))
            ->when($request->q, function ($q, $terme) {
                $q->where(function ($q2) use ($terme) {
                    $q2->where('description', 'like', "%{$terme}%")
                        ->orWhereHas('citoyen', fn ($q3) => $q3->where('nom', 'like', "%{$terme}%")->orWhere('prenom', 'like', "%{$terme}%"))
                        ->orWhereHas('service', fn ($q3) => $q3->where('nom', 'like', "%{$terme}%"));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('agent.demandes.index', compact('demandes'));
    }

    public function show(Demande $demande)
    {
        $demande->load(['citoyen', 'service', 'piecesJustificatives', 'documentGenere', 'agent']);

        return view('agent.demandes.show', compact('demande'));
    }

    /**
     * L'agent prend la demande en charge : passage en "en_cours".
     */
    public function prendreEnCharge(Demande $demande)
    {
        abort_unless($demande->statut === 'en_attente', 403, 'Cette demande ne peut plus être prise en charge.');

        $demande->update([
            'agent_id' => Auth::id(),
            'statut' => 'en_cours',
        ]);

        $this->notifier($demande, 'demande', "Votre demande concernant « {$demande->service->nom} » est en cours de traitement.");

        return back()->with('success', 'Demande prise en charge.');
    }

    /**
     * Validation : génère le document administratif + QR code (§2 besoins fonctionnels)
     * et notifie le citoyen.
     */
    public function valider(Demande $demande, DocumentGenerationService $generateur)
    {
        abort_unless(in_array($demande->statut, ['en_attente', 'en_cours']), 403);

        $demande->update([
            'agent_id' => $demande->agent_id ?? Auth::id(),
            'statut' => 'validee',
        ]);

        $generateur->genererPourDemande($demande);

        $this->notifier($demande, 'document', "Votre demande concernant « {$demande->service->nom} » a été validée. Le document est disponible au téléchargement.");

        return back()->with('success', 'Demande validée et document généré.');
    }

    public function rejeter(RejeterDemandeRequest $request, Demande $demande)
    {
        abort_unless(in_array($demande->statut, ['en_attente', 'en_cours']), 403);

        $demande->update([
            'agent_id' => $demande->agent_id ?? Auth::id(),
            'statut' => 'rejetee',
            'motif_rejet' => $request->motif_rejet,
        ]);

        $this->notifier($demande, 'demande', "Votre demande concernant « {$demande->service->nom} » a été rejetée. Motif : {$request->motif_rejet}");

        return back()->with('success', 'Demande rejetée.');
    }

    private function notifier(Demande $demande, string $type, string $message): void
    {
        NotificationApp::create([
            'user_id' => $demande->citoyen_id,
            'titre' => 'Suivi de votre demande',
            'message' => $message,
            'type' => $type,
            'lu' => false,
        ]);
    }
}
