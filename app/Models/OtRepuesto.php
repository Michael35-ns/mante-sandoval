<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class OtRepuesto extends Model
{
    public $timestamps = false;

    protected $table = 'ot_repuestos';

    protected $fillable = ['ot_id', 'repuesto_id', 'cantidad', 'costo_unitario'];

    protected $guarded = ['costo_total'];

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'ot_id');
    }

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class, 'repuesto_id');
    }
}