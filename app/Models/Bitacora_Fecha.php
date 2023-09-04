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
    ];
	
	 public function siniestro()
    {
        return $this->belongsTo(Siniestro::class, 'siniestro_id');
    }
    
}
