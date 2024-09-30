<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Afiliado extends Model
{
    use HasFactory;

    protected $filiable = [
        'af_numero',
        'af_cuil',
        'af_nombres'
    ];

    public static function listar_afiliado(){
        $query = Afiliado::select(
                'afiliados.id as ID',
                'afiliados.af_numero as NUMERO',
                'afiliados.af_cuil as CUIL',
                'afiliados.af_nombres as NOMBRE'
            );
            
        // Si el rol del usuario autenticado NO es 1, aplica la condición del where
        if (Auth::user()->rol_usuario != 1) {
            $query->where('afiliados.af_usuario', Auth::id());
        }
        $result = $query->paginate(5);

        return $result;
    }   
    
    public static function agregar_afiliado($numero,$cuil,$nombre){
        return Afiliado::insert([
            'af_numero' => $numero,
            'af_cuil' => $cuil,
            'af_nombres' => $nombre,
            'af_usuario' => Auth::id()
        ]);
    }

    public static function modificar_afiliado($id,$numero,$cuil,$nombre){
        return Afiliado::where('id',$id)
            ->update([
                'af_numero' => $numero,
                'af_cuil' => $cuil,
                'af_nombres' => $nombre
            ]);
    }

    public static function eliminar_afiliado($id){
        return Afiliado::where('id',$id)
            ->delete();
    }

    public static function buscar_afiliado($param){
        return Afiliado::where('af_numero',$param)
            ->orWhere('af_cuil',$param)
            ->orWhere('af_nombres',$param)
            ->select(
                'id as ID',
                'af_numero as NUMERO',
                'af_cuil as CUIL',
                'af_nombres as NOMBRE'
            )
            ->paginate(5);
    }
}
