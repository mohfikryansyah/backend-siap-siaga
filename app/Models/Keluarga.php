<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded('id')]
class Keluarga extends Model
{
    /** @use HasFactory<\Database\Factories\KeluargaFactory> */
    use HasFactory;

    public function skrining(): HasMany
    {
        return $this->hasMany(Skrining::class, 'user_id');
    }
}
