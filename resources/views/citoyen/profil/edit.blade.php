@extends('layouts.citoyen')

@section('title', 'Mon profil')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Mon profil</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('citoyen.profil.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <hr class="border-gray-100">
        <p class="text-sm text-gray-500">Laisser vide si tu ne veux pas changer de mot de passe.</p>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Mot de passe actuel</label>
            <input type="password" name="mot_de_passe_actuel" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nouveau mot de passe</label>
                <input type="password" name="nouveau_mot_de_passe" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Confirmer</label>
                <input type="password" name="nouveau_mot_de_passe_confirmation" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
        </div>

        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">
            Enregistrer
        </button>
    </form>
</div>
@endsection
