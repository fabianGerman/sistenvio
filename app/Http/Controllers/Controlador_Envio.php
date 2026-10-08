<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;
use App\Models\ObraSocial;
use App\Models\Prestador;
use App\Models\Afiliado;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class Controlador_Envio extends Controller
{

    public function index()
    {
        $obrassociales = ObraSocial::enumerar_obrassociales();
        return view('envios.envio', [
            'obrassociales' => $obrassociales
        ]);
    }

    public function carpeta(){
        return view('envios.enviocarpeta');
    }

    public function listar()
    {

        $envios = Envio::listar_envios();
        $obrassociales = ObraSocial::enumerar_obrassociales();
        return view('envios.lista', [
            'envios' => $envios,
            'obrassociales' => $obrassociales
        ]);

    }

    public function comprobante(Request $request)
    {
        $id = $request->input('id');

        return $this->generarPDF($id);
    }

    public function registrar(Request $request)
    {
        set_time_limit(30000000); // Aumentar el tiempo de ejecución a 30,000 segundos (aproximadamente 8.3 horas)
        /*
        |--------------------------------------------------------------------------
        | VALIDAR
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'periodo' => 'required',
            'documentacion' => 'required|array|min:1',
            'documentacion.*' => 'required|file|mimes:pdf,zip,rar|max:20480'
        ]);

        $periodo = $request->input('periodo');

        $archivos = $request->file('documentacion');

        /*
        |--------------------------------------------------------------------------
        | PRIMERO VALIDAR TODOS LOS NOMBRES
        |--------------------------------------------------------------------------
        |
        | De esta forma evitamos comenzar a registrar archivos y descubrir
        | después que uno de ellos tiene un nombre incorrecto.
        |
        */

        $archivosProcesar = [];

        foreach ($archivos as $archivo) {

            /*
            |--------------------------------------------------------------------------
            | DESGLOSAR NOMBRE DEL ARCHIVO
            |--------------------------------------------------------------------------
            */

            $auxiliar = $this->desglosarNombreArchivo(
                $archivo->getClientOriginalName()
            );

            if ($auxiliar === null) {

                return back()
                    ->withErrors([
                        'documentacion' =>
                            'El archivo "' .
                            $archivo->getClientOriginalName() .
                            '" no tiene el formato correcto.'
                    ])
                    ->withInput();
            }

            /*
            |--------------------------------------------------------------------------
            | OBTENER RUTA ORIGINAL
            |--------------------------------------------------------------------------
            |
            | Ejemplo:
            |
            | OSECAC/PLAN UNICO/archivo.pdf
            |
            */

            if (method_exists($archivo, 'getClientOriginalPath')) {

                $rutaOriginal = $archivo->getClientOriginalPath();

            } else {

                $rutaOriginal = $archivo->getClientOriginalName();
            }

            // Normalizar separadores
            $rutaOriginal = str_replace('\\', '/', $rutaOriginal);

            $partesRuta = explode('/', $rutaOriginal);

            // Sacamos el nombre del archivo
            array_pop($partesRuta);

            /*
            |--------------------------------------------------------------------------
            | OBTENER PLAN DESDE LA CARPETA
            |--------------------------------------------------------------------------
            |
            | OSECAC/PLAN UNICO/archivo.pdf
            |
            | La carpeta inmediatamente anterior al archivo será:
            |
            | PLAN UNICO
            |
            */

            $planNombre = null;

            if (count($partesRuta) > 0) {
                $planNombre = end($partesRuta);
            }

            $archivosProcesar[] = [
                'archivo' => $archivo,
                'datos' => $auxiliar,
                'plan' => $planNombre
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PROCESAR TODOS LOS ARCHIVOS
        |--------------------------------------------------------------------------
        */

        foreach ($archivosProcesar as $item) {

            $archivo = $item['archivo'];

            $auxiliar = $item['datos'];

            $planNombre = $auxiliar['plan'];

            //dd($planNombre);
            /*
            |--------------------------------------------------------------------------
            | DATOS OBTENIDOS DEL NOMBRE DEL ARCHIVO
            |--------------------------------------------------------------------------
            */

            $obrasocial = $auxiliar['obrasocial'];

            $numeroprestacion = $auxiliar['numeroprestacion'];

            $practica = $auxiliar['practica'];

            $nombre = $auxiliar['nombre'];

            $nroafiliado = $auxiliar['nroafiliado'];

            $matricula = $auxiliar['matricula'];

            //$nombremedico = $auxiliar['nombremedico'];


            /*
            |--------------------------------------------------------------------------
            | BUSCAR OBRA SOCIAL
            |--------------------------------------------------------------------------
            */

            $buscar_obrasocial = ObraSocial::where(
                'os_siglas',
                $obrasocial
            )->first();


            /*
            |--------------------------------------------------------------------------
            | CREAR OBRA SOCIAL SI NO EXISTE
            |--------------------------------------------------------------------------
            */

            if ($buscar_obrasocial == null) {

                $obrasocial_agregar = new ObraSocial();

                $obrasocial_agregar->os_nombre = $obrasocial;

                /*
                | IMPORTANTE:
                | Como buscas por os_siglas, también debemos guardar os_siglas.
                */

                $obrasocial_agregar->os_siglas = $obrasocial;

                $obrasocial_agregar->save();

                $buscar_obrasocial = $obrasocial_agregar;
            }


            /*
            |--------------------------------------------------------------------------
            | BUSCAR PLAN
            |--------------------------------------------------------------------------
            */

            $buscar_plan = null;

            if ($planNombre != null) {

                $buscar_plan = Plan::where(
                        'pl_nombre',
                        $planNombre
                    )
                    ->where(
                        'pl_obrasocial',
                        $buscar_obrasocial->id
                    )
                    ->first();

                //dd($buscar_plan, $planNombre, $buscar_obrasocial);
                /*
                |--------------------------------------------------------------------------
                | CREAR PLAN SI NO EXISTE
                |--------------------------------------------------------------------------
                */

                if ($buscar_plan == null) {

                    $plan_agregar = new Plan();

                    $plan_agregar->pl_nombre = $planNombre;

                    $plan_agregar->pl_obrasocial =
                        $buscar_obrasocial->id;

                    $plan_agregar->save();

                    $buscar_plan = $plan_agregar;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | BUSCAR AFILIADO
            |--------------------------------------------------------------------------
            */

            $buscar_afiliado = Afiliado::where(
                'af_numero',
                $nroafiliado
            )->first();


            /*
            |--------------------------------------------------------------------------
            | CREAR AFILIADO SI NO EXISTE
            |--------------------------------------------------------------------------
            */

            if ($buscar_afiliado == null) {

                $afiliado_agregar = new Afiliado();

                $afiliado_agregar->af_numero =
                    $nroafiliado;

                $afiliado_agregar->af_cuil =
                    "NO COMPLETADO";

                $afiliado_agregar->af_nombres =
                    $nombre;

                $afiliado_agregar->save();

                $buscar_afiliado = $afiliado_agregar;
            }


            /*
            |--------------------------------------------------------------------------
            | BUSCAR PRESTADOR
            |--------------------------------------------------------------------------
            */

            $buscar_prestador = Prestador::where(
                'prest_matricula',
                $matricula
            )->first();


            /*
            |--------------------------------------------------------------------------
            | CREAR PRESTADOR SI NO EXISTE
            |--------------------------------------------------------------------------
            */

            if ($buscar_prestador == null) {

                $prestador_agregar = new Prestador();

                $prestador_agregar->prest_matricula =
                    $matricula;

                /*
                | Si tienes la columna:
                |
                | $prestador_agregar->prest_matricula = $matricula;
                */

                $prestador_agregar->save();

                $buscar_prestador = $prestador_agregar;
            }


            /*
            |--------------------------------------------------------------------------
            | DEFINIR CARPETA DE DESTINO
            |--------------------------------------------------------------------------
            |
            | Si el archivo viene desde:
            |
            | OSECAC/PLAN UNICO/archivo.pdf
            |
            | se guardará en:
            |
            | documentos/OSECAC/PLAN UNICO/
            |
            */

            $carpetaDestino = 'documentos';

            if ($planNombre != null) {

                // Limpiar caracteres peligrosos en nombres de carpetas
                $obraCarpeta = preg_replace(
                    '/[^A-Za-z0-9 _.-]/u',
                    '',
                    $obrasocial
                );

                $planCarpeta = preg_replace(
                    '/[^A-Za-z0-9 _.-]/u',
                    '',
                    $planNombre
                );

                $carpetaDestino .=
                    '/' .
                    $obraCarpeta .
                    '/' .
                    $planCarpeta;
            }


            /*
            |--------------------------------------------------------------------------
            | SUBIR DOCUMENTO
            |--------------------------------------------------------------------------
            */

            $archivo_nombre =
                time() .
                '_' .
                uniqid() .
                '_' .
                $archivo->getClientOriginalName();

            $archivo_path = $archivo->storeAs(
                $carpetaDestino,
                $archivo_nombre,
                'public'
            );


            /*
            |--------------------------------------------------------------------------
            | GUARDAR ENVÍO
            |--------------------------------------------------------------------------
            */

            $envio_agregar = new Envio();

            $envio_agregar->env_afiliado =
                $buscar_afiliado->id;

            $envio_agregar->env_obrasocial =
                $buscar_obrasocial->id;

            /*
            | Si el archivo fue cargado desde una carpeta con plan,
            | guardamos el ID del plan.
            */

            if ($buscar_plan != null) {

                $envio_agregar->env_plan =
                    $buscar_plan->id;
            }

            $envio_agregar->env_prestador =
                $buscar_prestador->id;

            $envio_agregar->env_periodo =
                $periodo;

            $envio_agregar->env_prestacion =
                $numeroprestacion;

            $envio_agregar->env_documento =
                $archivo_path;

            $envio_agregar->env_usuario =
                Auth::id();

            $envio_agregar->save();


            /*
            |--------------------------------------------------------------------------
            | GENERAR PDF / COMPROBANTE
            |--------------------------------------------------------------------------
            */

            $this->generarPDF(
                $envio_agregar->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TERMINAR
        |--------------------------------------------------------------------------
        */

        return $this->listar();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('search');
        $periodo = $request->input('periodo');
        $obraSocial = $request->input('obraSocial');

        $usuario = Auth::user();

        $query = Envio::join(
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
            )
            ->join(
                'users',
                'users.id',
                '=',
                'envios.env_usuario'
            );

        if ($usuario->rol_usuario == 1) {

            // No aplicar filtros.
            // Ve todos los envíos.

        }

        // Supervisor
        elseif ($usuario->rol_usuario == 2) {

            $query->where('users.area_usuario', $usuario->area_usuario)
                ->whereIn('users.rol_usuario', [2, 3]);

        }

        // Empleado
        elseif ($usuario->rol_usuario == 3) {

            $query->where('envios.env_usuario', $usuario->id);

        }
        // Buscar por texto
        if (!empty($buscar)) {
            $query->where(function ($q) use ($buscar) {
                $q->where('afiliados.af_nombres', 'LIKE', "%{$buscar}%")
                ->orWhere('prestadors.prest_matricula', 'LIKE', "%{$buscar}%")
                ->orWhere('obra_socials.os_siglas', 'LIKE', "%{$buscar}%")
                ->orWhere('envios.env_prestacion', 'LIKE', "%{$buscar}%");
            });
        }

        // Filtrar por Obra Social
        if (!empty($obraSocial)) {
            $query->where('envios.env_obrasocial', $obraSocial);
        }

        // Filtrar por Período
        if (!empty($periodo)) {
            $query->where('envios.env_periodo', 'LIKE', "%{$periodo}%");
        }

        $envios = $query->select(
                'envios.created_at as FECHACREACION',
                'envios.id',
                'afiliados.af_nombres as AFILIADO',
                'prestadors.prest_matricula as PRESTADOR',
                'obra_socials.os_siglas as OBRASOCIAL',
                'envios.env_periodo as PERIODO',
                'envios.env_prestacion as PRESTACION',
                'envios.env_documento as DOCUMENTACION',
                'envios.env_comprobante as COMPROBANTE'
            )
            ->paginate(5)
            ->appends($request->all());

        $obrassociales = ObraSocial::enumerar_obrassociales();

        return view('envios.lista', [
            'envios' => $envios,
            'search' => $buscar,
            'periodo' => $periodo,
            'obraSocial' => $obraSocial,
            'obrassociales' => $obrassociales
        ]);
    }

    public function generarPDF($id)
    {

        /*
        |--------------------------------------------------------------------------
        | CREAR CARPETA PDF
        |--------------------------------------------------------------------------
        */

        if (!Storage::exists('public/pdfs')) {

            Storage::makeDirectory('public/pdfs');
        }

        /*
        |--------------------------------------------------------------------------
        | OBTENER MODELO REAL
        |--------------------------------------------------------------------------
        */

        $envioModel = Envio::find($id);

        if (!$envioModel) {

            return response()->json([
                'error' => 'Envio no encontrado'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | OBTENER DATOS PARA PDF
        |--------------------------------------------------------------------------
        */

        $envio = Envio::where('envios.id', $id)
            ->join('afiliados', 'afiliados.id', '=', 'envios.env_afiliado')
            ->join('prestadors', 'prestadors.id', '=', 'envios.env_prestador')
            ->join('obra_socials', 'obra_socials.id', '=', 'envios.env_obrasocial')
            ->join('users', 'users.id', '=', 'envios.env_usuario')
            ->select(
                'envios.created_at as FECHACREACION',
                'envios.id',
                'afiliados.af_nombres as AFILIADO',
                'prestadors.prest_nombre as PRESTADOR',
                'obra_socials.os_nombre as OBRASOCIAL',
                'envios.env_periodo as PERIODO',
                'envios.env_prestacion as PRESTACION',
                'envios.env_documento as DOCUMENTACION',
                'envios.env_comprobante as COMPROBANTE'
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView('envios.archivo', [
            'envio' => $envio
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOMBRE PDF
        |--------------------------------------------------------------------------
        */

        $pdfFileName = 'envio_' . $id . '.pdf';

        /*
        |--------------------------------------------------------------------------
        | GUARDAR PDF
        |--------------------------------------------------------------------------
        */

        $pdf->save(
            storage_path('app/public/pdfs/' . $pdfFileName)
        );


        /*
        |--------------------------------------------------------------------------
        | URL PDF
        |--------------------------------------------------------------------------
        */

        $pdfUrl = asset('storage/pdfs/' . $pdfFileName);


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR BD
        |--------------------------------------------------------------------------
        */

        $envioModel->env_comprobante = $pdfUrl;

        $envioModel->save();

        /*
    |--------------------------------------------------------------------------
    | REDIRECCIONAR
    |--------------------------------------------------------------------------
    */

    return $pdf->stream($pdfFileName);

    //return redirect()
    //    ->route('envio.lista')
    //    ->with('comprobante_url', $pdfUrl);
    }

    public function descargarDocumento(int $id)
    {
        $envio = Envio::find($id);

        if (!$envio) {
            abort(404, 'Envio no encontrado');
        }

        $ruta = storage_path('app/public/' . $envio->env_documento);

        if (!file_exists($ruta)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->download($ruta);

    }


    //-------------------------------------------------
    public function update($id)
    {
        $envio = Envio::where('id', $id)
            ->first();

        $afiliado = Afiliado::where('id', $envio->env_afiliado)
            ->select(
                'af_numero as NUMERO',
            )
            ->first();
        $prestador = Prestador::where('id', $envio->env_prestador)
            ->select(
                'prest_nombre as NOMBRE'
            )
            ->first();
        $obrassociales = ObraSocial::where('id', $envio->env_obrasocial)
            ->select(
                'os_siglas as SIGLAS'
            )
            ->first();
        $usuario = Auth::user();
            return view('envios.modificar', compact('envio', 'afiliado', 'prestador', 'obrassociales', 'usuario'));
    }

    public function delete($id)
    {
        $envio = Envio::where('id', $id)
            ->first();

        return view('envios.eliminar', compact('envio'));
    }

    public function edit(Request $request)
    {
         $id = $request->input('id');
        $periodo = $request->input('periodo');
        $prestacion = $request->input('prestacion');
        $usuario = $request->input('usuario');

        // Buscar afiliado por número
        $afiliado = Afiliado::where('af_numero', $request->input('afiliado'))->first();

        if (!$afiliado) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'afiliado' => 'El afiliado ingresado no existe.'
                ]);
        }

        // Buscar prestador por nombre
        $prestador = Prestador::where('prest_nombre', $request->input('prestador'))->first();

        if (!$prestador) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'prestador' => 'El prestador ingresado no existe.'
                ]);
        }

        // Buscar obra social por sigla
        $obraSocial = ObraSocial::where('os_siglas', $request->input('obrasocial'))->first();

        if (!$obraSocial) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'obrasocial' => 'La obra social ingresada no existe.'
                ]);
        }
        // Buscar usuario por nombre
        $usuario = Auth::user();

        //dd($usuario);
        Envio::modificar_envio(
            $id,
            $periodo,
            $prestador->id,
            $afiliado->id,
            $prestacion,
            $obraSocial->id,
            $usuario->id
        );

        return redirect()->route('envio.lista')->with('success', 'Envío actualizado correctamente.');
    }

    public function drop(Request $request)
    {
        $id = $request->input('id');

        Envio::eliminar_envio($id);

        return redirect()->route('envio.lista');
    }

    public function back(){
        $lista = Envio::listar_envios();
        $obrassociales = ObraSocial::enumerar_obrassociales();

        return redirect()->route('envio.lista')->with([
            'envios' => $lista,
            'obrassociales' => $obrassociales
        ]);
    }

    public function desglosarNombreArchivo($nombreArchivo)
    {
        /*
        |--------------------------------------------------------------------------
        | QUITAR EXTENSIÓN
        |--------------------------------------------------------------------------
        */

        $nombreArchivo = pathinfo(
            $nombreArchivo,
            PATHINFO_FILENAME
        );


        /*
        |--------------------------------------------------------------------------
        | SEPARAR POR GUIONES
        |--------------------------------------------------------------------------
        */

        $partes = explode('-', $nombreArchivo);


        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN BÁSICA
        |--------------------------------------------------------------------------
        */

        if (count($partes) < 13) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | OBRA SOCIAL
        |--------------------------------------------------------------------------
        |
        | Ejemplo:
        | 133(OSECAC)
        |
        */

        if (!preg_match(
            '/^(\d+)\(([^)]+)\)$/',
            trim($partes[0]),
            $resultadoOS
        )) {
            return null;
        }

        $codigoObrasocial = $resultadoOS[1];

        $obrasocial = $resultadoOS[2];


        /*
        |--------------------------------------------------------------------------
        | PLAN
        |--------------------------------------------------------------------------
        |
        | PLAN_UNICO -> PLAN UNICO
        |
        */

        $plan = str_replace(
            '_',
            ' ',
            trim($partes[1])
        );


        /*
        |--------------------------------------------------------------------------
        | PRESTACIÓN
        |--------------------------------------------------------------------------
        */

        $numeroprestacion = trim(
            $partes[2]
        );


        /*
        |--------------------------------------------------------------------------
        | PRÁCTICAS
        |--------------------------------------------------------------------------
        |
        | Puede haber una o varias:
        |
        | 34.02.09
        | 34.02.10
        | 34.09.10
        |
        */

        $indice = 3;

        $practicas = [];

        while (
            isset($partes[$indice]) &&
            preg_match(
                '/^\d+(?:\.\d+){2}$/',
                trim($partes[$indice])
            )
        ) {

            $practicas[] = trim(
                $partes[$indice]
            );

            $indice++;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDAR QUE HAYA AL MENOS UNA PRÁCTICA
        |--------------------------------------------------------------------------
        */

        if (count($practicas) == 0) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | DIAGNÓSTICO
        |--------------------------------------------------------------------------
        */

        if (!isset($partes[$indice])) {
            return null;
        }

        $diagnostico = trim(
            $partes[$indice]
        );

        $indice++;


        /*
        |--------------------------------------------------------------------------
        | NOMBRE DEL AFILIADO
        |--------------------------------------------------------------------------
        */

        if (!isset($partes[$indice])) {
            return null;
        }

        $nombre = str_replace(
            '_',
            ' ',
            trim($partes[$indice])
        );

        $indice++;


        /*
        |--------------------------------------------------------------------------
        | DATOS RESTANTES
        |--------------------------------------------------------------------------
        |
        | nro afiliado parte 1
        | nro afiliado parte 2
        | autorización
        | matrícula
        | día
        | mes
        | año
        |
        */

        if ((count($partes) - $indice) < 7) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | NÚMERO DE AFILIADO
        |--------------------------------------------------------------------------
        */

        $nroafiliado =
            trim($partes[$indice]) .
            '-' .
            trim($partes[$indice + 1]);

        $indice += 2;


        /*
        |--------------------------------------------------------------------------
        | NÚMERO DE AUTORIZACIÓN
        |--------------------------------------------------------------------------
        */

        $numeroautorizacion =
            trim($partes[$indice]);

        $indice++;


        /*
        |--------------------------------------------------------------------------
        | MATRÍCULA PROFESIONAL
        |--------------------------------------------------------------------------
        */

        $matricula =
            trim($partes[$indice]);

        $indice++;


        /*
        |--------------------------------------------------------------------------
        | FECHA DE PRÁCTICA
        |--------------------------------------------------------------------------
        */

        $dia = trim($partes[$indice]);

        $mes = trim($partes[$indice + 1]);

        $anio = trim($partes[$indice + 2]);

        $fechapractica =
            $dia . '-' .
            $mes . '-' .
            $anio;


        /*
        |--------------------------------------------------------------------------
        | RETORNAR DATOS
        |--------------------------------------------------------------------------
        */

        return [

            'codigo_obrasocial' =>
                $codigoObrasocial,

            'obrasocial' =>
                $obrasocial,

            'plan' =>
                $plan,

            'numeroprestacion' =>
                $numeroprestacion,

            'practicas' =>
                $practicas,

            'practica' =>
                implode(' / ', $practicas),

            'diagnostico' =>
                $diagnostico,

            'nombre' =>
                $nombre,

            'nroafiliado' =>
                $nroafiliado,

            'numeroautorizacion' =>
                $numeroautorizacion,

            'matricula' =>
                $matricula,

            'fechapractica' =>
                $fechapractica
        ];
    }
}
