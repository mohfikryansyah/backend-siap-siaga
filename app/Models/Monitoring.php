<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Monitoring extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_minggu' => 'date',
        'mood' => 'integer',
        'interaksi_sosial' => 'integer',
        'tidur' => 'decimal:1',
        'aktivitas' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke anggota keluarga
    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    // Helper: label mood
    public static function moodLabel(int $mood): string
    {
        return match ($mood) {
            1 => 'Sangat Buruk',
            2 => 'Buruk',
            3 => 'Cukup',
            4 => 'Baik',
            5 => 'Sangat Baik',
            default => '-',
        };
    }
}
