@php $service = $service ?? null; @endphp

<div>
    <label class="block text-sm text-gray-600 mb-1">Nom du service</label>
    <input type="text" name="nom" value="{{ old('nom', $service->nom ?? '') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
</div>

<div>
    <label class="block text-sm text-gray-600 mb-1">Description</label>
    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2">{{ old('description', $service->description ?? '') }}</textarea>
</div>

<div>
    <label class="block text-sm text-gray-600 mb-1">Documents requis</label>
    <input type="text" name="documents_requis" value="{{ old('documents_requis', $service->documents_requis ?? '') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm text-gray-600 mb-1">Tarif (FCFA)</label>
        <input type="number" step="0.01" name="tarif" value="{{ old('tarif', $service->tarif ?? '') }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Délai</label>
        <input type="text" name="delai" value="{{ old('delai', $service->delai ?? '') }}" placeholder="ex: 48h" class="w-full border border-gray-300 rounded-md px-3 py-2">
    </div>
</div>
