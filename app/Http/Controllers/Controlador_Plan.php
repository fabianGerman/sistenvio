<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\ObraSocial;

class Controlador_Plan extends Controller
{
    public function list(){
        $lista = Plan::listar_planes();

        return view('plan.listar',compact('lista'));
    }

    public function register(){
        $obrasociales = ObraSocial::enumerar_obrassociales();

        return view('plan.registrar',['obrasociales' => $obrasociales]);
    }

    public function update($id){
        $plan = Plan::where('id',$id)
            ->first();

        return view('plan.modificar',compact('plan'));
    }

    public function delete($id){
        $plan = Plan::where('id',$id)
            ->first();

        return view('plan.eliminar',compact('plan'));
    }

    /**
     * Insert a new plan
     */

    public function insert(Request $request){
        $nombre = $request->input('nombre');
        $obra_social = $request->input('obra_social');

        Plan::agregar_plan($nombre,$obra_social);

        return redirect()->route('plan.listar');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $nombre = $request->input('nombre');
        $obra_social = $request->input('obra_social');

        Plan::modificar_plan($id,$nombre,$obra_social);

        return redirect()->route('plan.listar');
    }

    public function drop(Request $request){
        $id = $request->input('id');

        Plan::eliminar_plan($id);

        return redirect()->route('plan.listar');
    }

    public function search(Request $request){
        $param = $request->input('param');

        $lista = Plan::buscar_plan($param);

        if($param == null){
            return redirect()->route('plan.listar');
        }else{
            return view('plan.listar',compact('lista'));
        }
    }

    public function back(){
        return redirect()->route('plan.listar');
    }
}
