@extends('layouts.agent')

@section('title', 'Détail de l\'acte')

@section('content')
<a href="{{ route('agent.actes.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Retour aux actes</a>

<div class="bg-white border border-gray-200 rounded-lg p-6 mt-4 max-w-xl">
    <h1 class="text-xl font-semibold text-gray-800">Acte {{ $acte->numero_acte }}</h1>
    <p class="text-sm text-gray-500 mt-1 capitalize">{{ $acte->type }} — enregistré par {{ $acte->agent->prenom }} {{ $acte->agent->nom }}</p>

    <dl class="grid grid-cols-2 gap-4 mt-6 text-sm">
        <div>
            <dt class="text-gray-400">Date de l'événement</dt>
            <dd class="text-gray-700 mt-1">{{ \Carbon\Carbon::parse($acte->date_evenement)->format('d/m/Y') }}</dd>
        </div>
        <div>
            <dt class="text-gray-400">Lieu</dt>
            <dd class="text-gray-700 mt-1">{{ $acte->lieu_evenement ?? '—' }}</dd>
        </div>

        @if ($acte->type === 'naissance' && $acte->naissance)
            <div><dt class="text-gray-400">Enfant</dt><dd class="text-gray-700 mt-1">{{ $acte->naissance->prenom_enfant }} {{ $acte->naissance->nom_enfant }} ({{ $acte->naissance->sexe }})</dd></div>
            <div><dt class="text-gray-400">Père</dt><dd class="text-gray-700 mt-1">{{ $acte->naissance->nom_pere ?? '—' }}</dd></div>
            <div><dt class="text-gray-400">Mère</dt><dd class="text-gray-700 mt-1">{{ $acte->naissance->nom_mere ?? '—' }}</dd></div>
        @elseif ($acte->type === 'mariage' && $acte->mariage)
            <div><dt class="text-gray-400">Époux</dt><dd class="text-gray-700 mt-1">{{ $acte->mariage->nom_epoux }}</dd></div>
            <div><dt class="text-gray-400">Épouse</dt><dd class="text-gray-700 mt-1">{{ $acte->mariage->nom_epouse }}</dd></div>
            <div><dt class="text-gray-400">Témoins</dt><dd class="text-gray-700 mt-1">{{ $acte->mariage->temoin_1 }}, {{ $acte->mariage->temoin_2 }}</dd></div>
        @elseif ($acte->type === 'deces' && $acte->deces)
            <div><dt class="text-gray-400">Défunt</dt><dd class="text-gray-700 mt-1">{{ $acte->deces->prenom_defunt }} {{ $acte->deces->nom_defunt }}</dd></div>
            <div><dt class="text-gray-400">Cause</dt><dd class="text-gray-700 mt-1">{{ $acte->deces->cause_deces ?? '—' }}</dd></div>
        @endif
    </dl>
</div>
@endsection
