<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObraSocial;

class Controlador_ObraSocial extends Controller
{
    public function list(){
        $lista = ObraSocial::listar_obrassociales();

        return view('obrasocial.listar',compact('lista'));
    }

    public function register(){
        return view('obrasocial.registrar');
    }

    public function update($id){
        $obrasocial = ObraSocial::where('id',$id)
            ->first();

        return view('obrasocial.modificar',compact('obrasocial'));
    }

    public function delete($id){
        $obrasocial = ObraSocial::where('id',$id)
            ->first();

        return view('obrasocial.eliminar',compact('obrasocial'));
    }

    /**
     * 
     */

    public function insert(Request $request){
        $numero = $request->input('numero');
        $nombre = $request->input('nombre');
        $siglas = $request->input('sigla');

        ObraSocial::agregar_obrasocial($numero,$nombre,$siglas);

        return redirect()->route('obrasocial.listar');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $numero = $request->input('numero');
        $nombre = $request->input('nombre');
        $siglas = $request->input('sigla');

        ObraSocial::modificar_obrasocial($id,$numero,$nombre,$siglas);

        return redirect()->route('obrasocial.listar');
    }

    public function drop(Request $request){
        $id = $request->input('id');

        ObraSocial::eliminar_obrasocial($id);

        return redirect()->route('obrasocial.listar');
    }

    public function search(Request $request){
        $buscar = $request->input('search');
        if($buscar !== null){
            $lista = ObraSocial::buscar_obrasocial($buscar);
            return view('obrasocial.listar',compact('lista'));
        }else{
            return redirect()->route('obrasocial.listar');
        }
    }

    public function back(){
        $lista = ObraSocial::listar_obrassociales();

        return redirect()->route('obrasocial.listar');
    }
}
