<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mailEmpresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'asunto',
        'mensaje',
        'empresa_id',
    ];
}
