@extends('layouts.admin')

@section('title', 'Nouveau service')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Nouveau service</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-4">
        @csrf
        @include('admin.services._form')
        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">Créer le service</button>
    </form>
</div>
@endsection
