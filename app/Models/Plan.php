<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pl_nombre',
        'pl_obrasocial'
    ];

    public static function listar_planes(){
        $result = Plan::join('obra_socials','plans.pl_obrasocial','=','obra_socials.id')
            ->select(
                'plans.id as ID',
                'plans.pl_nombre as NOMBRE',
                'obra_socials.os_nombre as OBRA_SOCIAL'
            )
            ->paginate(5);
        return $result;
    }

    public static function agregar_plan($nombre,$obra_social){
        return Plan::insert([
            'pl_nombre' => $nombre,
            'pl_obrasocial' => $obra_social
        ]);
    }

    public static function modificar_plan($id,$nombre,$obra_social){
        return Plan::where('id',$id)
            ->update([
                'pl_nombre' => $nombre,
                'pl_obrasocial' => $obra_social
            ]);
    }

    public static function eliminar_plan($id){
        return Plan::where('id',$id)
            ->delete();
    }

    public static function buscar_plan($param){
        return Plan::join('obra_socials','plans.pl_obrasocial','=','obra_socials.id')
            ->where('id',$param)
            ->orwhere('pl_nombre',$param)
            ->orWhere('pl_obrasocial',$param)
            ->select(
                'plans.id as ID',
                'plans.pl_nombre as NOMBRE',
                'obra_socials.os_nombre as OBRA_SOCIAL'
            )
            ->paginate(5);
    }
}
