@extends('layouts.agent')

@section('title', 'Traiter la demande')

@section('content')
<a href="{{ route('agent.demandes.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Retour aux demandes</a>

<div class="bg-white border border-gray-200 rounded-lg p-6 mt-4">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">{{ $demande->service->nom }}</h1>
        <x-badge-statut :statut="$demande->statut" />
    </div>

    <dl class="grid grid-cols-2 gap-4 mt-4 text-sm">
        <div>
            <dt class="text-gray-400">Citoyen</dt>
            <dd class="text-gray-700 mt-1">{{ $demande->citoyen->prenom }} {{ $demande->citoyen->nom }} — {{ $demande->citoyen->email }}</dd>
        </div>
        <div>
            <dt class="text-gray-400">Déposée le</dt>
            <dd class="text-gray-700 mt-1">{{ $demande->created_at->format('d/m/Y à H:i') }}</dd>
        </div>
    </dl>

    @if ($demande->description)
        <p class="text-gray-700 mt-4">{{ $demande->description }}</p>
    @endif

    <div class="mt-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-2">Pièces justificatives</h2>
        @forelse ($demande->piecesJustificatives as $piece)
            <a href="{{ asset('storage/'.$piece->chemin_fichier) }}" target="_blank" class="block text-sm text-green-700 hover:underline">{{ $piece->nom_original }}</a>
        @empty
            <p class="text-sm text-gray-400">Aucune pièce jointe.</p>
        @endforelse
    </div>

    @if ($demande->statut === 'rejetee')
        <div class="mt-6 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-2">
            Motif du rejet : {{ $demande->motif_rejet }}
        </div>
    @endif

    @if (in_array($demande->statut, ['en_attente', 'en_cours']))
        <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap gap-3">
            @if ($demande->statut === 'en_attente')
                <form method="POST" action="{{ route('agent.demandes.prendre-en-charge', $demande) }}">
                    @csrf
                    <button type="submit" class="bg-gray-800 text-white text-sm rounded-md px-4 py-2">Prendre en charge</button>
                </form>
            @endif

            <form method="POST" action="{{ route('agent.demandes.valider', $demande) }}" onsubmit="return confirm('Valider cette demande et générer le document ?');">
                @csrf
                <button type="submit" class="bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">Valider et générer le document</button>
            </form>

            <button type="button" onclick="document.getElementById('form-rejet').classList.toggle('hidden')" class="bg-red-50 text-red-700 text-sm rounded-md px-4 py-2 border border-red-200">Rejeter</button>
        </div>

        <form id="form-rejet" method="POST" action="{{ route('agent.demandes.rejeter', $demande) }}" class="hidden mt-4 space-y-2">
            @csrf
            <label class="block text-sm text-gray-600">Motif du rejet</label>
            <textarea name="motif_rejet" rows="3" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"></textarea>
            <button type="submit" class="bg-red-600 text-white text-sm rounded-md px-4 py-2">Confirmer le rejet</button>
        </form>
    @endif

    @if ($demande->documentGenere)
        <div class="mt-6 pt-6 border-t border-gray-100 text-sm text-gray-600">
            Document généré — référence {{ $demande->documentGenere->reference }}
        </div>
    @endif
</div>
@endsection
