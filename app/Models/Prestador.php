<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
    use HasFactory;

    protected $filiable = [
        'prest_matricula',
        'prest_nombre',
        'prest_telefono',
        'prest_email'
    ];

    public static function listar_prestadores(){
        $result = Prestador::select(
                'id as ID',
                'prest_matricula as MATRICULA',
                'prest_nombre as NOMBRE',
                'prest_telefono as TELEFONO',
                'prest_email as CORREO'
            )
            ->paginate(5);
        return $result;
    }

    public static function agregar_prestador($matricula,$nombre,$telefono,$email){
        return Prestador::insert([
            'prest_matricula' => $matricula,
            'prest_nombre' => $nombre,
            'prest_telefono' => $telefono,
            'prest_email' => $email
        ]);
    }

    public static function modificar_prestador($id,$matricula,$nombre,$telefono,$email){
        return Prestador::where('id',$id)
            ->update([
                'prest_matricula' => $matricula,
                'prest_nombre' => $nombre,
                'prest_telefono' => $telefono,
                'prest_email' => $email
            ]);
    }

    public static function eliminar_prestador($id){
        return Prestador::where('id',$id)
            ->delete();
    }

    public static function buscar_prestador($param){
        return Prestador::where('prest_matricula',$param)
            ->orWhere('prest_nombre',$param)
            ->select(
                    'id as ID',
                    'prest_matricula as MATRICULA',
                    'prest_nombre as NOMBRE',
                    'prest_telefono as TELEFONO',
                    'prest_email as CORREO'
                )
            ->paginate(5);    
    }
}
