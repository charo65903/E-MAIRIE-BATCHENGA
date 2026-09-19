<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de document — E-Mairie Batchenga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white border border-gray-200 rounded-lg p-8 max-w-md w-full text-center">
        @if ($document)
            <div class="w-12 h-12 mx-auto rounded-full bg-green-100 text-green-700 flex items-center justify-center text-xl mb-4">✓</div>
            <h1 class="text-lg font-semibold text-gray-800">Document authentique</h1>
            <p class="text-sm text-gray-500 mt-2">Référence {{ $reference }}</p>
            <dl class="text-sm mt-6 text-left space-y-2">
                <div class="flex justify-between"><dt class="text-gray-400">Service</dt><dd class="text-gray-700">{{ $document->demande->service->nom }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-400">Émis par</dt><dd class="text-gray-700">Mairie de Batchenga</dd></div>
                <div class="flex justify-between"><dt class="text-gray-400">Date de génération</dt><dd class="text-gray-700">{{ $document->date_generation->format('d/m/Y') }}</dd></div>
            </dl>
        @else
            <div class="w-12 h-12 mx-auto rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xl mb-4">✕</div>
            <h1 class="text-lg font-semibold text-gray-800">Document introuvable</h1>
            <p class="text-sm text-gray-500 mt-2">La référence {{ $reference }} ne correspond à aucun document émis par la mairie.</p>
        @endif
    </div>
</body>
</html>
