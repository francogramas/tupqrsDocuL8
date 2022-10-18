<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionUser extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'seccion_id',
        'empresa_id',
        'jefe'
    ];
    public function user()
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    public function seccionempresa()
    {
        return $this->belongsTo(SeccionEmpresa::class, 'seccion_id');
    }
}
