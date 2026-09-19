<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'citoyen_id', 'service_id', 'agent_id', 'description', 'statut', 'motif_rejet',
    ];

    public function citoyen()
    {
        return $this->belongsTo(User::class, 'citoyen_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function piecesJustificatives()
    {
        return $this->hasMany(PieceJustificative::class);
    }

    public function documentGenere()
    {
        return $this->hasOne(DocumentGenere::class);
    }
}
