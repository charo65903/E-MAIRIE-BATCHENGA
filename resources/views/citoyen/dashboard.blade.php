@extends('layouts.citoyen')

@section('title', 'Tableau de bord')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Bonjour, {{ auth()->user()->prenom }}</h1>
    <p class="text-sm text-gray-500 mt-1">Voici un aperçu de votre activité sur E-Mairie Batchenga.</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <x-stat-card icon="file-text" :value="$stats['demandes_total']" label="Demandes déposées" color="gray" />
    <x-stat-card icon="clock" :value="$stats['demandes_en_cours']" label="En cours de traitement" color="yellow" />
    <x-stat-card icon="calendar" :value="$stats['rendez_vous_a_venir']" label="Rendez-vous à venir" color="green" />
    <x-stat-card icon="bell" :value="$stats['notifications_non_lues']" label="Notifications non lues" color="red" />
</div>

<div class="flex flex-wrap gap-3 mb-8">
    <a href="{{ route('citoyen.demandes.create') }}" class="inline-flex items-center gap-2 bg-green-700 text-white text-sm rounded-md px-4 py-2.5 hover:bg-green-800">
        <x-icon name="file-text" />
        Déposer une demande
    </a>
    <a href="{{ route('citoyen.rendez-vous.create') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 text-sm rounded-md px-4 py-2.5 hover:bg-gray-50">
        <x-icon name="calendar" />
        Prendre un rendez-vous
    </a>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm p-5">
        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Dernières demandes</h2>
        @forelse ($dernieresDemandes as $demande)
            <a href="{{ route('citoyen.demandes.show', $demande) }}" class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 text-sm hover:bg-gray-50 -mx-2 px-2 rounded transition">
                <span class="text-gray-700">{{ $demande->service->nom }}</span>
                <x-badge-statut :statut="$demande->statut" />
            </a>
        @empty
            <p class="text-sm text-gray-400">Aucune demande pour le moment.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-lg shadow-sm p-5">
        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Prochain rendez-vous</h2>
        @if ($prochainRdv)
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                    <x-icon name="calendar" />
                </div>
                <div>
                    <p class="text-sm text-gray-700 font-medium">{{ $prochainRdv->service?->nom ?? $prochainRdv->motif }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($prochainRdv->date_rdv)->translatedFormat('d F Y') }} à {{ $prochainRdv->creneau }}</p>
                    <div class="mt-2"><x-badge-statut :statut="$prochainRdv->statut" /></div>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-400">Aucun rendez-vous à venir.</p>
        @endif
    </div>
</div>
@endsection
