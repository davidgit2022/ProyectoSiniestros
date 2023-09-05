<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Personal;
use App\Models\Workshop;
use App\Models\Siniestro;
use Illuminate\Http\Request;
use App\Models\Bitacora_Fecha;
use App\Models\EnvioRecordatorio;
use Illuminate\Support\Facades\DB;
use App\Exports\RecordatoriosExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\DataTables\Admin\SiniestroDataTable;
use App\DataTables\Admin\CronJobTallerDataTable;
use App\DataTables\Admin\EnvioRecordatorioDataTable;
use App\DataTables\Admin\ConfirmacionTallerDataTable;

class SiniestrosController extends Controller
{
    //route: siniestros/data  
    public function getData(Request $request)
    {
        $filtro = $request->filtro;
        $placa = $request->placa;
        $fec_entresga_est = $request->fec_entresga_est;
        $siniestro = $request->siniestro;
        $taller = $request->taller;
        $per = $request->perito;

        $user = Auth::user();
        $role = Auth::user()->roles[0]->name;

        if ($role == 'Perito') {
            $perito = Personal::where('email', '=', $user->email)->first();

            if ($perito != []) {
                $query = Siniestro::with('enviosRecordatorios');
                $query->where('NOM_PERITO_ASIG', '=', $perito->full_name);
            }
        } else {
            $query = Siniestro::with('enviosRecordatorios');
        }


        if ($placa) {
            $query->where('MATRICULA', 'LIKE', '%' . $placa . '%');
        }
        if ($fec_entresga_est) {
            $query->where('FEC_ENTREGA_EST', '=',  $fec_entresga_est);
        }

        if ($siniestro) {
            $query->where('NUM_SINI', 'LIKE', '%' . $siniestro . '%');
        }

        if ($taller) {
            $query->where('DSC_TERCERO', 'LIKE', '%' . $taller . '%');
        }

        if ($per) {
            $query->where('NOM_PERITO_ASIG', 'LIKE', '%' . $per . '%');
        }

        $registros = $query->get();

        return DataTables::of($registros)->toJson();
    }


    //route: 	data-full, [SiniestrosController::class , 'index'])->name('data-full');
    public function index(SiniestroDataTable $dataTable)
    {
        $datos = Siniestro::get(); //where('estado','=','no_enviado')

        $workshops = Workshop::where('name', '!=', '')
            ->select('name', 'id')
            ->get();

        $peritos = Personal::select('id', 'full_name')->get();

        return $dataTable->render('admin.siniestros.index', compact('datos', 'workshops', 'peritos'));
    }

    public function crearBitacoraFecha(Request $request)
    {

        $siniestroId = $request->input('siniestroId');
        $siniestro = Siniestro::find($siniestroId, ['id', 'FEC_ENTREGA_EST']);
        
        $fechaActual = $siniestro->FEC_ENTREGA_EST;
        $tallerId = $request->input('taller');
        $nuevaFecha = $request->input('newDate');
        $comment = $request->input('comment');
        

        $validator = Validator::make($request->all(), [
            'taller' => 'required',
            'newDate' => "required|date|after:{$fechaActual}",

        ], [
            'taller.required' => 'El campo debe ser requerido ',
            'newDate.required' => 'El campo debe ser requerido ',
            'newDate.date' => 'El campo debe ser formato fecha ',
            'newDate.after' => 'La fecha nueva debe ser mayor que la fecha actual'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $bitacoraFecha = Bitacora_Fecha::create([ 

            'siniestro_id' => $siniestroId,
            'usuario_actualiza_id' => $tallerId,
            'fecha_anterior' => $fechaActual,
            'fecha_nueva' => $nuevaFecha,
            'is_postponement' => 0,
            'comment' => $comment,
            'confirmacion_taller' => 0,
            'fec_confirmacion' => null,
        ]);

        $siniestro->update(['FEC_ENTREGA_EST' => $nuevaFecha]);
        return Response()->json($bitacoraFecha);
    }

    public function obtenerDatosBitacora($siniestroId)
    {
        $bitacoraDatos = Bitacora_Fecha::where('siniestro_id', $siniestroId)->get();

        $siniestro = Siniestro::find($siniestroId, ['id', 'FEC_ENTREGA_EST']);

        $datos = [
            'fecha_inicial' => $siniestro->FEC_ENTREGA_EST,
            'bitacora' => $bitacoraDatos,
            'created_at' => $siniestro->create_function,
        ];

        return response()->json($datos);
    }
}
