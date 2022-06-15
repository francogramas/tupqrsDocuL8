<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsableSeccion extends Model
{
    use HasFactory;
    protected $fillable =[
        'nombrecompleto',
        'email',
        'telefono',
        'seccion_id'
    ];    
}
