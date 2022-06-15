<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    Route::get('/impdocumento/{documento}', [App\Http\Controllers\impDocumentoController::class, 'seguimiento'])->name('impdocumento');
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

/** --------------------------------- Roles de gerente ----------------------------------------------------- **/
Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:Gerente']], function () {
    Route::get('empresauser', App\Http\Livewire\EmpresaUsuarioCompoment::class)->name('empresauser');
    Route::get('gerente', App\Http\Livewire\GerenteComponent::class)->name('gerente');
    Route::get('informe', App\Http\Livewire\InformeComponent::class)->name('informe');
    Route::get('informedia', App\Http\Livewire\InformeDiaComponent::class)->name('informedia');
    Route::get('ventanilla', App\Http\Livewire\VentanillaComponent::class)->name('ventanilla');
});

/** --------------------------------- Roles de Lider ----------------------------------------------------- **/
Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:Lider']], function () {
    Route::get('lider', App\Http\Livewire\LiderComponent::class)->name('lider');
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
