@extends('layouts.agent')

@section('title', 'Ajouter un acte de décès')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Ajouter un acte de décès</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('agent.actes.store-deces') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-600 mb-1">Numéro d'acte</label>
            <input type="text" name="numero_acte" value="{{ old('numero_acte') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Date de décès</label>
                <input type="date" name="date_evenement" value="{{ old('date_evenement') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Lieu</label>
                <input type="text" name="lieu_evenement" value="{{ old('lieu_evenement', 'Batchenga') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nom du défunt</label>
                <input type="text" name="nom_defunt" value="{{ old('nom_defunt') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Prénom du défunt</label>
                <input type="text" name="prenom_defunt" value="{{ old('prenom_defunt') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Cause du décès</label>
            <input type="text" name="cause_deces" value="{{ old('cause_deces') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">Enregistrer l'acte</button>
    </form>
</div>
@endsection
