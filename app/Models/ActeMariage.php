<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeMariage extends Model
{
    use HasFactory;

    protected $table = 'actes_mariage';

    protected $fillable = [
        'acte_id', 'nom_epoux', 'nom_epouse', 'temoin_1', 'temoin_2', 'regime_matrimonial',
    ];

    public function acte()
    {
        return $this->belongsTo(Acte::class);
    }
}
