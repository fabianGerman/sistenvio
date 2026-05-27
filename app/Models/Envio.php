<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $filiable = [
        'env_prestador',
        'env_obrasocial',
        'env_afiliado',
        'env_usuario',
        'env_periodo',
        'env_prestacion'
    ];

    public static function listar_envios(){
        $usuario = User::where('id',Auth::id())
            ->first();

        if($usuario->rol_usuario == 1){
            $lista =  Envio::join('afiliados','afiliados.id','=','envios.env_afiliado')
                ->join('prestadors','prestadors.id','=','envios.env_prestador')
                ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                ->join('users','users.id','=','envios.env_usuario')
                ->select(
                    'envios.created_at as FECHACREACION',
                    'envios.id',
                    'afiliados.af_nombres as AFILIADO',
                    'prestadors.prest_nombre as PRESTADOR',
                    'obra_socials.os_nombre as OBRASOCIAL',
                    'envios.env_periodo as PERIODO',
                    'envios.env_prestacion as PRESTACION',
                    'envios.env_documento as DOCUMENTACION'
                )
                ->paginate(5);
        }else{
            if($usuario->rol_usuario == 2){
                $lista =  Envio::where('users.area_usuario',$usuario->area_usuario)
                    ->join('afiliados','afiliados.id','=','envios.env_afiliado')
                    ->join('prestadors','prestadors.id','=','envios.env_prestador')
                    ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                    ->join('users','users.id','=','envios.env_usuario')
                    ->select(
                        'envios.created_at as FECHACREACION',
                        'envios.id',
                        'afiliados.af_nombres as AFILIADO',
                        'prestadors.prest_nombre as PRESTADOR',
                        'obra_socials.os_nombre as OBRASOCIAL',
                        'envios.env_periodo as PERIODO',
                        'envios.env_prestacion as PRESTACION',
                        'envios.env_documento as DOCUMENTACION'
                    )
                    ->paginate(5);
            }else{
                $lista =  Envio::where('users.id',$usuario->id)
                    ->join('afiliados','afiliados.id','=','envios.env_afiliado')
                    ->join('prestadors','prestadors.id','=','envios.env_prestador')
                    ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                    ->join('users','users.id','=','envios.env_usuario')
                    ->select(
                        'envios.created_at as FECHACREACION',
                        'envios.id',
                        'afiliados.af_nombres as AFILIADO',
                        'prestadors.prest_nombre as PRESTADOR',
                        'obra_socials.os_nombre as OBRASOCIAL',
                        'envios.env_periodo as PERIODO',
                        'envios.env_prestacion as PRESTACION',
                        'envios.env_documento as DOCUMENTACION'
                    )
                    ->paginate(5);
            }
        }
        return $lista;
    }

    public static function agregar_envio(){

    }

    public static function modificar_envio(){

    }

    public static function eliminar_envio(){

    }
}
