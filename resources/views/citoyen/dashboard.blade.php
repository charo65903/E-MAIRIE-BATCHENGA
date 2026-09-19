@extends('layouts.citoyen')

@section('title', 'Tableau de bord')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Bonjour, {{ auth()->user()->prenom }}</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['demandes_total'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Demandes déposées</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-yellow-600">{{ $stats['demandes_en_cours'] }}</p>
        <p class="text-xs text-gray-500 mt-1">En cours de traitement</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-green-700">{{ $stats['rendez_vous_a_venir'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Rendez-vous à venir</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-red-600">{{ $stats['notifications_non_lues'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Notifications non lues</p>
    </div>
</div>

<div class="flex gap-3 mb-8">
    <a href="{{ route('citoyen.demandes.create') }}" class="bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">Déposer une demande</a>
    <a href="{{ route('citoyen.rendez-vous.create') }}" class="bg-white border border-gray-300 text-gray-700 text-sm rounded-md px-4 py-2 hover:bg-gray-50">Prendre un rendez-vous</a>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <h2 class="text-sm font-semibold text-gray-700 mb-3">Dernières demandes</h2>
        @forelse ($dernieresDemandes as $demande)
            <a href="{{ route('citoyen.demandes.show', $demande) }}" class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 text-sm hover:bg-gray-50 -mx-2 px-2 rounded">
                <span class="text-gray-700">{{ $demande->service->nom }}</span>
                <x-badge-statut :statut="$demande->statut" />
            </a>
        @empty
            <p class="text-sm text-gray-400">Aucune demande pour le moment.</p>
        @endforelse
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <h2 class="text-sm font-semibold text-gray-700 mb-3">Prochain rendez-vous</h2>
        @if ($prochainRdv)
            <p class="text-sm text-gray-700">{{ $prochainRdv->service?->nom ?? $prochainRdv->motif }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($prochainRdv->date_rdv)->translatedFormat('d F Y') }} à {{ $prochainRdv->creneau }}</p>
            <x-badge-statut :statut="$prochainRdv->statut" />
        @else
            <p class="text-sm text-gray-400">Aucun rendez-vous à venir.</p>
        @endif
    </div>
</div>
@endsection
