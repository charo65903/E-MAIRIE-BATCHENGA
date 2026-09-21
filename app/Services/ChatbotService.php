<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Str;

class ChatbotService
{
    /**
     * Chatbot d'orientation basé sur des règles/mots-clés (le rapport ne
     * précise aucune API IA spécifique — voir §13 des consignes : "si une
     * véritable API d'IA est nécessaire mais indisponible, créer d'abord une
     * architecture permettant son intégration ultérieure").
     *
     * Pour brancher un vrai modèle plus tard, il suffira de remplacer le
     * corps de cette méthode par un appel API, en gardant la même signature.
     */
    public function repondre(string $message): string
    {
        $texte = Str::lower(Str::ascii($message));

        return match (true) {
            $this->contient($texte, ['bonjour', 'salut', 'bonsoir', 'hello']) => $this->accueil(),
            $this->contient($texte, ['service', 'demarche', 'demarches']) => $this->listeServices(),
            $this->contient($texte, ['rendez-vous', 'rendez vous', 'rdv']) => $this->aideRendezVous(),
            $this->contient($texte, ['suivre', 'statut', 'ou en est', 'avancement']) => $this->aideSuiviDemande(),
            $this->contient($texte, ['document', 'telecharger', 'attestation', 'certificat']) => $this->aideDocument(),
            $this->contient($texte, ['acte', 'naissance', 'mariage', 'deces', 'etat civil']) => $this->aideEtatCivil(),
            $this->contient($texte, ['compte', 'inscription', 'inscrire', 'creer un compte']) => $this->aideInscription(),
            $this->contient($texte, ['contact', 'telephone', 'adresse', 'joindre']) => $this->aideContact(),
            $this->contient($texte, ['merci']) => "Avec plaisir ! N'hésitez pas si vous avez d'autres questions.",
            default => $this->reponseParDefaut(),
        };
    }

    private function contient(string $texte, array $motsCles): bool
    {
        foreach ($motsCles as $mot) {
            if (str_contains($texte, $mot)) {
                return true;
            }
        }

        return false;
    }

    private function accueil(): string
    {
        return "Bonjour, je suis l'assistant de la mairie de Batchenga. Je peux vous renseigner sur : "
            ."les services municipaux, la prise de rendez-vous, le suivi d'une demande, l'état civil, "
            ."ou la création de compte. Que souhaitez-vous savoir ?";
    }

    private function listeServices(): string
    {
        $noms = Service::where('actif', true)->pluck('nom');

        if ($noms->isEmpty()) {
            return "Aucun service n'est disponible pour le moment. Veuillez réessayer plus tard.";
        }

        return "Voici les services disponibles sur la plateforme : ".$noms->implode(', ')
            .". Vous pouvez consulter le détail de chacun dans la rubrique « Services », "
            ."ou déposer une demande directement depuis votre espace citoyen.";
    }

    private function aideRendezVous(): string
    {
        return "Pour prendre rendez-vous : connectez-vous à votre espace citoyen, puis allez dans "
            ."« Mes rendez-vous » → « Prendre rendez-vous ». Choisissez un service, une date et un créneau "
            ."disponible. Vous pourrez ensuite le modifier ou l'annuler depuis la même page.";
    }

    private function aideSuiviDemande(): string
    {
        return "Le suivi de vos demandes se fait dans votre espace citoyen, rubrique « Mes demandes ». "
            ."Chaque demande affiche son statut : en attente, en cours, validée ou rejetée. Vous recevez "
            ."également une notification à chaque changement de statut.";
    }

    private function aideDocument(): string
    {
        return "Une fois votre demande validée par un agent, le document est généré automatiquement "
            ."avec un QR code de vérification. Vous pouvez le télécharger depuis « Mes demandes » → "
            ."ouvrez la demande concernée → bouton « Télécharger le document ».";
    }

    private function aideEtatCivil(): string
    {
        return "Les actes d'état civil (naissance, mariage, décès) sont enregistrés par les agents de "
            ."la mairie. Pour obtenir un duplicata ou une copie, déposez une demande depuis le service "
            ."correspondant dans votre espace citoyen.";
    }

    private function aideInscription(): string
    {
        return "La création de compte est gratuite et réservée aux citoyens. Cliquez sur « Inscription » "
            ."en haut de la page d'accueil, renseignez vos informations, et vous accéderez immédiatement "
            ."à votre espace personnel.";
    }

    private function aideContact(): string
    {
        return "Pour toute question ne trouvant pas de réponse ici, rapprochez-vous directement des "
            ."services de la mairie de Batchenga, ou déposez une doléance depuis votre espace citoyen.";
    }

    private function reponseParDefaut(): string
    {
        return "Je n'ai pas bien compris votre question. Vous pouvez me demander des informations sur : "
            ."les services, un rendez-vous, le suivi d'une demande, un document, l'état civil, ou la "
            ."création de compte.";
    }
}
