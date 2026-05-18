<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    public $timestamps = false;

    protected $table = 'ordenes_trabajo';

    protected $fillable = ['activo_id', 'tipo', 'fecha_inicio', 'fecha_fin', 'descripcion'];

    // horas_intervencion es columna generada, no se llena manualmente
    protected $guarded = ['horas_intervencion'];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id');
    }

    public function personal()
    {
        return $this->belongsToMany(Personal::class, 'ot_personal', 'ot_id', 'personal_id');
    }

    public function repuestos()
    {
        return $this->hasMany(OtRepuesto::class, 'ot_id');
    }
}