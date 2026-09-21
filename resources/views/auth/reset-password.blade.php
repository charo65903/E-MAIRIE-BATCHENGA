@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-8">
    <h1 class="text-xl font-semibold mb-6 text-gray-800">Nouveau mot de passe</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $email) }}" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Nouveau mot de passe</label>
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
            Réinitialiser le mot de passe
        </button>
    </form>
</div>
@endsection
