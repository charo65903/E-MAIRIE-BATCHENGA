@extends('layouts.citoyen')

@section('title', 'Nouvelle demande')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Déposer une demande</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('citoyen.demandes.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-600 mb-1">Service</label>
            <select name="service_id" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                <option value="">-- Choisir un service --</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" @selected(request('service') == $service->id)>{{ $service->nom }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Description / précisions</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Pièces justificatives (PDF, JPG, PNG — 5 Mo max chacune)</label>
            <input type="file" name="pieces[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
        </div>

        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">
            Déposer la demande
        </button>
    </form>
</div>
@endsection
