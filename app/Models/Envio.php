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

    public static function listar_envios()
    {
        /*
        |--------------------------------------------------------------------------
        | USUARIO ACTUAL
        |--------------------------------------------------------------------------
        */

        $usuario = User::where('id', Auth::id())->first();

        /*
        |--------------------------------------------------------------------------
        | CONSULTA BASE
        |--------------------------------------------------------------------------
        */

        $lista = Envio::join(
                'afiliados',
                'afiliados.id',
                '=',
                'envios.env_afiliado'
            )
            ->join(
                'prestadors',
                'prestadors.id',
                '=',
                'envios.env_prestador'
            )
            ->join(
                'obra_socials',
                'obra_socials.id',
                '=',
                'envios.env_obrasocial'
            )/*
            ->join(
                'plans',
                'plans.id',
                '=',
                'envios.env_plan'
            )*/
            ->join(
                'users',
                'users.id',
                '=',
                'envios.env_usuario'
            )
            ->select(
                'envios.created_at as FECHACREACION',
                'envios.id',

                'afiliados.af_numero as AFILIADO',
                'afiliados.af_nombres as AFILIADONOMBRE',

                'prestadors.prest_nombre as PRESTADOR',

                'obra_socials.os_siglas as OBRASOCIAL',

                //'plans.plan_nombre as PLAN',

                'envios.env_periodo as PERIODO',
                'envios.env_prestacion as PRESTACION',
                'envios.env_documento as DOCUMENTACION',
                'envios.env_comprobante as COMPROBANTE'
            );


        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        |
        | rol_usuario = 1
        | Puede ver todos los envíos
        |
        */

        if ($usuario->rol_usuario == 1) {

            return $lista
                ->orderBy('envios.created_at', 'desc')
                ->paginate(5);
        }


        /*
        |--------------------------------------------------------------------------
        | SUPERVISOR / RESPONSABLE
        |--------------------------------------------------------------------------
        |
        | rol_usuario = 2
        | Puede ver los envíos de su área
        |
        */

        if ($usuario->rol_usuario == 2) {

            return $lista
                ->where(
                    'users.area_usuario',
                    $usuario->area_usuario
                )
                ->orderBy('envios.created_at', 'desc')
                ->paginate(5);
        }


        /*
        |--------------------------------------------------------------------------
        | USUARIO / EMPLEADO
        |--------------------------------------------------------------------------
        |
        | Solo puede ver sus propios envíos
        |
        */

        return $lista
            ->where(
                'users.id',
                $usuario->id
            )
            ->orderBy('envios.created_at', 'desc')
            ->paginate(5);
    }

    public static function agregar_envio(){

    }

    public static function modificar_envio($id, $periodo, $prestador, $afiliado, $prestacion, $obrasocial, $usuario){
        return Envio::where('id',$id)
            ->update([
                'env_prestador' => $prestador,
                'env_obrasocial' => $obrasocial,
                'env_afiliado' => $afiliado,
                'env_usuario' => $usuario,
                'env_periodo' => $periodo,
                'env_prestacion' => $prestacion
            ]);
    }

    public static function eliminar_envio($id){
        return Envio::where('id',$id)
            ->delete();
    }
}
