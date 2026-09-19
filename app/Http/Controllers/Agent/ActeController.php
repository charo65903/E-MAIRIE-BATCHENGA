<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Acte;
use App\Models\ActeDeces;
use App\Models\ActeMariage;
use App\Models\ActeNaissance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActeController extends Controller
{
    /**
     * Liste + recherche par numéro d'acte ou nom (besoin fonctionnel
     * "Recherche intelligente des dossiers par mots-clés").
     */
    public function index(Request $request)
    {
        $actes = Acte::with(['naissance', 'mariage', 'deces', 'agent'])
            ->when($request->type, fn ($q, $type) => $q->where('type', $type))
            ->when($request->q, fn ($q, $terme) => $q->where('numero_acte', 'like', "%{$terme}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('agent.actes.index', compact('actes'));
    }

    public function show(Acte $acte)
    {
        $acte->load(['naissance', 'mariage', 'deces', 'agent', 'citoyen']);

        return view('agent.actes.show', compact('acte'));
    }

    public function createNaissance()
    {
        return view('agent.actes.create-naissance');
    }

    public function storeNaissance(Request $request)
    {
        $data = $request->validate([
            'numero_acte' => ['required', 'string', 'unique:actes,numero_acte'],
            'date_evenement' => ['required', 'date'],
            'lieu_evenement' => ['nullable', 'string', 'max:255'],
            'nom_enfant' => ['required', 'string', 'max:255'],
            'prenom_enfant' => ['required', 'string', 'max:255'],
            'sexe' => ['required', 'in:M,F'],
            'nom_pere' => ['nullable', 'string', 'max:255'],
            'nom_mere' => ['nullable', 'string', 'max:255'],
        ]);

        $acte = Acte::create([
            'type' => 'naissance',
            'numero_acte' => $data['numero_acte'],
            'agent_id' => Auth::id(),
            'date_evenement' => $data['date_evenement'],
            'lieu_evenement' => $data['lieu_evenement'] ?? null,
            'statut' => 'actif',
        ]);

        ActeNaissance::create([
            'acte_id' => $acte->id,
            'nom_enfant' => $data['nom_enfant'],
            'prenom_enfant' => $data['prenom_enfant'],
            'sexe' => $data['sexe'],
            'nom_pere' => $data['nom_pere'] ?? null,
            'nom_mere' => $data['nom_mere'] ?? null,
        ]);

        return redirect()->route('agent.actes.show', $acte)->with('success', "Acte de naissance {$acte->numero_acte} enregistré.");
    }

    public function createMariage()
    {
        return view('agent.actes.create-mariage');
    }

    public function storeMariage(Request $request)
    {
        $data = $request->validate([
            'numero_acte' => ['required', 'string', 'unique:actes,numero_acte'],
            'date_evenement' => ['required', 'date'],
            'lieu_evenement' => ['nullable', 'string', 'max:255'],
            'nom_epoux' => ['required', 'string', 'max:255'],
            'nom_epouse' => ['required', 'string', 'max:255'],
            'temoin_1' => ['nullable', 'string', 'max:255'],
            'temoin_2' => ['nullable', 'string', 'max:255'],
            'regime_matrimonial' => ['nullable', 'string', 'max:255'],
        ]);

        $acte = Acte::create([
            'type' => 'mariage',
            'numero_acte' => $data['numero_acte'],
            'agent_id' => Auth::id(),
            'date_evenement' => $data['date_evenement'],
            'lieu_evenement' => $data['lieu_evenement'] ?? null,
            'statut' => 'actif',
        ]);

        ActeMariage::create([
            'acte_id' => $acte->id,
            'nom_epoux' => $data['nom_epoux'],
            'nom_epouse' => $data['nom_epouse'],
            'temoin_1' => $data['temoin_1'] ?? null,
            'temoin_2' => $data['temoin_2'] ?? null,
            'regime_matrimonial' => $data['regime_matrimonial'] ?? null,
        ]);

        return redirect()->route('agent.actes.show', $acte)->with('success', "Acte de mariage {$acte->numero_acte} enregistré.");
    }

    public function createDeces()
    {
        return view('agent.actes.create-deces');
    }

    public function storeDeces(Request $request)
    {
        $data = $request->validate([
            'numero_acte' => ['required', 'string', 'unique:actes,numero_acte'],
            'date_evenement' => ['required', 'date'],
            'lieu_evenement' => ['nullable', 'string', 'max:255'],
            'nom_defunt' => ['required', 'string', 'max:255'],
            'prenom_defunt' => ['required', 'string', 'max:255'],
            'cause_deces' => ['nullable', 'string', 'max:255'],
        ]);

        $acte = Acte::create([
            'type' => 'deces',
            'numero_acte' => $data['numero_acte'],
            'agent_id' => Auth::id(),
            'date_evenement' => $data['date_evenement'],
            'lieu_evenement' => $data['lieu_evenement'] ?? null,
            'statut' => 'actif',
        ]);

        ActeDeces::create([
            'acte_id' => $acte->id,
            'nom_defunt' => $data['nom_defunt'],
            'prenom_defunt' => $data['prenom_defunt'],
            'cause_deces' => $data['cause_deces'] ?? null,
        ]);

        return redirect()->route('agent.actes.show', $acte)->with('success', "Acte de décès {$acte->numero_acte} enregistré.");
    }
}
