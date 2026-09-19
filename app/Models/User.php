<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'password', 'role', 'actif',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'actif' => 'boolean',
        ];
    }

    // --- Helpers de rôle ---

    public function isAdministrateur(): bool
    {
        return $this->role === 'administrateur';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isCitoyen(): bool
    {
        return $this->role === 'citoyen';
    }

    // --- Relations ---

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'citoyen_id');
    }

    public function demandesTraitees()
    {
        return $this->hasMany(Demande::class, 'agent_id');
    }

    public function actesEnregistres()
    {
        return $this->hasMany(Acte::class, 'agent_id');
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'citoyen_id');
    }

    public function notificationsApp()
    {
        return $this->hasMany(NotificationApp::class);
    }
}
