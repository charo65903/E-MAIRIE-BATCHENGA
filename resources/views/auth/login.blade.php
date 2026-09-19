@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-8">
    <h1 class="text-xl font-semibold mb-6 text-gray-800">Connexion</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember"> Se souvenir de moi
        </label>

        <button type="submit"
                class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">
            Se connecter
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4">
        Pas encore de compte ? <a href="{{ route('register') }}" class="text-green-700 hover:underline">S'inscrire</a>
    </p>
</div>
@endsection
