<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded('id')]
class ProgressMateri extends Model
{
    protected $casts = [
        'is_completed' => 'boolean',
    ];
}
