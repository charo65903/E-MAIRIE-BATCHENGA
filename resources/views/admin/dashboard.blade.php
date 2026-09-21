@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Tableau de bord administrateur</h1>
    <p class="text-sm text-gray-500 mt-1">Vue d'ensemble de l'activité de la plateforme.</p>
</div>

<div class="mb-8">
    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Effectifs & catalogue</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-stat-card icon="users" :value="$stats['citoyens']" label="Citoyens inscrits" color="gray" />
        <x-stat-card icon="user-check" :value="$stats['agents']" label="Agents" color="gray" />
        <x-stat-card icon="settings" :value="$stats['services_actifs']" label="Services actifs" color="gray" />
        <x-stat-card icon="file-text" :value="$stats['actes_enregistres']" label="Actes enregistrés" color="gray" />
    </div>
</div>

<div class="mb-8">
    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Demandes & rendez-vous</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-stat-card icon="file-text" :value="$stats['demandes_total']" label="Demandes déposées" color="blue" />
        <x-stat-card icon="clock" :value="$stats['demandes_en_attente']" label="En attente" color="yellow" />
        <x-stat-card icon="check-circle" :value="$stats['demandes_validees']" label="Validées" color="green" />
        <x-stat-card icon="calendar" :value="$stats['rendez_vous_total']" label="Rendez-vous actifs" color="gray" />
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm p-5">
    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Dernières demandes</h2>
    @forelse ($dernieresDemandes as $demande)
        <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 text-sm">
            <span class="text-gray-700">{{ $demande->citoyen->prenom }} {{ $demande->citoyen->nom }} — {{ $demande->service->nom }}</span>
            <x-badge-statut :statut="$demande->statut" />
        </div>
    @empty
        <p class="text-sm text-gray-400">Aucune demande.</p>
    @endforelse
</div>
@endsection
