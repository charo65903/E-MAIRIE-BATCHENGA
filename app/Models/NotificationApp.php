<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationApp extends Model
{
    use HasFactory;

    protected $table = 'notifications_app';

    protected $fillable = [
        'user_id', 'titre', 'message', 'type', 'lu',
    ];

    protected function casts(): array
    {
        return [
            'lu' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
