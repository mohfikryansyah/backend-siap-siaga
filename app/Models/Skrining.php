<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded('id')]
class Skrining extends Model
{
    /** @use HasFactory<\Database\Factories\SkriningFactory> */
    use HasFactory;

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
