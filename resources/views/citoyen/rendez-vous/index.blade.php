@extends('layouts.citoyen')

@section('title', 'Mes rendez-vous')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Mes rendez-vous</h1>
    <a href="{{ route('citoyen.rendez-vous.create') }}" class="bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">Prendre rendez-vous</a>
</div>

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
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
                    <td class="px-4 py-3 text-gray-700">{{ $rdv->service?->nom ?? $rdv->motif ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $rdv->creneau }}</td>
                    <td class="px-4 py-3"><x-badge-statut :statut="$rdv->statut" /></td>
                    <td class="px-4 py-3 text-right space-x-2">
                        @if ($rdv->statut !== 'annule')
                            <a href="{{ route('citoyen.rendez-vous.edit', $rdv) }}" class="text-green-700 hover:underline">Modifier</a>
                            <form method="POST" action="{{ route('citoyen.rendez-vous.destroy', $rdv) }}" class="inline" onsubmit="return confirm('Annuler ce rendez-vous ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Annuler</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun rendez-vous pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $rendezVous->links() }}
</div>
@endsection
