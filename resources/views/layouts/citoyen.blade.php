<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace citoyen')  — E-Mairie Batchenga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        {{-- Sidebar (devient un menu simple empilé sur mobile) --}}
        <aside class="w-full md:w-60 bg-white border-b md:border-b-0 md:border-r border-gray-200 md:min-h-screen">
            <div class="px-5 py-4 border-b border-gray-100">
                <a href="{{ route('citoyen.dashboard') }}" class="font-semibold text-green-700">E-Mairie Batchenga</a>
                <p class="text-xs text-gray-400 mt-0.5">Espace citoyen</p>
            </div>
            <nav class="flex md:flex-col gap-1 p-3 overflow-x-auto md:overflow-visible text-sm">
                @php
                    $liens = [
                        ['route' => 'citoyen.dashboard', 'label' => 'Tableau de bord'],
                        ['route' => 'citoyen.services.index', 'label' => 'Services'],
                        ['route' => 'citoyen.demandes.index', 'label' => 'Mes demandes'],
                        ['route' => 'citoyen.rendez-vous.index', 'label' => 'Mes rendez-vous'],
                        ['route' => 'citoyen.notifications.index', 'label' => 'Notifications'],
                        ['route' => 'citoyen.profil.edit', 'label' => 'Mon profil'],
                    ];
                @endphp
                @foreach ($liens as $lien)
                    <a href="{{ route($lien['route']) }}"
                       class="whitespace-nowrap px-3 py-2 rounded-md {{ request()->routeIs($lien['route'].'*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        {{ $lien['label'] }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-end gap-4 text-sm">
                <span class="text-gray-600">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Déconnexion</button>
                </form>
            </header>

            <main class="max-w-4xl mx-auto px-4 py-6">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-2">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
