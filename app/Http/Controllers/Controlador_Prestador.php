<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestador;

class Controlador_Prestador extends Controller
{
    public function list(){
        $lista = Prestador::listar_prestadores();

        return view('prestadores.listar',compact('lista'));
    }

    public function register(){
        return view('prestadores.registrar');
    }

    public function update($id){
        $prestador = Prestador::where('id',$id)
            ->first();

        return view('prestadores.modificar',compact('prestador'));
    }

    public function delete($id){
        $prestador = Prestador::where('id',$id)
            ->first();

        return view('prestadores.eliminar',compact('prestador'));
    }

    /**
     * 
     */

    public function insert(Request $request){
        $matricula = $request->input('matricula');
        $nombre = $request->input('nombre');
        $telefono = $request->input('telefono');
        $email = $request->input('email');

        Prestador::agregar_prestador($matricula,$nombre,$telefono,$email);

        return redirect()->route('prestador.listar');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $matricula = $request->input('matricula');
        $nombre = $request->input('nombre');
        $telefono = $request->input('telefono');
        $email = $request->input('email');

        Prestador::modificar_prestador($id,$matricula,$nombre,$telefono,$email);

        return redirect()->route('prestador.listar');
    }

    public function drop(Request $request){
        $id = $request->input('id');

        Prestador::eliminar_prestador($id);

        return redirect()->route('prestador.listar');
    }

    public function search(Request $request){
        $buscar = $request->input('search');
        if($buscar !== null){
            $lista = Prestador::buscar_prestador($buscar);
            return view('prestadores.listar',compact('lista'));
        }else{
            return redirect()->route('prestador.listar');
        }
    }

    public function back(){
        return redirect()->route('presatador.listar');
    }
}
