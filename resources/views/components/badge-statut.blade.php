@php
    $styles = match($statut) {
        'en_attente' => 'bg-yellow-100 text-yellow-800',
        'en_cours' => 'bg-blue-100 text-blue-800',
        'validee', 'confirme', 'actif' => 'bg-green-100 text-green-800',
        'rejetee', 'annule' => 'bg-red-100 text-red-800',
        'modifie' => 'bg-yellow-100 text-yellow-800',
        default => 'bg-gray-100 text-gray-700',
    };
    $labels = [
        'en_attente' => 'En attente',
        'en_cours' => 'En cours',
        'validee' => 'Validée',
        'rejetee' => 'Rejetée',
        'confirme' => 'Confirmé',
        'modifie' => 'Modifié',
        'annule' => 'Annulé',
        'actif' => 'Actif',
    ];
@endphp
<span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium {{ $styles }}">
    {{ $labels[$statut] ?? ucfirst($statut) }}
</span>
