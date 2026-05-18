<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paro extends Model
{
    public $timestamps = false;

    protected $fillable = ['activo_id', 'fecha_inicio', 'fecha_fin', 'causa'];

    protected $guarded = ['horas_paro'];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id');
    }
}
