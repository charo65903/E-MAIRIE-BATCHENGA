@extends('layouts.agent')

@section('title', 'Ajouter un acte de naissance')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Ajouter un acte de naissance</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('agent.actes.store-naissance') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-600 mb-1">Numéro d'acte</label>
            <input type="text" name="numero_acte" value="{{ old('numero_acte') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Date de naissance</label>
                <input type="date" name="date_evenement" value="{{ old('date_evenement') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Lieu</label>
                <input type="text" name="lieu_evenement" value="{{ old('lieu_evenement', 'Batchenga') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nom de l'enfant</label>
                <input type="text" name="nom_enfant" value="{{ old('nom_enfant') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Prénom de l'enfant</label>
                <input type="text" name="prenom_enfant" value="{{ old('prenom_enfant') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Sexe</label>
            <select name="sexe" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="M" @selected(old('sexe') === 'M')>Masculin</option>
                <option value="F" @selected(old('sexe') === 'F')>Féminin</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nom du père</label>
                <input type="text" name="nom_pere" value="{{ old('nom_pere') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nom de la mère</label>
                <input type="text" name="nom_mere" value="{{ old('nom_mere') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">Enregistrer l'acte</button>
    </form>
</div>
@endsection
