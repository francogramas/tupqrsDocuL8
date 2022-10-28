<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\impDocumentoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/impradicado/{radicado}', [App\Http\Controllers\impRadicadoController::class, 'radicado'])->name('impradicado');
    Route::get('/impficha/{radicado}', [App\Http\Controllers\impRadicadoController::class, 'ficha'])->name('impficha');
    Route::get('/impdocumento/{documento}', [impDocumentoController::class, 'seguimiento'])->name('impdocumento');
    Route::get('/imparchivo/{archivo}', [impDocumentoController::class, 'archivo'])->name('imparchivo');
    Route::get('/impoficio/{seguimiento_id}', [impDocumentoController::class, 'oficio'])->name('impoficio');
});

Route::controller(impDocumentoController::class)->group(function () {
    Route::get('/respsolicitud/{solicitud_id}', 'seguimientoLider');
    Route::post('/respsolicitud/{seguimiento_id}','responderSolicitud');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if(Auth::user()->hasRole('Gerente')){
        return redirect('empresauser');
    }
    elseif(Auth::user()->hasRole('Lider')){
        return redirect('lider');
    }
    elseif(Auth::user()->hasRole('Admin')){
        return redirect('empresas');
    }
    elseif(Auth::user()->hasRole('Ventanilla')){
        return redirect('ventanilla');
    }
})->name('dashboard');


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:Jefe']], function () {
    Route::get('jefe', App\Http\Livewire\JefeComponent::class)->name('jefe');
});

/** --------------------------------- Roles de gerente ----------------------------------------------------- **/
Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:Gerente']], function () {
    Route::get('empresauser', App\Http\Livewire\EmpresaUsuarioCompoment::class)->name('empresauser');
    Route::get('gerente', App\Http\Livewire\GerenteComponent::class)->name('gerente');
    Route::get('informe', App\Http\Livewire\InformeComponent::class)->name('informe');
    Route::get('informedia', App\Http\Livewire\InformeDiaComponent::class)->name('informedia');
    Route::get('digitalizacion', App\Http\Livewire\DigitalzacionComponent::class)->name('digitalizacion');
    Route::get('ventanilla', App\Http\Livewire\VentanillaComponent::class)->name('ventanilla');

});

/** --------------------------------- Roles de Lider ----------------------------------------------------- **/
Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:Lider']], function () {
    Route::get('lider', App\Http\Livewire\LiderComponent::class)->name('lider');
});

/** --------------------------------- Roles de Ventanilla/Gerente ----------------------------------------------------- **/
Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:Ventanilla']], function () {
    Route::get('ventanilla', App\Http\Livewire\VentanillaComponent::class)->name('ventanilla');
});


/** --------------------------------- Roles de Admin ----------------------------------------------------- **/
Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:Admin']], function () {
    Route::get('empresas', App\Http\Livewire\AdminEmpresasComponent::class)->name('empresas');
    Route::get('subseries', App\Http\Livewire\SubseriesComponent::class)->name('subseries');
});

Route::get('h', App\Http\Livewire\SolicitudHome::class)->name('home');
Route::get('e', App\Http\Livewire\EncuestaComponent::class)->name('e');
Route::get('actualizarEstado/{id}', [App\Http\Controllers\actualizarEstadoController::class, 'show'])->name('actualizarEstado');

Route::get('qrcode/{url}',  function($url)
{
    return view('qurcode')->with('url', $url);
});

Route::get('/pdftest', [\App\Http\Controllers\pdfTestController::class,'process']);
Route::get('test', fn () => phpinfo());

/*--------------------------------------------------------------------------*/
// Gestión de verificación de correos y recuperación de contraseñas

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*--------------------------------------------------------------------------*/
