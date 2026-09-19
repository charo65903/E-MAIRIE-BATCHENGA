<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ordre important : respecte les dépendances de clés étrangères
     * (users/services avant actes/demandes/rendez-vous, demandes avant
     * pièces/documents, demandes+rendez-vous avant notifications).
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            ActeSeeder::class,
            DemandeSeeder::class,
            RendezVousSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
