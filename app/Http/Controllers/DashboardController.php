<?php

namespace App\Http\Controllers;

use App\Exports\RecordatoriosExport;
use App\Models\EnvioRecordatorio;
use App\Models\Siniestro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {

        return view('dashboard');
    }

    public function sinSalida()
    {
        $sinSalida = Siniestro::selectRaw('COUNT(id) as cantidad, NOM_PERITO_ASIG')
            ->where('FEC_SAL_TALLER', '=', '')
            ->orWhere('FEC_SAL_TALLER', '=', NULL)
            ->groupBy('NOM_PERITO_ASIG')
            ->get();

        return DataTables::of($sinSalida)->toJson();
    }

    public function reporteSinSalida(){
        $sinSalida = Siniestro::where('FEC_SAL_TALLER', '=', '')
            ->get();
    }

    public function cambiosFechas()
    {

        $talleresMasCambios = DB::table('bitacora__fechas as bf')
            ->select(DB::raw('s.dsc_tercero AS taller, COUNT(bf.siniestro_id) AS cantidad'))
            ->join('siniestros as s', 'bf.siniestro_id', '=', 's.id')
            //->whereYear('bf.created_at', date('Y-m-d'))
			->where('bf.is_postponement','=', 1)
            ->groupBy('s.dsc_tercero')
            ->orderByDesc('cantidad')
            ->limit(10)
            ->get();

        return DataTables::of($talleresMasCambios)->toJson();
    }

    public function top10()
    {
        $top10 =  DB::table('siniestros')
            ->select(DB::raw('COUNT(id) as cantidad, DSC_TERCERO as taller, ROUND(SUM(total), 2) as total'))
            ->groupBy('DSC_TERCERO')
            ->orderByDesc('cantidad')
            ->limit(10)
            ->get();
        return DataTables::of($top10)->toJson();
    }

    public function avanceRespuesta()
    {
        $result = EnvioRecordatorio::select('siniestros.DSC_TERCERO as taller')
        ->join('siniestros', 'envio_recordatorios.siniestro_id', '=', 'siniestros.id')
        ->selectRaw('COUNT(*) as cantidad_enviados')
        ->selectRaw('SUM(fecha_respuesta IS NOT NULL) as cantidad_respondidos')
        ->selectRaw('SUM(fecha_respuesta IS NULL) as cantidad_sin_responder')
        ->groupBy('siniestros.DSC_TERCERO')
        ->get();

        
        // Calcular el porcentaje de avance con solo 2 decimales
        $result->transform(function ($item) {
            $item->avance = round(($item->cantidad_respondidos / $item->cantidad_enviados) * 100, 2);
            return $item;
        });

        return DataTables::of($result)->toJson();
    }
}
