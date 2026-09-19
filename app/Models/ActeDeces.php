<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeDeces extends Model
{
    use HasFactory;

    protected $table = 'actes_deces';

    protected $fillable = [
        'acte_id', 'nom_defunt', 'prenom_defunt', 'cause_deces',
    ];

    public function acte()
    {
        return $this->belongsTo(Acte::class);
    }
}
