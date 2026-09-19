@extends('layouts.citoyen')

@section('title', $service->nom)

@section('content')
<a href="{{ route('citoyen.services.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Retour aux services</a>

<div class="bg-white border border-gray-200 rounded-lg p-6 mt-4">
    <h1 class="text-xl font-semibold text-gray-800">{{ $service->nom }}</h1>
    <p class="text-gray-600 mt-3">{{ $service->description }}</p>

    <dl class="grid grid-cols-2 gap-4 mt-6 text-sm">
        <div>
            <dt class="text-gray-400">Documents requis</dt>
            <dd class="text-gray-700 mt-1">{{ $service->documents_requis ?? '—' }}</dd>
        </div>
        <div>
            <dt class="text-gray-400">Délai</dt>
            <dd class="text-gray-700 mt-1">{{ $service->delai ?? '—' }}</dd>
        </div>
        <div>
            <dt class="text-gray-400">Tarif</dt>
            <dd class="text-gray-700 mt-1">{{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' FCFA' : '—' }}</dd>
        </div>
    </dl>

    <a href="{{ route('citoyen.demandes.create') }}?service={{ $service->id }}"
       class="inline-block mt-6 bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">
        Déposer une demande pour ce service
    </a>
</div>
@endsection
