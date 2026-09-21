@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Utilisateurs</h1>
    <a href="{{ route('admin.utilisateurs.create-agent') }}" class="bg-green-700 text-white text-sm rounded-md px-4 py-2 hover:bg-green-800">+ Créer un agent</a>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher (nom, email)..."
           class="border border-gray-300 rounded-md px-3 py-2 text-sm flex-1 min-w-[200px]">
    <select name="role" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
        <option value="">Tous les rôles</option>
        <option value="citoyen" @selected(request('role') === 'citoyen')>Citoyen</option>
        <option value="agent" @selected(request('role') === 'agent')>Agent</option>
        <option value="administrateur" @selected(request('role') === 'administrateur')>Administrateur</option>
    </select>
    <button type="submit" class="bg-gray-800 text-white text-sm rounded-md px-4 py-2">Filtrer</button>
</form>

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-2">Nom</th>
                <th class="text-left px-4 py-2">Email</th>
                <th class="text-left px-4 py-2">Rôle</th>
                <th class="text-left px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($utilisateurs as $utilisateur)
                <tr class="border-t border-gray-100">
                    <td class="px-4 py-3 text-gray-700">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $utilisateur->email }}</td>
                    <td class="px-4 py-3 text-gray-500 capitalize">{{ $utilisateur->role }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium {{ $utilisateur->actif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $utilisateur->actif ? 'Actif' : 'Désactivé' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if ($utilisateur->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.utilisateurs.basculer-actif', $utilisateur) }}" class="inline"
                                  onsubmit="return confirm('{{ $utilisateur->actif ? 'Désactiver' : 'Activer' }} ce compte ?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $utilisateur->actif ? 'text-red-600' : 'text-green-700' }} hover:underline">
                                    {{ $utilisateur->actif ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        @else
                            <span class="text-gray-300 text-xs">(vous)</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun utilisateur.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $utilisateurs->links() }}</div>
@endsection
