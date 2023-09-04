<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Personal;
use App\Models\Workshop;
use App\Models\Siniestro;
use Illuminate\Http\Request;
use App\Models\EnvioRecordatorio;
use Illuminate\Support\Facades\DB;
use App\Exports\RecordatoriosExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
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
            
            if ($perito != []) 
			{
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
           $query->where('FEC_ENTREGA_EST', '=',  $fec_entresga_est );           
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
        $datos = Siniestro::get();//where('estado','=','no_enviado')
		
		$workshops = Workshop::where('name','!=','')
        ->select('name', 'id')
        ->get();
//dd($workshops);
        $peritos = Personal::select('id','full_name')->get();

        return $dataTable->render('admin.siniestros.index', compact('datos','workshops','peritos'));
		 
    }
	


    public function updateDate(Request $request)
    {
        $id = $request->input('campoId');

        $newDate = $request->input('newDate');

        dd($id, $newDate);

        try {
            $register = Siniestro::find($id);
            if ($register) {
                $register->FEC_ENTREGA_EST = $newDate;
                $register->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Registro no encontrado']);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error en la actualización']);
        }
    }

 
}
