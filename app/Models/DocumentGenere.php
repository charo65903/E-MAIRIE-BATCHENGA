<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentGenere extends Model
{
    use HasFactory;

    protected $table = 'documents_generes';

    protected $fillable = [
        'demande_id', 'reference', 'chemin_fichier', 'qr_code_path', 'date_generation',
    ];

    protected function casts(): array
    {
        return [
            'date_generation' => 'datetime',
        ];
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
