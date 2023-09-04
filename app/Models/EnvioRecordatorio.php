<?php

namespace App\Models;

use App\Models\Siniestro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnvioRecordatorio extends Model
{	
	use HasFactory;
	
    public function siniestro()
    {
        return $this->belongsTo(Siniestro::class, 'siniestro_id');
    }
	
	
 
}
