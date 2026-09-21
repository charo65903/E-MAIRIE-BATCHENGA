<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Mairie Batchenga')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
        <a href="{{ url('/') }}" class="font-semibold text-green-700">E-Mairie Batchenga</a>
        <div class="flex items-center gap-4 text-sm">
            @auth
                <span class="text-gray-600">{{ auth()->user()->prenom }} {{ auth()->user()->nom }} ({{ auth()->user()->role }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:underline">Connexion</a>
                <a href="{{ route('register') }}" class="text-green-700 hover:underline">Inscription</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8">
        @yield('content')
    </main>
</body>
</html>
