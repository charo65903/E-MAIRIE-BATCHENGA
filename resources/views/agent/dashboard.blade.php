@extends('layouts.agent')

@section('title', 'Tableau de bord')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Tableau de bord agent</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-yellow-600">{{ $stats['demandes_en_attente'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Demandes en attente</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-blue-600">{{ $stats['mes_demandes_en_cours'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Mes demandes en cours</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-green-700">{{ $stats['demandes_traitees_par_moi'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Traitées par moi</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['rendez_vous_aujourdhui'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Rendez-vous aujourd'hui</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-lg p-4">
    <h2 class="text-sm font-semibold text-gray-700 mb-3">Demandes à traiter</h2>
    @forelse ($demandesATraiter as $demande)
        <a href="{{ route('agent.demandes.show', $demande) }}" class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 text-sm hover:bg-gray-50 -mx-2 px-2 rounded">
            <span class="text-gray-700">{{ $demande->citoyen->prenom }} {{ $demande->citoyen->nom }} — {{ $demande->service->nom }}</span>
            <x-badge-statut :statut="$demande->statut" />
        </a>
    @empty
        <p class="text-sm text-gray-400">Aucune demande en attente.</p>
    @endforelse
</div>
@endsection
