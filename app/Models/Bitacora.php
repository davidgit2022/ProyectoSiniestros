<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $fillable = [
        "archivo_nombre",
        "fecha_carga",
		"created_by",
        "cantidad_registros",
    ];
	
	
	
    public function create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
	
	
    
}
