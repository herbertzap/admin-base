<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomsDeclarationController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\EmpresaTransportistaController;
use App\Http\Controllers\TipoContenedorController;
use App\Http\Controllers\AduanaChileController;
use App\Http\Controllers\LugarDepositoController;
use App\Http\Controllers\LogisticaController;
use App\Http\Controllers\TatcController;
use App\Http\Controllers\TstcController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\ControlPlazosController;
use App\Http\Controllers\ControlInventariosController;
use App\Http\Controllers\ControlFiscalizacionController;




            
//rutas inicio de sesion
Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::get('/user-profile', [ProfileController::class, 'create'])->name('user-profile');
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::put('profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
//rutas de usuario
//Route::middleware(['auth','role:admin'])->group(function () {
Route::middleware(['auth'])->group(function () {
    Route::get('user-management', [UserManagementController::class, 'index'])->name('user-management.index');
    Route::get('user-management/create', [UserManagementController::class, 'create'])->name('user-management.create');
    Route::post('user-management', [UserManagementController::class, 'store'])->name('user-management.store');
    Route::get('user-management/{user}', [UserManagementController::class, 'show'])->name('user-management.show');
    Route::get('user-management/{user}/edit', [UserManagementController::class, 'edit'])->name('user-management.edit');
    Route::put('user-management/{user}', [UserManagementController::class, 'update'])->name('user-management.update');
    Route::delete('user-management/{user}', [UserManagementController::class, 'destroy'])->name('user-management.destroy');
});
//rutas de sistema hermes
Route::group(['middleware' => 'auth'], function () {
	// Rutas del Sistema Hermes
	Route::resource('companies', CompanyController::class);
	Route::resource('customs-declarations', CustomsDeclarationController::class);
	Route::resource('merchandise', MerchandiseController::class);
	Route::resource('tickets', TicketController::class);
	Route::resource('operadores', OperadorController::class)->parameters(['operadores' => 'operador']);
	
	// Rutas de Mantenedores
	Route::resource('empresa-transportistas', EmpresaTransportistaController::class);
	Route::resource('tipo-contenedors', TipoContenedorController::class);
	Route::resource('aduana-chiles', AduanaChileController::class);
	Route::resource('lugar-depositos', LugarDepositoController::class);
});

// Rutas de Logística
Route::group(['middleware' => 'auth'], function () {
    Route::resource('logistica', LogisticaController::class);
    Route::get('inventario', [LogisticaController::class, 'inventario'])->name('inventario');
});

// Rutas de TATC
Route::group(['middleware' => 'auth'], function () {
    Route::resource('tatc', TatcController::class);
    Route::get('tatc-consulta', [TatcController::class, 'consulta'])->name('tatc.consulta');
    Route::get('tatc-exportar', [TatcController::class, 'exportar'])->name('tatc.exportar');
    Route::post('tatc-exportar', [TatcController::class, 'procesarExportacion'])->name('tatc.procesar-exportacion');
    Route::get('tatc-carga-masiva', [TatcController::class, 'cargaMasiva'])->name('tatc.carga-masiva');
    Route::post('tatc-buscar', [TatcController::class, 'buscar'])->name('tatc.buscar');
    Route::get('tatc/{tatc}/pdf', [TatcController::class, 'generarPdf'])->name('tatc.pdf');
    Route::post('tatc/generar-numero', [TatcController::class, 'generarNumeroTatcAjax'])->name('tatc.generar-numero');
});

// Rutas de TSTC
Route::group(['middleware' => 'auth'], function () {
    Route::resource('tstc', TstcController::class);
    Route::get('tstc-consulta', [TstcController::class, 'consulta'])->name('tstc.consulta');
    Route::get('tstc-exportar', [TstcController::class, 'exportar'])->name('tstc.exportar');
    Route::post('tstc-exportar', [TstcController::class, 'procesarExportacion'])->name('tstc.procesar-exportacion');
    Route::get('tstc/{tstc}/pdf', [TstcController::class, 'generarPdf'])->name('tstc.pdf');
    Route::post('tstc/generar-numero', [TstcController::class, 'generarNumeroTstcAjax'])->name('tstc.generar-numero');
});

// Rutas de Salidas y Cancelaciones
Route::group(['middleware' => 'auth'], function () {
    Route::resource('salidas', SalidaController::class);
    Route::get('salidas-consulta', [SalidaController::class, 'consulta'])->name('salidas.consulta');
    Route::get('salidas-exportar', [SalidaController::class, 'exportar'])->name('salidas.exportar');
    Route::post('salidas-exportar', [SalidaController::class, 'procesarExportacion'])->name('salidas.procesar-exportacion');
    Route::post('salidas/obtener-tatcs-vigentes', [SalidaController::class, 'obtenerTatcsVigentes'])->name('salidas.obtener-tatcs-vigentes');
    Route::get('salidas/registrar/{tatc}', [SalidaController::class, 'registrarSalida'])->name('salidas.registrar');
});

// Rutas de Control de Plazos
Route::group(['middleware' => 'auth'], function () {
    Route::get('control-plazos/plazos-vigencia', [ControlPlazosController::class, 'plazosVigencia'])->name('control-plazos.plazos-vigencia');
    Route::get('control-plazos/registro-cancelacion', [ControlPlazosController::class, 'registroCancelacion'])->name('control-plazos.registro-cancelacion');
    Route::get('control-plazos/registro-prorrogas', [ControlPlazosController::class, 'registroProrrogas'])->name('control-plazos.registro-prorrogas');
    Route::get('control-plazos/registro-traspaso', [ControlPlazosController::class, 'registroTraspaso'])->name('control-plazos.registro-traspaso');
    Route::get('control-plazos/{tipo}/{id}', [ControlPlazosController::class, 'show'])->name('control-plazos.show');
    Route::get('control-plazos/buscar', [ControlPlazosController::class, 'buscar'])->name('control-plazos.buscar');
    Route::post('control-plazos/exportar', [ControlPlazosController::class, 'exportar'])->name('control-plazos.exportar');
});

// Rutas de Control de Inventarios
Route::group(['middleware' => 'auth'], function () {
    Route::get('control-inventarios', [ControlInventariosController::class, 'index'])->name('control-inventarios.index');
    Route::post('control-inventarios/exportar', [ControlInventariosController::class, 'exportar'])->name('control-inventarios.exportar');
});

// Rutas de Control de Fiscalización
Route::group(['middleware' => 'auth'], function () {
    Route::get('control-fiscalizacion/informe-movimientos', [ControlFiscalizacionController::class, 'informeMovimientos'])->name('control-fiscalizacion.informe-movimientos');
    Route::post('control-fiscalizacion/informe-movimientos', [ControlFiscalizacionController::class, 'informeMovimientos']);
    Route::get('control-fiscalizacion/busqueda-extraccion', [ControlFiscalizacionController::class, 'busquedaExtraccion'])->name('control-fiscalizacion.busqueda-extraccion');
    Route::post('control-fiscalizacion/busqueda-extraccion', [ControlFiscalizacionController::class, 'busquedaExtraccion']);
    Route::post('control-fiscalizacion/exportar', [ControlFiscalizacionController::class, 'exportar'])->name('control-fiscalizacion.exportar');
});