@extends('layouts.agent')

@section('title', 'Demandes')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Demandes citoyennes</h1>

<form method="GET" class="flex flex-wrap gap-3 mb-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher (nom, service, description)..."
           class="border border-gray-300 rounded-md px-3 py-2 text-sm flex-1 min-w-[200px]">
    <select name="statut" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
        <option value="">Tous les statuts</option>
        @foreach (['en_attente', 'en_cours', 'validee', 'rejetee'] as $statut)
            <option value="{{ $statut }}" @selected(request('statut') === $statut)>{{ ucfirst(str_replace('_', ' ', $statut)) }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-gray-800 text-white text-sm rounded-md px-4 py-2">Filtrer</button>
</form>

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-2">Citoyen</th>
                <th class="text-left px-4 py-2">Service</th>
                <th class="text-left px-4 py-2">Déposée le</th>
                <th class="text-left px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($demandes as $demande)
                <tr class="border-t border-gray-100">
                    <td class="px-4 py-3 text-gray-700">{{ $demande->citoyen->prenom }} {{ $demande->citoyen->nom }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $demande->service->nom }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $demande->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3"><x-badge-statut :statut="$demande->statut" /></td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('agent.demandes.show', $demande) }}" class="text-green-700 hover:underline">Traiter</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucune demande.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $demandes->links() }}</div>
@endsection
