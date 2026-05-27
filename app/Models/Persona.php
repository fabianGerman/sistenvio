<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $filiable = [
        'per_documento',
        'per_nombres',
        'per_instituto',
        'per_direccion',
        'per_telefono',
        'per_usuario'
    ];

    public static function registrar_persona($documento,$nombre,$instituto,$direccion,$telefono,$usuario){
        return Persona::insert([
                'per_documento' => $documento,
                'per_nombres' => $nombre,
                'per_instituto' => $instituto,
                'per_direccion' => $direccion,
                'per_telefono' => $telefono,
                'per_usuario' => $usuario
            ]);
    }

    public static function modificar_persona($documento,$nombre,$instituto,$direccion,$telefono,$usuario){
        return Persona::where('per_usuario',$usuario)
            ->update([
                'per_documento' => $documento,
                'per_nombres' => $nombre,
                'per_instituto' => $instituto,
                'per_direccion' => $direccion,
                'per_telefono' => $telefono,
            ]);
    }

    public static function buscar_persona_detalle($param){
        
        return Persona::where('per_usuario',$param)
        ->select(
            'id as ID',
            'per_documento as DOCUMENTO',
            'per_nombres as APELLIDO_NOMBRE',
            'per_instituto as INSTITUTO',
            'per_direccion as DIRECCION',
            'per_telefono as TELEFONO',
        )
        ->first();
    }
}
