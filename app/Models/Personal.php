<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    public $timestamps = false;

    protected $table = 'personal';

    protected $fillable = ['nombre', 'cargo'];

    public function ordenesTrabajo()
    {
        return $this->belongsToMany(OrdenTrabajo::class, 'ot_personal', 'personal_id', 'ot_id');
    }
}