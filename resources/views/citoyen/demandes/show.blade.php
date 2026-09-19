@extends('layouts.citoyen')

@section('title', 'Détail de la demande')

@section('content')
<a href="{{ route('citoyen.demandes.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Retour à mes demandes</a>

<div class="bg-white border border-gray-200 rounded-lg p-6 mt-4">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">{{ $demande->service->nom }}</h1>
        <x-badge-statut :statut="$demande->statut" />
    </div>

    <p class="text-sm text-gray-500 mt-1">Déposée le {{ $demande->created_at->format('d/m/Y à H:i') }}</p>

    @if ($demande->description)
        <p class="text-gray-700 mt-4">{{ $demande->description }}</p>
    @endif

    @if ($demande->statut === 'rejetee' && $demande->motif_rejet)
        <div class="mt-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-2">
            Motif du rejet : {{ $demande->motif_rejet }}
        </div>
    @endif

    <div class="mt-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-2">Pièces justificatives</h2>
        @forelse ($demande->piecesJustificatives as $piece)
            <p class="text-sm text-gray-600">{{ $piece->nom_original }}</p>
        @empty
            <p class="text-sm text-gray-400">Aucune pièce jointe.</p>
        @endforelse
    </div>

    @if ($demande->documentGenere)
        <div class="mt-6 pt-6 border-t border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700 mb-2">Document généré</h2>
            <p class="text-sm text-gray-500 mb-2">Référence : {{ $demande->documentGenere->reference }}</p>
            @if ($fichierDisponible)
                <a href="{{ route('citoyen.demandes.telecharger-document', $demande) }}"
                   class="inline-block bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">
                    Télécharger le document
                </a>
            @else
                <p class="text-xs text-gray-400">(Donnée de démonstration — aucun fichier réel généré pour l'instant.)</p>
            @endif
        </div>
    @endif
</div>
@endsection
