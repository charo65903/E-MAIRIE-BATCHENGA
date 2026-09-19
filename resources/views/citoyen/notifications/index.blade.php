@extends('layouts.citoyen')

@section('title', 'Notifications')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Notifications</h1>

<div class="space-y-2">
    @forelse ($notifications as $notification)
        <div class="bg-white border {{ $notification->lu ? 'border-gray-200' : 'border-green-300' }} rounded-lg p-4 flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ $notification->titre }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
            @unless ($notification->lu)
                <form method="POST" action="{{ route('citoyen.notifications.marquer-lue', $notification) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-xs text-green-700 hover:underline whitespace-nowrap">Marquer comme lue</button>
                </form>
            @endunless
        </div>
    @empty
        <p class="text-sm text-gray-400">Aucune notification.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $notifications->links() }}
</div>
@endsection
