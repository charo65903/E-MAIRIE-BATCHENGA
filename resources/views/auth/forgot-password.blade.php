@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-8">
    <h1 class="text-xl font-semibold mb-2 text-gray-800">Mot de passe oublié</h1>
    <p class="text-sm text-gray-500 mb-6">Indiquez votre adresse email : si un compte lui est associé, vous recevrez un lien pour réinitialiser votre mot de passe.</p>

    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm p-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <button type="submit"
                class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4">
        <a href="{{ route('login') }}" class="text-green-700 hover:underline">&larr; Retour à la connexion</a>
    </p>
</div>
@endsection
