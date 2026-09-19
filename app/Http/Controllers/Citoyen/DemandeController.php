<?php

namespace App\Http\Controllers\Citoyen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Citoyen\StoreDemandeRequest;
use App\Models\Demande;
use App\Models\PieceJustificative;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = Auth::user()->demandes()->with('service')->latest()->paginate(10);

        return view('citoyen.demandes.index', compact('demandes'));
    }

    public function create()
    {
        $services = Service::where('actif', true)->orderBy('nom')->get();

        return view('citoyen.demandes.create', compact('services'));
    }

    public function store(StoreDemandeRequest $request)
    {
        $demande = Demande::create([
            'citoyen_id' => Auth::id(),
            'service_id' => $request->service_id,
            'description' => $request->description,
            'statut' => 'en_attente',
        ]);

        foreach ($request->file('pieces', []) as $fichier) {
            $chemin = $fichier->store('pieces_justificatives/'.$demande->id, 'public');

            PieceJustificative::create([
                'demande_id' => $demande->id,
                'nom_original' => $fichier->getClientOriginalName(),
                'chemin_fichier' => $chemin,
                'type_mime' => $fichier->getClientMimeType(),
                'taille' => $fichier->getSize(),
            ]);
        }

        return redirect()->route('citoyen.demandes.show', $demande)
            ->with('success', 'Votre demande a été déposée avec succès.');
    }

    public function show(Demande $demande)
    {
        abort_unless($demande->citoyen_id === Auth::id(), 403);

        $demande->load(['service', 'piecesJustificatives', 'documentGenere', 'agent']);

        $fichierDisponible = $demande->documentGenere
            && Storage::disk('public')->exists($demande->documentGenere->chemin_fichier);

        return view('citoyen.demandes.show', compact('demande', 'fichierDisponible'));
    }

    /**
     * Téléchargement du document généré (uniquement si la demande a été validée
     * ET que le fichier a réellement été généré — les données de démonstration
     * référencent des chemins fictifs tant qu'aucun agent n'a produit le vrai PDF).
     */
    public function telechargerDocument(Demande $demande)
    {
        abort_unless($demande->citoyen_id === Auth::id(), 403);
        abort_unless($demande->documentGenere, 404);
        abort_unless(Storage::disk('public')->exists($demande->documentGenere->chemin_fichier), 404, "Le document n'a pas encore été généré.");

        return Storage::disk('public')->download(
            $demande->documentGenere->chemin_fichier,
            'document_'.$demande->documentGenere->reference.'.pdf'
        );
    }
}
