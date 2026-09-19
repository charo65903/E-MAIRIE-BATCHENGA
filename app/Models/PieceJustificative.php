<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJustificative extends Model
{
    use HasFactory;

    protected $table = 'pieces_justificatives';

    protected $fillable = [
        'demande_id', 'nom_original', 'chemin_fichier', 'type_mime', 'taille',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
