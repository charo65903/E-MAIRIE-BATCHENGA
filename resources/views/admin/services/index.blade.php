@extends('layouts.admin')

@section('title', 'Services')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Services municipaux</h1>
    <a href="{{ route('admin.services.create') }}" class="bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">+ Nouveau service</a>
</div>

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-2">Nom</th>
                <th class="text-left px-4 py-2">Tarif</th>
                <th class="text-left px-4 py-2">Délai</th>
                <th class="text-left px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $service)
                <tr class="border-t border-gray-100">
                    <td class="px-4 py-3 text-gray-700">{{ $service->nom }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' FCFA' : '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $service->delai ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium {{ $service->actif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $service->actif ? 'Actif' : 'Désactivé' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-green-700 hover:underline">Modifier</a>
                        <form method="POST" action="{{ route('admin.services.basculer-actif', $service) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="{{ $service->actif ? 'text-red-600' : 'text-green-700' }} hover:underline">
                                {{ $service->actif ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun service.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
