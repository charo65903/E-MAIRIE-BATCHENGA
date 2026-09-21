<?php

namespace App\Services;

use App\Mail\NotificationMairieMail;
use App\Models\NotificationApp;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Crée la notification in-app ET envoie l'email correspondant
     * (besoin fonctionnel "Notifications automatiques (SMS/e-mail)").
     *
     * L'envoi d'email est protégé par un try/catch : si le SMTP n'est pas
     * configuré ou indisponible, la notification in-app est quand même
     * créée et l'action métier (valider une demande, etc.) n'échoue pas.
     */
    public function notifier(User $utilisateur, string $titre, string $message, string $type = 'autre'): NotificationApp
    {
        $notification = NotificationApp::create([
            'user_id' => $utilisateur->id,
            'titre' => $titre,
            'message' => $message,
            'type' => $type,
            'lu' => false,
        ]);

        try {
            Mail::to($utilisateur->email)->send(new NotificationMairieMail($titre, $message));
        } catch (\Throwable $e) {
            Log::warning('Échec envoi email de notification', [
                'user_id' => $utilisateur->id,
                'erreur' => $e->getMessage(),
            ]);
        }

        return $notification;
    }
}
