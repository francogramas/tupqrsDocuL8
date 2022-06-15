<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    use HasFactory;
    public $table = 'empresas';
    protected $fillable = ['nit',     
     'razonsocial',
     'direccion',
     'telefono',
     'email',
     'logo',
     'ciudad_id',
     'user_id',
     'url',
     'estado_id',     
    ];
    
    public function user()
    {
        return $this->belongsTo(user::class);
    }
    
    public function secciones()
    {
        return $this->hasMany(SeccionEmpresa::class, 'empresa_id');
    }
    public function ciudad()
    {
        return $this->belongsTo(Ciudade::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoEmpresa::class);
    }
}
