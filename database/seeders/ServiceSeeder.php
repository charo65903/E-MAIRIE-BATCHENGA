<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'nom' => 'Acte de naissance',
                'description' => "Délivrance et duplicata d'actes de naissance.",
                'documents_requis' => "Déclaration de naissance ou CNI d'un parent",
                'tarif' => 1000,
                'delai' => '48h',
            ],
            [
                'nom' => 'Acte de mariage',
                'description' => "Enregistrement et délivrance d'actes de mariage.",
                'documents_requis' => 'CNI des époux, certificat de publication de bans',
                'tarif' => 1500,
                'delai' => '72h',
            ],
            [
                'nom' => 'Acte de décès',
                'description' => "Enregistrement et délivrance d'actes de décès.",
                'documents_requis' => 'Certificat médical de décès, CNI du déclarant',
                'tarif' => 1000,
                'delai' => '48h',
            ],
            [
                'nom' => 'Légalisation de document',
                'description' => "Légalisation de signature ou de copie de document.",
                'documents_requis' => 'Document original + copie, CNI',
                'tarif' => 500,
                'delai' => '24h',
            ],
            [
                'nom' => 'Attestation de résidence',
                'description' => "Délivrance d'une attestation de résidence.",
                'documents_requis' => 'CNI, justificatif de domicile',
                'tarif' => 500,
                'delai' => '24h',
            ],
            [
                'nom' => "Autorisation d'occupation temporaire de la voie publique",
                'description' => "Traitement des demandes d'occupation temporaire de la voie publique.",
                'documents_requis' => 'CNI, plan sommaire du site',
                'tarif' => 2000,
                'delai' => '5 jours ouvrés',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['nom' => $service['nom']],
                [
                    'description' => $service['description'],
                    'documents_requis' => $service['documents_requis'],
                    'tarif' => $service['tarif'],
                    'delai' => $service['delai'],
                    'actif' => true,
                ]
            );
        }
    }
}
