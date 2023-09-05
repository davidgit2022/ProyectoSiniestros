<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora_Fecha extends Model
{
    use HasFactory;

    protected $fillable = [
        'siniestro_id',
        'usuario_actualiza_id',
        'fecha_anterior',
        'fecha_nueva',
        'is_postponement',
        'comment',
        'confirmacion_taller',
        'fec_confirmacion',
        'created_at'
    ];
	
	 public function siniestro()
    {
        return $this->belongsTo(Siniestro::class, 'siniestro_id');
    }
    
    
}
