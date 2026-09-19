<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'citoyen_id', 'service_id', 'motif', 'date_rdv', 'creneau', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_rdv' => 'date',
        ];
    }

    public function citoyen()
    {
        return $this->belongsTo(User::class, 'citoyen_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
