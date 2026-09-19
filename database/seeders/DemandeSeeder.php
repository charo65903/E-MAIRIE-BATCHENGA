<?php

namespace Database\Seeders;

use App\Models\Demande;
use App\Models\DocumentGenere;
use App\Models\PieceJustificative;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemandeSeeder extends Seeder
{
    /**
     * Pas de clé métier unique naturelle pour une "demande" de démo :
     * on purge les données précédemment seedées (dans l'ordre des FK)
     * avant de les recréer, pour que ce seeder soit réexécutable sans erreur.
     */
    public function run(): void
    {
        DocumentGenere::query()->delete();
        PieceJustificative::query()->delete();
        Demande::query()->delete();

        $citoyens = User::where('role', 'citoyen')->orderBy('id')->get();
        $agent = User::where('email', 'agent.secretariat@e-mairie-batchenga.cm')->first();
        $serviceNaissance = Service::where('nom', 'Acte de naissance')->first();
        $serviceResidence = Service::where('nom', 'Attestation de résidence')->first();
        $serviceLegalisation = Service::where('nom', 'Légalisation de document')->first();
        $serviceOccupation = Service::where('nom', "Autorisation d'occupation temporaire de la voie publique")->first();

        $demandesData = [
            [
                'citoyen' => $citoyens[0],
                'service' => $serviceNaissance,
                'description' => "Demande de duplicata d'acte de naissance pour dossier scolaire.",
                'statut' => 'validee',
                'agent_id' => $agent->id,
            ],
            [
                'citoyen' => $citoyens[1],
                'service' => $serviceResidence,
                'description' => "Attestation de résidence pour ouverture de compte bancaire.",
                'statut' => 'en_cours',
                'agent_id' => $agent->id,
            ],
            [
                'citoyen' => $citoyens[2],
                'service' => $serviceLegalisation,
                'description' => "Légalisation de copie de diplôme.",
                'statut' => 'en_attente',
                'agent_id' => null,
            ],
            [
                'citoyen' => $citoyens[3],
                'service' => $serviceOccupation,
                'description' => "Occupation temporaire pour un événement familial.",
                'statut' => 'rejetee',
                'agent_id' => $agent->id,
                'motif_rejet' => 'Plan du site incomplet.',
            ],
            [
                'citoyen' => $citoyens[4],
                'service' => $serviceResidence,
                'description' => 'Attestation de résidence pour dossier administratif.',
                'statut' => 'validee',
                'agent_id' => $agent->id,
            ],
        ];

        foreach ($demandesData as $data) {
            $demande = Demande::create([
                'citoyen_id' => $data['citoyen']->id,
                'service_id' => $data['service']->id,
                'agent_id' => $data['agent_id'],
                'description' => $data['description'],
                'statut' => $data['statut'],
                'motif_rejet' => $data['motif_rejet'] ?? null,
            ]);

            PieceJustificative::create([
                'demande_id' => $demande->id,
                'nom_original' => 'piece_justificative.pdf',
                'chemin_fichier' => 'demo/pieces_justificatives/demande_'.$demande->id.'.pdf',
                'type_mime' => 'application/pdf',
                'taille' => 204800,
            ]);

            if ($data['statut'] === 'validee') {
                DocumentGenere::create([
                    'demande_id' => $demande->id,
                    'reference' => 'DOC-'.now()->format('Y').'-'.str_pad((string) $demande->id, 4, '0', STR_PAD_LEFT),
                    'chemin_fichier' => 'demo/documents/document_'.$demande->id.'.pdf',
                    'qr_code_path' => 'demo/qrcodes/qr_'.$demande->id.'.png',
                    'date_generation' => now(),
                ]);
            }
        }
    }
}
