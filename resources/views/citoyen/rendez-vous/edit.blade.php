@extends('layouts.citoyen')

@section('title', 'Modifier le rendez-vous')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Modifier le rendez-vous</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('citoyen.rendez-vous.update', $rendezVous) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-600 mb-1">Service</label>
            <select name="service_id" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" @selected(old('service_id', $rendezVous->service_id) == $service->id)>{{ $service->nom }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Motif (facultatif)</label>
            <input type="text" name="motif" value="{{ old('motif', $rendezVous->motif) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Date</label>
                <input type="date" name="date_rdv" value="{{ old('date_rdv', \Carbon\Carbon::parse($rendezVous->date_rdv)->format('Y-m-d')) }}" min="{{ now()->toDateString() }}" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Créneau</label>
                <select name="creneau" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                    @foreach ($creneaux as $creneau)
                        <option value="{{ $creneau }}" @selected(old('creneau', $rendezVous->creneau) === $creneau)>{{ $creneau }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">
            Enregistrer les modifications
        </button>
    </form>
</div>
@endsection
