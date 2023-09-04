<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Siniestro;
use App\Jobs\SendEmailJob;
use App\Jobs\SendEmailNJob;
use App\Jobs\SendEmailSJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EnviarRecordatorios extends Command
{
    protected $signature = 'recordatorios:enviar';

    protected $description = 'Command description';

    public function handle(): void
    {

        // Obtener los siniestros con MCA_PAR = N y enviar correos antes de los 2 y 10 días de la fecha de entrega estimada
        $siniestrosN = Siniestro::where('MCA_PAR', 'N_xxx')->get();
		//$siniestrosN = Siniestro::where('NUM_SINI', '100130123020687')->get(); //486
		//$siniestrosN = Siniestro::where('ID', '2207')->get(); //'NUM_SINI', '100130123022522')
		
		
		$texto = "Hola mundo - " .date("Y-m-d H:i:s");
		//Storage::append("archivo.txt",$texto);

        foreach ($siniestrosN as $siniestro) {
            $fechaEntregaEstimada = Carbon::parse($siniestro->fecha_entrega_estimada);

            // Verificar si faltan 2 días para la fecha de entrega estimada
            if (Carbon::now()->diffInDays($fechaEntregaEstimada) === 2) {
                // Enviar correo al taller asociado

                $data = [
                    'email' => 'recordatorio@asvnets.com',
                    'subject' => 'Recordatorio Entrega vehiculo:  ' . $fechaEntregaEstimada  .' - ' .$siniestro->MATRICULA,
                    'siniestro' => $siniestro,
                ];
            
                //dispatch(new SendEmailJob($data));
            }

            // Verificar si faltan 10 días para la fecha de entrega estimada
            if (Carbon::now()->diffInDays($fechaEntregaEstimada) === 1000) {
                // Enviar correo al taller asociado
                
                $data = [
                    'email' => 'recordatorio@asvnets.com',
                    'subject' => 'Recordatorio Entrega vehiculo:  '.$siniestro->MATRICULA,
                    'siniestro' => $siniestro,
                ];
            
                //dispatch(new SendEmailJob($data));
            }
        }

        // Obtener los siniestros con MCA_PAR = S y enviar correos después de 2 días
        //$siniestrosS = Siniestro::where('MCA_PAR', 'S')->get();
		$siniestrosS = Siniestro::where('ID', '2207')->get(); //'NUM_SINI', '100130123022522')
        foreach ($siniestrosS as $siniestro) {
			$createdDate = Carbon::createFromFormat('d/m/Y', $siniestro->created_at);
			$daysDiff = $createdDate->diffInDays(Carbon::now());

            // Verificar si han pasado 2 días desde la inserción del siniestro
            //if (Carbon::parse($siniestro->created_at)->diffInDays(Carbon::now()) == 2) { //OLD
			//if ($daysDiff === 2) {	
                // Enviar correo al taller asociado
                // Lógica para enviar correo_1
                $data = [
                    'email' => 'recordatorio@asvnets.com',
                    'subject' => 'Recordatorio Entrega vehiculo:  '.$siniestro->MATRICULA,
                    'siniestro' => $siniestro,
                ];
            
                dispatch(new SendEmailSJob($data));
            //}
        }
    }
}
