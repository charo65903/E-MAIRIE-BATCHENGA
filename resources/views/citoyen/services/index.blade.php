@extends('layouts.citoyen')

@section('title', 'Services')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Services municipaux</h1>

<div class="grid md:grid-cols-2 gap-4">
    @foreach ($services as $service)
        <div class="bg-white border border-gray-200 rounded-lg p-4 flex flex-col justify-between">
            <div>
                <h2 class="font-medium text-gray-800">{{ $service->nom }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $service->description }}</p>
                <p class="text-xs text-gray-400 mt-2">Délai : {{ $service->delai ?? '—' }} · Tarif : {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' FCFA' : '—' }}</p>
            </div>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('citoyen.services.show', $service) }}" class="text-sm text-green-700 hover:underline">Voir le détail</a>
                <a href="{{ route('citoyen.demandes.create') }}?service={{ $service->id }}" class="text-sm text-gray-500 hover:underline">Faire une demande</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
