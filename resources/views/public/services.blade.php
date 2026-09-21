<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Services municipaux — E-Mairie Batchenga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800">

    @include('public._nav')

    <section class="max-w-5xl mx-auto px-4 py-14">
        <h1 class="text-2xl font-semibold text-gray-900 text-center">Services municipaux</h1>
        <p class="text-gray-500 text-sm text-center mt-2">Consultez les démarches proposées par la mairie de Batchenga</p>

        <div class="grid md:grid-cols-2 gap-4 mt-10">
            @foreach ($services as $service)
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h2 class="font-medium text-gray-800">{{ $service->nom }}</h2>
                    <p class="text-sm text-gray-500 mt-2">{{ $service->description }}</p>
                    <dl class="text-xs text-gray-400 mt-4 space-y-1">
                        <div>Documents requis : {{ $service->documents_requis ?? '—' }}</div>
                        <div>Délai : {{ $service->delai ?? '—' }}</div>
                        <div>Tarif : {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' FCFA' : '—' }}</div>
                    </dl>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('register') }}" class="bg-green-700 text-white rounded-md px-6 py-3 text-sm font-medium hover:bg-green-800">Créer mon compte pour faire une demande</a>
        </div>
    </section>

    @include('public._footer')
    @include('components.chatbot-widget')
</body>
</html>
