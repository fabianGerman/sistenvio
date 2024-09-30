<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $filiable = [
        'area_nombre',
        'area_cuit',
        'area_domicilio',
        'area_telefono',
    ];

    public static function enumerar_areas(){
        $result = Area::select(
            'id as ID',
            'area_nombre AS NOMBRE'
        )
        ->get();
        return $result;
    }

    public static function listar_areas(){
        $result = Area::select(
                'id as ID',
                'area_cuit as CUIT',
                'area_nombre as NOMBRE',
                'area_domicilio as DOMICILIO',
                'area_telefono as TELEFONO'
            )
            ->paginate(5);
        return $result;
    }

    public static function agregar_area($cuit,$nombre,$domicilio,$telefono){
        return Area::insert([
            'area_nombre' => $cuit,
            'area_cuit' => $nombre,
            'area_domicilio' => $domicilio,
            'area_telefono' => $telefono,
        ]);
    }

    public static function modificar_area($id,$cuit,$nombre,$domicilio,$telefono){
        return Area::where('id',$id)
            ->update([
                'area_cuit' => $cuit,
                'area_nombre' => $nombre,
                'area_domicilio' => $domicilio,
                'area_telefono' => $telefono,
            ]);
    }

    public static function eliminar_area($id){
        return Area::where('id',$id)
            ->delete();
    }

    public static function buscar_area($param){
        return Area::where('area_cuit',$param)
            ->orWhere('area_nombre',$param)
            ->select(
                'id as ID',
                'area_cuit as CUIT',
                'area_nombre as NOMBRE',
                'area_domicilio as DOMICILIO',
                'area_telefono as TELEFONO'
            )
            ->paginate(5);
    }
}
