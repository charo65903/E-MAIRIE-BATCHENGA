<header class="border-b border-gray-100 bg-white">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('accueil') }}" class="flex items-center gap-2">
            <span class="w-2 h-6 bg-green-700 rounded-sm"></span>
            <span class="w-2 h-6 bg-red-600 rounded-sm"></span>
            <span class="w-2 h-6 bg-yellow-500 rounded-sm"></span>
            <span class="ml-2 font-semibold text-gray-800">E-Mairie Batchenga</span>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm text-gray-600">
            <a href="{{ route('accueil') }}" class="hover:text-green-700 {{ request()->routeIs('accueil') ? 'text-green-700 font-medium' : '' }}">Accueil</a>
            <a href="{{ route('public.services') }}" class="hover:text-green-700 {{ request()->routeIs('public.services') ? 'text-green-700 font-medium' : '' }}">Services</a>
        </nav>

        <div class="flex items-center gap-3 text-sm">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-green-700 text-white rounded-md px-4 py-2 hover:bg-green-800">Mon espace</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-700">Connexion</a>
                <a href="{{ route('register') }}" class="bg-green-700 text-white rounded-md px-4 py-2 hover:bg-green-800">Inscription</a>
            @endauth
        </div>
    </div>
</header>
