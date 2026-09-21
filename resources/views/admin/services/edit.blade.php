@extends('layouts.admin')

@section('title', 'Modifier le service')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Modifier « {{ $service->nom }} »</h1>

<div class="bg-white border border-gray-200 rounded-lg p-6 max-w-xl">
    <form method="POST" action="{{ route('admin.services.update', $service) }}" class="space-y-4">
        @csrf
        @method('PUT')
        @include('admin.services._form')
        <button type="submit" class="w-full bg-green-700 text-white rounded-md py-2 font-medium hover:bg-green-800">Enregistrer</button>
    </form>
</div>
@endsection
