<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    public $timestamps = false;

    protected $fillable = ['codigo', 'descripcion', 'costo_unitario'];

    public function usos()
    {
        return $this->hasMany(OtRepuesto::class, 'repuesto_id');
    }
}
