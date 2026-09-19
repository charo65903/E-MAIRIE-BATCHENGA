<?php

namespace Database\Seeders;

use App\Models\Demande;
use App\Models\NotificationApp;
use App\Models\RendezVous;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        NotificationApp::query()->delete();

        Demande::all()->each(function (Demande $demande) {
            $messages = [
                'en_attente' => "Votre demande concernant « {$demande->service->nom} » a été enregistrée et est en attente de traitement.",
                'en_cours' => "Votre demande concernant « {$demande->service->nom} » est en cours de traitement.",
                'validee' => "Votre demande concernant « {$demande->service->nom} » a été validée. Le document est disponible au téléchargement.",
                'rejetee' => "Votre demande concernant « {$demande->service->nom} » a été rejetée. Motif : {$demande->motif_rejet}",
            ];

            NotificationApp::create([
                'user_id' => $demande->citoyen_id,
                'titre' => 'Suivi de votre demande',
                'message' => $messages[$demande->statut] ?? 'Mise à jour de votre demande.',
                'type' => $demande->statut === 'validee' ? 'document' : 'demande',
                'lu' => $demande->statut === 'en_attente' ? false : true,
            ]);
        });

        RendezVous::all()->each(function (RendezVous $rdv) {
            $messages = [
                'confirme' => "Votre rendez-vous du {$rdv->date_rdv->format('d/m/Y')} à {$rdv->creneau} est confirmé.",
                'modifie' => "Votre rendez-vous a été modifié : nouvelle date le {$rdv->date_rdv->format('d/m/Y')} à {$rdv->creneau}.",
                'annule' => 'Votre rendez-vous a été annulé.',
            ];

            NotificationApp::create([
                'user_id' => $rdv->citoyen_id,
                'titre' => 'Rendez-vous',
                'message' => $messages[$rdv->statut] ?? 'Mise à jour de votre rendez-vous.',
                'type' => 'rendez_vous',
                'lu' => false,
            ]);
        });
    }
}
