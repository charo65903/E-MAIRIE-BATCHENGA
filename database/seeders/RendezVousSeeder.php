<?php

namespace Database\Seeders;

use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class RendezVousSeeder extends Seeder
{
    public function run(): void
    {
        RendezVous::query()->delete();

        $citoyens = User::where('role', 'citoyen')->orderBy('id')->get();
        $serviceNaissance = Service::where('nom', 'Acte de naissance')->first();
        $serviceMariage = Service::where('nom', 'Acte de mariage')->first();

        $rendezVousData = [
            [
                'citoyen_id' => $citoyens[0]->id,
                'service_id' => $serviceNaissance->id,
                'motif' => "Retrait d'acte de naissance",
                'date_rdv' => now()->addDays(2)->format('Y-m-d'),
                'creneau' => '09:00',
                'statut' => 'confirme',
            ],
            [
                'citoyen_id' => $citoyens[2]->id,
                'service_id' => $serviceMariage->id,
                'motif' => 'Dépôt de dossier de mariage',
                'date_rdv' => now()->addDays(5)->format('Y-m-d'),
                'creneau' => '11:00',
                'statut' => 'confirme',
            ],
            [
                'citoyen_id' => $citoyens[3]->id,
                'service_id' => $serviceNaissance->id,
                'motif' => "Rectification d'acte",
                'date_rdv' => now()->addDays(3)->format('Y-m-d'),
                'creneau' => '14:30',
                'statut' => 'modifie',
            ],
            [
                'citoyen_id' => $citoyens[4]->id,
                'service_id' => null,
                'motif' => 'Renseignement général',
                'date_rdv' => now()->subDays(1)->format('Y-m-d'),
                'creneau' => '10:00',
                'statut' => 'annule',
            ],
        ];

        foreach ($rendezVousData as $data) {
            RendezVous::create($data);
        }
    }
}
