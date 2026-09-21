<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe — E-Mairie Batchenga')
                ->greeting('Bonjour,')
                ->line('Vous recevez cet email car une demande de réinitialisation de mot de passe a été effectuée pour votre compte E-Mairie Batchenga.')
                ->action('Réinitialiser le mot de passe', $url)
                ->line('Ce lien expirera dans 60 minutes.')
                ->line("Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.");
        });
    }
}
