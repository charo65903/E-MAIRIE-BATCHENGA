@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Tableau de bord administrateur</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['citoyens'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Citoyens inscrits</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['agents'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Agents</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['services_actifs'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Services actifs</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['actes_enregistres'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Actes enregistrés</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['demandes_total'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Demandes déposées</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-yellow-600">{{ $stats['demandes_en_attente'] }}</p>
        <p class="text-xs text-gray-500 mt-1">En attente</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-green-700">{{ $stats['demandes_validees'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Validées</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['rendez_vous_total'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Rendez-vous actifs</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-lg p-4">
    <h2 class="text-sm font-semibold text-gray-700 mb-3">Dernières demandes</h2>
    @forelse ($dernieresDemandes as $demande)
        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 text-sm">
            <span class="text-gray-700">{{ $demande->citoyen->prenom }} {{ $demande->citoyen->nom }} — {{ $demande->service->nom }}</span>
            <x-badge-statut :statut="$demande->statut" />
        </div>
    @empty
        <p class="text-sm text-gray-400">Aucune demande.</p>
    @endforelse
</div>
@endsection
