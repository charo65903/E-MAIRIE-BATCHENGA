<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'documents_requis', 'tarif', 'delai', 'actif',
    ];

    protected function casts(): array
    {
        return [
            'actif' => 'boolean',
            'tarif' => 'decimal:2',
        ];
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}
