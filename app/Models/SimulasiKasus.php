<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulasiKasus extends Model
{
    /** @use HasFactory<\Database\Factories\SimulasiKasusFactory> */
    use HasFactory;

    protected $table = 'simulasi_kasus';
    protected $guarded = ['id'];
    protected $casts = ['pilihan' => 'array'];
}
