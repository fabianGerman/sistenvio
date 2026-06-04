<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;
use App\Models\ObraSocial;
use App\Models\Prestador;
use App\Models\Afiliado;
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

    public function listar()
    {

        $usuario = Auth::id();

        $envios = Envio::listar_envios();
        return view('envios.lista', [
            'envios' => $envios
        ]);

    }

    public function comprobante(Request $request)
    {
        $id = $request->input('id');

        return $this->generarPDF($id);
    }

    public function registrar(Request $request)
    {

        $request->validate([

            'periodo' => 'required',
            'prestador' => 'required',
            'afiliado' => 'required',
            'prestacion' => 'required',
            'documentacion' => 'required|file|mimes:pdf,zip,rar|max:20480'
        ]);


        $obrassociales = intval($request->input('obrassociales'));
        $obrasocial = $request->input('obrasocial');
        $periodo = $request->input('periodo');
        $prestador = $request->input('prestador');
        $afiliado = $request->input('afiliado');
        $prestacion = $request->input('prestacion');

        /*
        |--------------------------------------------------------------------------
        | SUBIR DOCUMENTO
        |--------------------------------------------------------------------------
        */

        $archivo = $request->file('documentacion');

        $archivo_nombre = time() . '_' . $archivo->getClientOriginalName();

        $archivo_path = $archivo->storeAs(
            'documentos',
            $archivo_nombre,
            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | CREAR AFILIADO SI NO EXISTE
        |--------------------------------------------------------------------------
        */

        $buscar_afiliado = Afiliado::where(
            'af_numero',
            $afiliado
        )->first();

        if ($buscar_afiliado == null) {

            $afiliado_agregar = new Afiliado();
            $afiliado_agregar->af_numero = $afiliado;
            $afiliado_agregar->af_cuil = "NO COMPLETADO";
            $afiliado_agregar->af_nombres = "NO COMPLETADO";
            $afiliado_agregar->save();

            $buscar_afiliado = $afiliado_agregar;
        }

        /*
        |--------------------------------------------------------------------------
        | CREAR PRESTADOR SI NO EXISTE
        |--------------------------------------------------------------------------
        */

        $buscar_prestador = Prestador::where(
            'prest_nombre',
            $prestador
        )->first();

        if ($buscar_prestador == null) {

            $prestador_agregar = new Prestador();
            $prestador_agregar->prest_nombre = $prestador;
            $prestador_agregar->save();

            $buscar_prestador = $prestador_agregar;
        }

        /*
        |--------------------------------------------------------------------------
        | CREAR OBRA SOCIAL SI NO EXISTE
        |--------------------------------------------------------------------------
        */

        $buscar_obrasocial = ObraSocial::buscar_obrasocial($obrassociales)->first();

        if ($buscar_obrasocial == null) {

            $obrasocial_agregar = new ObraSocial();
            $obrasocial_agregar->os_nombre = $obrassociales == 0 ? $obrasocial : ObraSocial::where('id', $obrassociales)->first()->SIGLAS;
            $obrasocial_agregar->save();

            $buscar_obrasocial = $obrasocial_agregar;
        }

        /*
        |--------------------------------------------------------------------------
        | GUARDAR ENVIO
        |--------------------------------------------------------------------------
        */

        $envio_agregar = new Envio();

        $envio_agregar->env_afiliado = $buscar_afiliado->id;
        $envio_agregar->env_obrasocial = $buscar_obrasocial->ID;
        $envio_agregar->env_prestador = $buscar_prestador->id;
        $envio_agregar->env_periodo = $periodo;
        $envio_agregar->env_prestacion = $prestacion;

        // DOCUMENTO SUBIDO
        $envio_agregar->env_documento = $archivo_path;
        //$envio_agregar->env_comprobante = null;

        $envio_agregar->env_usuario = Auth::id();

        $envio_agregar->save();

        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        */

        return $this->generarPDF($envio_agregar->id);
    }

    public function buscar(Request $request)
    {

        $buscar = $request->input('search');

        $usuario = Auth::id();

        if ($buscar != null) {

            $envios = Envio::join(
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
                )
                ->where('envios.env_usuario', $usuario)
                ->where(function ($query) use ($buscar) {

                    $query->where('afiliados.af_nombres', 'LIKE', "%$buscar%")
                        ->orWhere('obra_socials.os_nombre', 'LIKE', "%$buscar%")
                        ->orWhere('prestadors.prest_nombre', 'LIKE', "%$buscar%")
                        ->orWhere('envios.env_periodo', 'LIKE', "%$buscar%");
                })
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
                ->paginate(5)
                ->appends([
                    'search' => $buscar
                ]);

            return view('envios.lista', [
                'envios' => $envios,
                'search' => $buscar
            ]);
        } else {

            return $this->listar();
        }
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
}
