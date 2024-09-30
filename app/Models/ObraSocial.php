<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    use HasFactory;

    protected $filiable = [
        'os_nombre',
        'os_siglas',
        'os_numero'
    ];

    public static function listar_obrassociales(){
        $result = ObraSocial::select(
                'id as ID',
                'os_nombre as NOMBRE',
                'os_siglas as SIGLAS',
                'os_numero as NUMERO'
            )
            ->paginate(5);
        return $result;
    }

    public static function agregar_obrasocial($numero,$nombre,$siglas){
        return ObraSocial::insert([
            'os_nombre' => $nombre,
            'os_siglas' => $siglas,
            'os_numero' => $numero
        ]);
    }

    public static function modificar_obrasocial($id,$numero,$nombre,$siglas){
        return ObraSocial::where('id',$id)
            ->update([
                'os_nombre' => $nombre,
                'os_siglas' => $siglas,
                'os_numero' => $numero
            ]);
    }

    public static function eliminar_obrasocial($id){
        return ObraSocial::where('id',$id)
            ->delete();
    }

    public static function buscar_obrasocial($param){
        return ObraSocial::where('os_nombre',$param)
            ->orWhere('os_siglas',$param)
            ->orWhere('os_numero',$param)
            ->select(
                'id as ID',
                'os_nombre as NOMBRE',
                'os_siglas as SIGLAS',
                'os_numero as NUMERO'
            )
            ->paginate(5);
    }
}
