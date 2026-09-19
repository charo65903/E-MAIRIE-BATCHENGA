@extends('layouts.agent')

@section('title', 'Rendez-vous')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Rendez-vous</h1>

<form method="GET" class="flex gap-3 mb-4">
    <input type="date" name="date" value="{{ request('date') }}" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
    <button type="submit" class="bg-gray-800 text-white text-sm rounded-md px-4 py-2">Filtrer</button>
    @if (request('date'))
        <a href="{{ route('agent.rendez-vous.index') }}" class="text-sm text-gray-500 self-center hover:underline">Réinitialiser</a>
    @endif
</form>

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-2">Citoyen</th>
                <th class="text-left px-4 py-2">Service</th>
                <th class="text-left px-4 py-2">Date</th>
                <th class="text-left px-4 py-2">Créneau</th>
                <th class="text-left px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rendezVous as $rdv)
                <tr class="border-t border-gray-100">
                    <td class="px-4 py-3 text-gray-700">{{ $rdv->citoyen->prenom }} {{ $rdv->citoyen->nom }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $rdv->service?->nom ?? $rdv->motif ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $rdv->creneau }}</td>
                    <td class="px-4 py-3"><x-badge-statut :statut="$rdv->statut" /></td>
                    <td class="px-4 py-3 text-right">
                        @if ($rdv->statut !== 'annule')
                            <form method="POST" action="{{ route('agent.rendez-vous.annuler', $rdv) }}" onsubmit="return confirm('Annuler ce rendez-vous ?');">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline">Annuler</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-400">Aucun rendez-vous.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $rendezVous->links() }}</div>
@endsection
