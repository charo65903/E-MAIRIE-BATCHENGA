<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Mairie Batchenga — Services municipaux en ligne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800">

    @include('public._nav')

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1.5 flex">
            <span class="flex-1 bg-green-700"></span>
            <span class="flex-1 bg-red-600"></span>
            <span class="flex-1 bg-yellow-500"></span>
        </div>
        <div class="max-w-4xl mx-auto px-4 pt-20 pb-16 text-center">
            <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 leading-tight">
                Les services de la mairie de Batchenga,<br class="hidden md:block"> maintenant en ligne
            </h1>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                Actes d'état civil, démarches administratives et rendez-vous : accédez aux services
                municipaux depuis chez vous, suivez vos demandes en temps réel.
            </p>
            <div class="mt-8 flex items-center justify-center gap-3">
                <a href="{{ route('register') }}" class="bg-green-700 text-white rounded-md px-6 py-3 text-sm font-medium hover:bg-green-800">Créer mon compte</a>
                <a href="{{ route('public.services') }}" class="bg-white border border-gray-300 text-gray-700 rounded-md px-6 py-3 text-sm font-medium hover:bg-gray-50">Voir les services</a>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section class="bg-gray-50 py-16">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">Nos services</h2>
            <p class="text-gray-500 text-sm text-center mt-2">Un aperçu des démarches disponibles sur la plateforme</p>

            <div class="grid md:grid-cols-3 gap-4 mt-10">
                @foreach ($services as $service)
                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h3 class="font-medium text-gray-800">{{ $service->nom }}</h3>
                        <p class="text-sm text-gray-500 mt-2">{{ \Illuminate\Support\Str::limit($service->description, 90) }}</p>
                        <p class="text-xs text-gray-400 mt-3">Délai : {{ $service->delai ?? '—' }}</p>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('public.services') }}" class="text-green-700 text-sm hover:underline">Voir tous les services &rarr;</a>
            </div>
        </div>
    </section>

    {{-- Comment ça marche --}}
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">Comment ça marche</h2>

            <div class="grid md:grid-cols-3 gap-8 mt-10 text-center">
                <div>
                    <div class="w-10 h-10 mx-auto rounded-full bg-green-100 text-green-700 flex items-center justify-center font-semibold">1</div>
                    <h3 class="font-medium text-gray-800 mt-4">Créez votre compte</h3>
                    <p class="text-sm text-gray-500 mt-2">Inscription simple et gratuite pour les citoyens de Batchenga.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mx-auto rounded-full bg-green-100 text-green-700 flex items-center justify-center font-semibold">2</div>
                    <h3 class="font-medium text-gray-800 mt-4">Déposez votre demande</h3>
                    <p class="text-sm text-gray-500 mt-2">Choisissez un service, joignez vos pièces justificatives, ou prenez rendez-vous.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mx-auto rounded-full bg-green-100 text-green-700 flex items-center justify-center font-semibold">3</div>
                    <h3 class="font-medium text-gray-800 mt-4">Suivez et récupérez</h3>
                    <p class="text-sm text-gray-500 mt-2">Recevez des notifications et téléchargez votre document une fois validé.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA final --}}
    <section class="bg-green-700 py-14">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-xl md:text-2xl font-semibold text-white">Prêt à simplifier vos démarches ?</h2>
            <p class="text-green-50 text-sm mt-2">Rejoignez les citoyens de Batchenga qui gèrent déjà leurs démarches en ligne.</p>
            <a href="{{ route('register') }}" class="inline-block mt-6 bg-white text-green-700 rounded-md px-6 py-3 text-sm font-medium hover:bg-gray-50">Créer mon compte citoyen</a>
        </div>
    </section>

   @include('public._footer')
   @include('components.chatbot-widget')
</body>
</html>
