<?php

use Carbon\Carbon;
use App\Models\Siniestro;
use App\Jobs\SendEmailJob;
use App\Jobs\SendEmailNJob;
use App\Jobs\SendEmailSJob;
use App\Helpers\EncryptionHelper;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\MaintenanceDetailController;
use App\Http\Controllers\Admin\OrganizationController;
 
use App\Http\Controllers\Admin\RoleContoller;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Manager\UserController as ManagerUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PersonalController;
 
use App\Http\Controllers\Admin\WorkshopController;
use App\Http\Controllers\ManagerWorkshopController;
use App\Http\Controllers\Forms\UpdateFormsController; 
use App\Http\Controllers\Admin\RespuestasController;
use App\Http\Controllers\Admin\SeguimientoController; 
use App\Http\Controllers\Admin\SiniestrosController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

 
/* Repuestas*/
 Route::post('respuestas/recordar', [RespuestasController::class, 'recordar'])->name('respuestas.recordar');
 
/*Sin salida taller*/
Route::get('/sin-salida/data', [DashboardController::class, 'sinSalida'])->name('dashboard.sinSalida');
Route::get('/cambios-fecha/data', [DashboardController::class, 'cambiosFechas'])->name('dashboard.cambiosFechas');
Route::get('/top-10/data', [DashboardController::class, 'top10'])->name('dashboard.top10');
Route::get('/avance-respuesta/data', [DashboardController::class, 'avanceRespuesta'])->name('dashboard.avanceRespuesta');
 
//Seguimiento correos no enviados - confirmados
Route::get('follow_no_send', [SeguimientoController::class , 'index'])->name('seguimiento.not_sent');
Route::get('seguimiento/data', [SeguimientoController::class , 'getData'])->name('seguimiento.data');
Route::get('cronjob', [SeguimientoController::class , 'cronjob'])->name('seguimiento.cronjob');
Route::get('confirmed', [SeguimientoController::class , 'confirmed'])->name('seguimiento.confirmed');
Route::get('/admin/lista_registros', [ExcelController::class, 'lista_registros'])->name('admin.lista_registros');
Route::get('/perito/lista_registros', [ExcelController::class, 'lista_registros'])->name('admin.lista_registros');
Route::get('data-full', [SiniestrosController::class , 'index'])->name('data-full');
Route::get('siniestros/data', [SiniestrosController::class , 'getData'])->name('siniestros.data');


Route::post('siniestros/crear-bitacora-fecha', [SiniestrosController::class, 'crearBitacoraFecha'])->name('siniestros.crearBitacoraFecha');

Route::get('/obtener-datos-bitacora/{siniestroId}',     [SiniestrosController::class,'obtenerDatosBitacora']);




Route::middleware('auth')->group(function () {
	
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	route::get('bitacora/detail/{registro}', [ExcelController::class, 'bitacoradetail'])->name('admin.bitacora.detail');
	Route::post('/actualizarFecha', [ExcelController::class, 'actualizarFecha'])->name('admin.excel.fecha');
	Route::get('/mostrarSiniestro/{registro}', [ExcelController::class, 'mostrarSiniestro'])->name('admin.excel.mostrar');
	
	//Route::get('lista/bitacora', [ExcelController::class, 'lista_cargas'])->name('lista.bitacora');
	//Route::get('bitacora/detail/{registro}', [ExcelController::class, 'bitacoradetail'])->name('admin.bitacora.detail');
    Route::prefix('admin')->name('admin.')->group(function () {
		 
        Route::middleware('role:Admin')->group(function () {
 
			//Route::get('respuestas', [RespuestasController::class , 'index'])->name('respuestas.index');			 
			Route::get('respuestas/export', [RespuestasController::class , 'export'])->name('respuestas.export'); 
		 

			
        });        
        Route::resource('users', UserController::class);	
    });

    Route::middleware('role:Perito')->prefix('perito')->name('perito.')->group(function () {
		
        Route::resource('users', ManagerUserController::class);
		 
			//Rutas de carga de excel
            Route::get('/perito/upload', [ExcelController::class, 'inicio'])->name('admin.excel.upload');
			
            //Route::post('/excel', [ExcelController::class, 'recibirExcel'])->name('admin.excel.recibir.excel');
            
            //Route::get('/mostrarSiniestro/{registro}', [ExcelController::class, 'mostrarSiniestro'])->name('admin.excel.mostrar');
            //Route::post('/actualizarFecha', [ExcelController::class, 'actualizarFecha'])->name('admin.excel.fecha');
			
			Route::get('bitacora/detail/{registro}', [ExcelController::class, 'bitacoradetail'])->name('admin.bitacora.detail');
			
    });

    Route::middleware('role:User')->name('user.')->group(function () {
		
		

    });
});

require __DIR__.'/auth.php';
