@extends('layouts.agent')

@section('title', 'Tableau de bord')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Tableau de bord agent</h1>
    <p class="text-sm text-gray-500 mt-1">Bonjour {{ auth()->user()->prenom }}, voici l'activité du jour.</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <x-stat-card icon="clock" :value="$stats['demandes_en_attente']" label="Demandes en attente" color="yellow" />
    <x-stat-card icon="briefcase" :value="$stats['mes_demandes_en_cours']" label="Mes demandes en cours" color="blue" />
    <x-stat-card icon="check-circle" :value="$stats['demandes_traitees_par_moi']" label="Traitées par moi" color="green" />
    <x-stat-card icon="calendar" :value="$stats['rendez_vous_aujourdhui']" label="Rendez-vous aujourd'hui" color="gray" />
</div>

<div class="bg-white rounded-lg shadow-sm p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Demandes à traiter</h2>
        <a href="{{ route('agent.demandes.index') }}" class="text-xs text-green-700 hover:underline">Voir tout</a>
    </div>
    @forelse ($demandesATraiter as $demande)
        <a href="{{ route('agent.demandes.show', $demande) }}" class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 text-sm hover:bg-gray-50 -mx-2 px-2 rounded transition">
            <span class="text-gray-700">{{ $demande->citoyen->prenom }} {{ $demande->citoyen->nom }} — {{ $demande->service->nom }}</span>
            <x-badge-statut :statut="$demande->statut" />
        </a>
    @empty
        <p class="text-sm text-gray-400">Aucune demande en attente.</p>
    @endforelse
</div>
@endsection
