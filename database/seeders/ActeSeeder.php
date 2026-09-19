<?php

namespace Database\Seeders;

use App\Models\Acte;
use App\Models\ActeDeces;
use App\Models\ActeMariage;
use App\Models\ActeNaissance;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActeSeeder extends Seeder
{
    public function run(): void
    {
        $agentEtatCivil = User::where('email', 'agent.etatcivil@e-mairie-batchenga.cm')->first();
        $citoyens = User::where('role', 'citoyen')->orderBy('id')->get();

        // --- Actes de naissance ---
        $naissances = [
            ['numero' => 'NAI-2026-0001', 'nom_enfant' => 'Fouda', 'prenom_enfant' => 'Junior', 'sexe' => 'M', 'nom_pere' => 'Fouda Paul', 'nom_mere' => 'Marie Fouda'],
            ['numero' => 'NAI-2026-0002', 'nom_enfant' => 'Biya', 'prenom_enfant' => 'Esther', 'sexe' => 'F', 'nom_pere' => 'Jean Biya', 'nom_mere' => 'Alice Biya'],
        ];

        foreach ($naissances as $index => $data) {
            $acte = Acte::updateOrCreate(
                ['numero_acte' => $data['numero']],
                [
                    'type' => 'naissance',
                    'agent_id' => $agentEtatCivil->id,
                    'citoyen_id' => $citoyens[$index]->id ?? null,
                    'date_evenement' => now()->subYears(rand(1, 10))->format('Y-m-d'),
                    'lieu_evenement' => 'Batchenga',
                    'statut' => 'actif',
                ]
            );

            ActeNaissance::updateOrCreate(
                ['acte_id' => $acte->id],
                [
                    'nom_enfant' => $data['nom_enfant'],
                    'prenom_enfant' => $data['prenom_enfant'],
                    'sexe' => $data['sexe'],
                    'nom_pere' => $data['nom_pere'],
                    'nom_mere' => $data['nom_mere'],
                ]
            );
        }

        // --- Acte de mariage ---
        $acteMariage = Acte::updateOrCreate(
            ['numero_acte' => 'MAR-2026-0001'],
            [
                'type' => 'mariage',
                'agent_id' => $agentEtatCivil->id,
                'citoyen_id' => $citoyens[2]->id ?? null,
                'date_evenement' => now()->subYears(2)->format('Y-m-d'),
                'lieu_evenement' => 'Batchenga',
                'statut' => 'actif',
            ]
        );

        ActeMariage::updateOrCreate(
            ['acte_id' => $acteMariage->id],
            [
                'nom_epoux' => 'Pierre Essomba',
                'nom_epouse' => 'Chantal Owona',
                'temoin_1' => 'Robert Atangana',
                'temoin_2' => 'Sylvie Ngo Bell',
                'regime_matrimonial' => 'Monogamie',
            ]
        );

        // --- Acte de décès ---
        $acteDeces = Acte::updateOrCreate(
            ['numero_acte' => 'DEC-2026-0001'],
            [
                'type' => 'deces',
                'agent_id' => $agentEtatCivil->id,
                'citoyen_id' => null,
                'date_evenement' => now()->subMonths(3)->format('Y-m-d'),
                'lieu_evenement' => 'Batchenga',
                'statut' => 'actif',
            ]
        );

        ActeDeces::updateOrCreate(
            ['acte_id' => $acteDeces->id],
            [
                'nom_defunt' => 'Mballa',
                'prenom_defunt' => 'Antoine',
                'cause_deces' => 'Maladie',
            ]
        );
    }
}
