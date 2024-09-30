<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Controlador_Usuario extends Controller
{

    public function salir(Request $request){
        //cerrar la session
        //Auth::logout();
        //invalidar la seesion actual
        $request->session()->invalidate();
        //regenerar el token CSRF para la nueva session
        $request->session()->regenerateToken();
        //redirigi al login
        return redirect('/login')->with('status','Session finalizada correctamente');
    }

    public function back(){
        $lista = User::listar_usuarios();
        return redirect()->route('usuario.listar');
    }

    public function list(){
        $lista = User::listar_usuarios();

        return view('usuarios.listar',compact('lista'));
    }

    public function register(){
        $roles = Rol::enumerar_roles();
        $areas = Area::enumerar_areas();
        return view('usuarios.registrar',compact('roles','areas'));
    }

    public function update($id){
        $usuario = User::where('id',$id)
            ->first();
        $persona = Persona::where('per_usuario',$usuario->id)
            ->first();    
        $roles = Rol::enumerar_roles();
        
        $areas = Area::enumerar_areas();
        return view('usuarios.modificar',compact('usuario','persona','roles','areas'));
    }

    public function delete($id){
        $usuario = User::where('id',$id)
            ->first();

        return view('usuarios.eliminar',compact('usuario'));
    }

    public function mostrar($id){
        $usuario = User::buscar_usuario_detalle(intval($id));
        $persona = Persona::buscar_persona_detalle($id);
        
        return view('usuarios.detalle',compact('usuario','persona'));
    }

    /**
     * 
     */
    
    public function insert(Request $request){
    
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $estado = $request->input('estado');
        $rol = null;

        $roles = intval($request->input('roles'));
        $areas = intval($request->input('areas'));

        //dd($name,$email,$password,$estado,$rol,$roles,$areas);
        User::registrar_usuario($name,$email,$password,$estado,$rol,$roles,$areas);
    
        $documento = $request->input('documento');
        $nombre = $request->input('nombre');
        $instituto = $request->input('instituto');
        $direccion = $request->input('direccion');
        $telefono = $request->input('telefono');
        $usuario = User::buscar_usuario_detalle($name);
       
        Persona::registrar_persona($documento,$nombre,$instituto,$direccion,$telefono,$usuario->ID);
        
        return redirect()->route('usuario.listar');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $estado = $request->input('estado');
        $rol = $request->input('rol');

        User::modificar_usuario($id,$name,$email,$password,$estado,$rol);
        
        $documento = $request->input('documento');
        $nombre = $request->input('nombre');
        $instituto = $request->input('instituto');
        $direccion = $request->input('direccion');
        $telefono = $request->input('telefono');
        $usuario = User::buscar_usuario_detalle($name);

        Persona::modificar_persona($documento,$nombre,$instituto,$direccion,$telefono,$usuario->ID);
        
        return redirect()->route('usuario.listar');
    }

    public function drop(Request $request){
        $id = $request->input('id');

        User::eliminar_usuario($id);
        
        return redirect()->route('usuario.listar');
    }

    public function search(Request $request){
        $buscar = $request->input('search');
        if($buscar !== null){
            $lista = User::buscar_usuario($buscar);
            return view('usuarios.listar',compact('lista'));
        }else{
            return redirect()->route('usuario.listar');
        }
    }
}
