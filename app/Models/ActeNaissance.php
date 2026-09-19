<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeNaissance extends Model
{
    use HasFactory;

    protected $table = 'actes_naissance';

    protected $fillable = [
        'acte_id', 'nom_enfant', 'prenom_enfant', 'sexe', 'nom_pere', 'nom_mere',
    ];

    public function acte()
    {
        return $this->belongsTo(Acte::class);
    }
}
