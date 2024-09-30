<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class Controlador_Area extends Controller
{
    public function list(){
        $lista = Area::listar_areas();

        return view('areas.listar',compact('lista'));
    }

    public function register(){
        return view('areas.registrar');
    }

    public function update($id){
        $area = Area::where('id',$id)
            ->first();
            
        return view('areas.modificar',compact('area'));
    }

    public function delete($id){
        $area = Area::where('id',$id)
            ->first();

        return view('areas.eliminar',compact('area'));
    }

    /**
     * 
    */

    public function insert(Request $request){
        $cuit = $request ->input('cuit');
        $nombre = $request->input('nombre');
        $domicilio = $request->input('domicilio');
        $telefono = $request->input('telefono');

        Area::agregar_area($cuit,$nombre,$domicilio,$telefono);

        return redirect()->route('area.listar');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $cuit = $request ->input('cuit');
        $nombre = $request->input('nombre');
        $domicilio = $request->input('domicilio');
        $telefono = $request->input('telefono');

        Area::modificar_area($id,$cuit,$nombre,$domicilio,$telefono);

        return redirect()->route('area.listar');
    }

    public function drop(Request $request){
        $id = $request->input('id');

        Area::eliminar_area($id);

        return redirect()->route('area.listar');
    }

    public function search(Request $request){
        $buscar = $request->input('search');
        if($buscar !== null){
            $lista = Area::buscar_area($buscar);
            return view('areas.listar',compact('lista'));
        }else{
            return redirect()->route('area.listar');
        }
    }

    public function back(){
        return redirect()->route('area.listar');
    }
}
