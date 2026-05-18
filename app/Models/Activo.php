<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    public $timestamps = false;

    protected $fillable = ['codigo', 'nombre', 'area', 'tipo', 'estado','fecha_registro'];

    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class, 'activo_id');
    }

    public function paros()
    {   
        return $this->hasMany(Paro::class, 'activo_id');
    }
}