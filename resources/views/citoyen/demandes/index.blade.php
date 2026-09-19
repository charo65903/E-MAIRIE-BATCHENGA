@extends('layouts.citoyen')

@section('title', 'Mes demandes')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Mes demandes</h1>
    <a href="{{ route('citoyen.demandes.create') }}" class="bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">Nouvelle demande</a>
</div>

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-2">Service</th>
                <th class="text-left px-4 py-2">Déposée le</th>
                <th class="text-left px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($demandes as $demande)
                <tr class="border-t border-gray-100">
                    <td class="px-4 py-3 text-gray-700">{{ $demande->service->nom }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $demande->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3"><x-badge-statut :statut="$demande->statut" /></td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('citoyen.demandes.show', $demande) }}" class="text-green-700 hover:underline">Voir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucune demande pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $demandes->links() }}
</div>
@endsection
