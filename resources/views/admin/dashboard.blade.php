@extends('layouts.app')

@section('title', 'Espace administrateur')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-2">Espace administrateur</h1>
<p class="text-gray-500 text-sm">Bienvenue, {{ auth()->user()->prenom }}. Les statistiques et la gestion (utilisateurs, services) seront construites à l'étape suivante.</p>
@endsection
