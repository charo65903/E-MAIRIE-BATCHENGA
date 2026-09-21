@extends('layouts.admin')

@section('title', 'Créer un agent')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Créer un compte agent</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('admin.utilisateurs.store-agent') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Mot de passe</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Confirmer</label>
                <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">Créer le compte agent</button>
    </form>
</div>
@endsection
