<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controlador_Envio;
use App\Http\Controllers\Controlador_Usuario;
USE App\Http\Controllers\Controlador_Afiliado;
use App\Http\Controllers\Controlador_ObraSocial;
use App\Http\Controllers\Controlador_Prestador;
use App\Http\Controllers\Controlador_Rol;
use App\Http\Controllers\Controlador_Area;


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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function(){
    Route::get('/usuario/listar/',[Controlador_Usuario::class,'list'])->name('usuario.listar');
    Route::get('/usuario/update/{id}',[Controlador_Usuario::class,'update'])->name('usuario.update');
    Route::get('/usuario/delete/{id}',[Controlador_Usuario::class,'delete'])->name('usuario.delete');
    Route::get('/usuario/register',[Controlador_Usuario::class,'register'])->name('usuario.registrar');
    Route::get('/usuario/detalle/{id}',[Controlador_Usuario::class,'mostrar'])->name('usuario.detalle');

    Route::post('/usuario/insert',[Controlador_Usuario::class,'insert'])->name('usuario.insert');
    Route::post('/usuario/edit/{id}',[Controlador_Usuario::class,'edit'])->name('usuario.edit');
    Route::post('/usuario/drop/{id}',[Controlador_Usuario::class,'drop'])->name('usuario.drop');
    Route::post('/usuario/search/',[Controlador_Usuario::class,'search'])->name('usuario.search');
    
    Route::get('/usuario/back',[Controlador_Usuario::class,'back'])->name('usuario.back');
});

Route::middleware('auth')->group(function(){
    Route::post('/envio/registrar',[Controlador_Envio::class,'registrar'])->name('envio.registrar');
    Route::get('/envio/index',[Controlador_Envio::class,'index'])->name('envio.index');
    Route::get('/envio/lista',[Controlador_Envio::class,'listar'])->name('envio.lista');
    
    Route::get('/envio/comprobante',[Controlador_Envio::class,'comprobante'])->name('envio.comprobante');
    Route::match(['get','post'],'/envio/buscar',[Controlador_Envio::class,'buscar'])->name('envio.buscar');
});

Route::middleware('auth')->group(function(){
    Route::get('/afiliado/listar',[Controlador_Afiliado::class,'list'])->name('afiliado.listar');
    Route::get('/afiliado/agregar',[Controlador_Afiliado::class,'register'])->name('afiliado.registrar');
    Route::get('/afiliado/modificar/{id}',[Controlador_Afiliado::class,'update'])->name('afiliado.modificar');
    Route::get('/afiliado/eliminar/{id}',[Controlador_Afiliado::class,'delete'])->name('afiliado.eliminar');

    Route::post('/afiliado/insert',[Controlador_Afiliado::class,'insert'])->name('afiliado.insertar');
    Route::post('/afiliado/edit/{id}',[Controlador_Afiliado::class,'edit'])->name('afiliado.actualizar');
    Route::post('/afiliado/delete/{id}',[Controlador_Afiliado::class,'drop'])->name('afiliado.borrar');
    Route::post('/afiliado/search/',[Controlador_Afiliado::class,'search'])->name('afiliado.search');
    
    Route::get('/afiliado/back',[Controlador_Afiliado::class,'back'])->name('afiliado.back');
});

Route::middleware('auth')->group(function(){
    Route::get('/obrasocial/listar',[Controlador_ObraSocial::class,'list'])->name('obrasocial.listar');
    Route::get('/obrasocial/agregar',[Controlador_ObraSocial::class,'register'])->name('obrasocial.registrar');
    Route::get('/obrasocial/modificar/{id}',[Controlador_ObraSocial::class,'update'])->name('obrasocial.modificar');
    Route::get('/obrasocial/eliminar/{id}',[Controlador_ObraSocial::class,'delete'])->name('obrasocial.eliminar');

    Route::post('/obrasocial/insert',[Controlador_ObraSocial::class,'insert'])->name('obrasocial.insertar');
    Route::post('/obrasocial/edit/{id}',[Controlador_ObraSocial::class,'edit'])->name('obrasocial.actualizar');
    Route::post('/obrasocial/delete/{id}',[Controlador_ObraSocial::class,'drop'])->name('obrasocial.borrar');
    Route::post('/obrasocial/search/',[Controlador_ObraSocial::class,'search'])->name('obrasocial.search');

    Route::get('/obrasocial/back',[Controlador_Obrasocial::class,'back'])->name('obrasocial.back');
});

Route::middleware('auth')->group(function(){
    Route::get('/prestador/listar',[Controlador_Prestador::class,'list'])->name('prestador.listar');
    Route::get('/prestador/agregar',[Controlador_Prestador::class,'register'])->name('prestador.registrar');
    Route::get('/presatdor/modificar/{id}',[Controlador_Prestador::class,'update'])->name('prestador.modificar');
    Route::get('/prestador/eliminar/{id}',[Controlador_Prestador::class,'delete'])->name('prestador.eliminar');

    Route::post('/prestador/insert',[Controlador_Prestador::class,'insert'])->name('prestador.insertar');
    Route::post('/prestador/edit/{id}',[Controlador_Prestador::class,'edit'])->name('prestador.actualizar');
    Route::post('/prestador/delete/{id}',[Controlador_Prestador::class,'drop'])->name('prestador.borrar');
    Route::post('/prestador/search/',[Controlador_Prestador::class,'search'])->name('prestador.search');

    Route::get('/prestador/back',[Controlador_Prestador::class,'back'])->name('prestador.back');
});

Route::middleware('auth')->group(function(){
    Route::get('/rol/listar',[Controlador_Rol::class,'list'])->name('rol.listar');
    Route::get('/rol/agregar',[Controlador_Rol::class,'register'])->name('rol.registrar');
    Route::get('/rol/modificar/{id}',[Controlador_Rol::class,'update'])->name('rol.modificar');
    Route::get('/rol/eliminar/{id}',[Controlador_Rol::class,'delete'])->name('rol.eliminar');

    Route::post('/rol/insert',[Controlador_Rol::class,'insert'])->name('rol.insertar');
    Route::post('/rol/edit/{id}',[Controlador_Rol::class,'edit'])->name('rol.actualizar');
    Route::post('/rol/delete/{id}',[Controlador_Rol::class,'drop'])->name('rol.borrar');
    Route::post('/rol/search/',[Controlador_Rol::class,'search'])->name('rol.search');

    Route::get('/rol/back',[Controlador_Rol::class,'back'])->name('rol.back');
});

Route::middleware('auth')->group(function(){
    Route::get('/area/listar',[Controlador_Area::class,'list'])->name('area.listar');
    Route::get('/area/agregar',[Controlador_Area::class,'register'])->name('area.registrar');
    Route::get('/area/modificar/{id}',[Controlador_Area::class,'update'])->name('area.modificar');
    Route::get('/area/eliminar/{id}',[Controlador_Area::class,'delete'])->name('area.eliminar');

    Route::post('/area/insert',[Controlador_Area::class,'insert'])->name('area.insertar');
    Route::post('/area/edit/{id}',[Controlador_Area::class,'edit'])->name('area.actualizar');
    Route::post('/area/delete/{id}',[Controlador_Area::class,'drop'])->name('area.borrar');
    Route::post('/area/search/',[Controlador_Area::class,'search'])->name('area.search');

    Route::get('/area/back',[Controlador_Area::class,'back'])->name('area.back');
});