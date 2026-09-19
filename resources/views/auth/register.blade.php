@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-8">
    <h1 class="text-xl font-semibold mb-6 text-gray-800">Créer un compte citoyen</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <button type="submit"
                class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">
            Créer mon compte
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4">
        Déjà un compte ? <a href="{{ route('login') }}" class="text-green-700 hover:underline">Se connecter</a>
    </p>
</div>
@endsection
