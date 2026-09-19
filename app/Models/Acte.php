<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acte extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'numero_acte', 'agent_id', 'citoyen_id',
        'date_evenement', 'lieu_evenement', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_evenement' => 'date',
        ];
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function citoyen()
    {
        return $this->belongsTo(User::class, 'citoyen_id');
    }

    public function naissance()
    {
        return $this->hasOne(ActeNaissance::class);
    }

    public function mariage()
    {
        return $this->hasOne(ActeMariage::class);
    }

    public function deces()
    {
        return $this->hasOne(ActeDeces::class);
    }

    /**
     * Renvoie le sous-enregistrement correspondant au type de l'acte,
     * pour éviter de charger les 3 relations à chaque fois.
     */
    public function detail()
    {
        return match ($this->type) {
            'naissance' => $this->naissance,
            'mariage' => $this->mariage,
            'deces' => $this->deces,
            default => null,
        };
    }
}
