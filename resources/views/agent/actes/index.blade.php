@extends('layouts.agent')

@section('title', "Actes d'état civil")

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Actes d'état civil</h1>
    <div class="flex gap-2">
        <a href="{{ route('agent.actes.create-naissance') }}" class="bg-white border border-gray-300 text-sm rounded-md px-3 py-2 hover:bg-gray-50">+ Naissance</a>
        <a href="{{ route('agent.actes.create-mariage') }}" class="bg-white border border-gray-300 text-sm rounded-md px-3 py-2 hover:bg-gray-50">+ Mariage</a>
        <a href="{{ route('agent.actes.create-deces') }}" class="bg-white border border-gray-300 text-sm rounded-md px-3 py-2 hover:bg-gray-50">+ Décès</a>
    </div>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher par numéro d'acte..."
           class="border border-gray-300 rounded-md px-3 py-2 text-sm flex-1 min-w-[200px]">
    <select name="type" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
        <option value="">Tous les types</option>
        <option value="naissance" @selected(request('type') === 'naissance')>Naissance</option>
        <option value="mariage" @selected(request('type') === 'mariage')>Mariage</option>
        <option value="deces" @selected(request('type') === 'deces')>Décès</option>
    </select>
    <button type="submit" class="bg-gray-800 text-white text-sm rounded-md px-4 py-2">Filtrer</button>
</form>

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-2">N° Acte</th>
                <th class="text-left px-4 py-2">Type</th>
                <th class="text-left px-4 py-2">Concerné(s)</th>
                <th class="text-left px-4 py-2">Date</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($actes as $acte)
                <tr class="border-t border-gray-100">
                    <td class="px-4 py-3 text-gray-700">{{ $acte->numero_acte }}</td>
                    <td class="px-4 py-3 text-gray-700 capitalize">{{ $acte->type }}</td>
                    <td class="px-4 py-3 text-gray-500">
                        @if ($acte->type === 'naissance' && $acte->naissance)
                            {{ $acte->naissance->prenom_enfant }} {{ $acte->naissance->nom_enfant }}
                        @elseif ($acte->type === 'mariage' && $acte->mariage)
                            {{ $acte->mariage->nom_epoux }} &amp; {{ $acte->mariage->nom_epouse }}
                        @elseif ($acte->type === 'deces' && $acte->deces)
                            {{ $acte->deces->prenom_defunt }} {{ $acte->deces->nom_defunt }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ \Carbon\Carbon::parse($acte->date_evenement)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('agent.actes.show', $acte) }}" class="text-green-700 hover:underline">Voir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun acte enregistré.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $actes->links() }}</div>
@endsection
