<?php

namespace App\Models;

use App\Models\EnvioRecordatorio;
use App\Models\Bitacora;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UbigeoDepartamento;

class Siniestro extends Model
{
    use HasFactory;

    protected $fillable = [
        "NRO",
        "NUM_SINI",
        "EST_EXP",
        "PROVINCIA_OCURRENCIA",
        "FEC_SINI",
        "FEC_APERTURA",
        "TIP_VEHI_SINIESTRO",
        "MATRICULA",
        "DSC_MARCA",
        "DSC_MODELO",
        "ANIO_FAB",
        "TIP_VEHI",
        "SUMA_ASEG",
        "DSC_TERCERO",
        "NOM_PERITO_ASIG",
        "NOM_EJECUTIVO",
        "FEC_PETICION",
        "FEC_ENTRADA",
        "FEC_AUTORIZACION",
        "FEC_ENTREGA_EST",
        "NUM_DIAS_REP",
        "TOTAL",
        "TIP_EST_INSP",
        "MCA_PERD_TOTAL",
        "AUTO_WEB",
        "TIP_EXP",
        "COD_MON",
        "TIP_MARCACION",
        "NUM_POLIZA_GRUPO",
        "NUM_POLIZA",
        "NOM_MOD",
        "NOM_OFICINA",
        "TIP_DOCUM_ASEG",
        "COD_DOCUM_ASEG",
        "NOMBRE",
        "USO",
        "LUGAR",
        "FEC_SAL_TALLER",
        "TLF_ASEG1",
        "TLF_ASEG2",
        "OFIC",
        "AGT",
        "NOM_PROCURADOR",
        "MCA_PAR",
        "P_DSCTO_PRONTO_PAGO",
        "TIPO_PERITACION",
        "NOTIFICADO",
        'created_at'
    ];
	
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }


    public function enviosRecordatorios()
    {
        return $this->hasMany(EnvioRecordatorio::class, 'siniestro_id');
    }
	
   public function bitacora()
    {
        return $this->belongsTo(Bitacora::class, 'siniestro_id');
    }
}
