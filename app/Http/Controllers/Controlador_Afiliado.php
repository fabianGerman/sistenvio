<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Afiliado;

class Controlador_Afiliado extends Controller
{
    public function list(){
        $lista = Afiliado::listar_afiliado();
        return view('afiliados.listar',compact('lista'));
    }

    public function register(){
        return view('afiliados.registrar');
    }

    public function update($id){
        $afiliado = Afiliado::where('id',$id)
            ->first();

        return view('afiliados.modificar',compact('afiliado'));
    }

    public function delete($id){
        $afiliado = Afiliado::where('id',$id)
            ->first();

        return view('afiliados.eliminar',compact('afiliado'));
    }

    /**
     * 
     */
    
    public function insert(Request $request){
        $numero = $request->input('numero');
        $cuil = $request->input('cuil');
        $nombre = $request->input('nombre');

        Afiliado::agregar_afiliado($numero,$cuil,$nombre);

        return redirect()->route('afiliado.listar');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $numero = $request->input('numero');
        $cuil = $request->input('cuil');
        $nombre = $request->input('nombre');

        Afiliado::modificar_afiliado($id,$numero,$cuil,$nombre);

        return redirect()->route('afiliado.listar');
    }

    public function drop(Request $request){
        $id = $request->input('id');
        
        Afiliado::eliminar_afiliado($id);
        
        return redirect()->route('afiliado.listar');
    }

    public function search(Request $request){
        $buscar = $request->input('search');
        if($buscar !== null){
            $lista = Afiliado::buscar_afiliado($buscar);
            return view('afiliados.listar',compact('lista'));
        }else{
            return redirect()->route('afiliado.listar');
        }
    }

    public function back(){
        $lista = Afiliado::listar_afiliado();

        return redirect()->route('afiliado.listar');
    }
}
