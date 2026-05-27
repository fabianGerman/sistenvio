<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class Controlador_Rol extends Controller
{
    public function list(){
        $lista = Rol::listar_roles();

        return view('roles.listar',compact('lista'));
    }

    public function register(){
        return view('roles.registrar');
    }

    public function update($id){
        $rol = Rol::where('id',$id)
            ->first();

        return view('roles.modificar',compact('rol'));
    }

    public function delete($id){
        $rol = Rol::where('id',$id)
            ->first();

        return view('roles.eliminar',compact('rol'));
    }

    /**
     * 
     */

    public function insert(Request $request){
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');

        Rol::agregar_rol($nombre,$descripcion);

        return redirect()->route('rol.listar');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');

        Rol::modificar_rol($id,$nombre,$descripcion);

        return redirect()->route('rol.listar');
    }

    public function drop(Request $request){
        $id = $request->input('id');

        Rol::eliminar_rol($id);

        return redirect()->route('rol.listar');
    }

    public function search(Request $request){
        $buscar = $request->input('search');
        if($buscar !== null){
            $lista = Rol::buscar_rol($buscar);
            return view('roles.listar',compact('lista'));
        }else{
            return redirect()->route('rol.listar');
        }
    }

    public function back(){
        return redirect()->route('rol.listar');
    }
}
