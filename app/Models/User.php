<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function listar_usuarios(){
        $query = User::join('rols', 'users.rol_usuario', '=', 'rols.id')
            ->join('areas', 'users.area_usuario', '=', 'areas.id')
            ->select(
                'users.id as ID',
                'name as USUARIO',
                'email as CORREO_ELECTRONICO',
                'estado as ESTADO',
                'rol as ROL',
                'rols.rol_nombre as ROLES',
                'areas.area_nombre as AREA'
            )
            ->where('users.id', '!=', Auth::id());

        // Si el rol del usuario autenticado NO es 1, se aplica el filtro por 'area_usuario'
        if (Auth::user()->rol_usuario != 1) {
            $query->where('users.area_usuario', Auth::user()->area_usuario);
        }

        $result = $query->paginate(5);

        return $result;
    }

    public static function registrar_usuario($name,$email,$password,$estado,$rol,$roles,$area){
        return User::insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'estado' => $estado, 
            'rol' => $rol,
            'rol_usuario' => $roles,
            'area_usuario' => $area
        ]);
    }

    public static function modificar_usuario($id,$name,$email,$password,$estado,$rol){
        // Creamos un arreglo con los campos que siempre serán actualizados
        $data = [
            'name' => $name,
            'email' => $email,
            'estado' => $estado,
            'rol' => $rol,
        ];

        // Solo añadimos 'password' al arreglo si tiene valor (no está vacío o nulo)
        if (!empty($password)) {
            $data['password'] = Hash::make($password);
        }

        // Realizamos la actualización
        return User::where('id', $id)->update($data);
    }

    public static function eliminar_usuario($id){
        return User::where('id',$id)
            ->delete();
    }

    public static function buscar_usuario($param){
        return User::where('name',$param)
            ->orWhere('email',$param)
            ->orWhere('id',$param)
            ->select(
                'users.id as ID',
                'users.name as USUARIO',
                'users.email as CORREO_ELECTRONICO',
                'users.estado as ESTADO',
                'users.rol as ROL',
            )
            ->paginate(5);
    }

    public static function buscar_usuario_detalle($param){

        return User::join('rols', 'users.rol_usuario', '=', 'rols.id')
               ->join('areas', 'users.area_usuario', '=', 'areas.id')
               ->when(is_numeric($param), function ($query) use ($param) {
                   // Si el parámetro es numérico, buscamos por `id`
                   return $query->where('users.id', $param);
               }, function ($query) use ($param) {
                   // Si el parámetro es una cadena, buscamos por `name`
                   return $query->where('users.name', $param);
               })
               ->select(
                   'users.id as ID',
                   'users.name as USUARIO',
                   'users.email as CORREO_ELECTRONICO',
                   'users.estado as ESTADO',
                   'rols.rol_nombre as ROLES',
                   'areas.area_cuit as CUIT',
                   'areas.area_nombre as AREA',
                   'areas.area_domicilio as DOMICILIO',
                   'areas.area_telefono as TELEFONO'
               )
               ->first();
    }
}
