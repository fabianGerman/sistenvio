<x-app-layout>

    <x-slot name="header">
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <x-jet-authentication-card>

                    <x-slot name="logo">

                        <br><br/>
                        <br><br/>

                        <x-jet-authentication-card-logo />

                    </x-slot>


                    <x-jet-validation-errors class="mb-4" />

                    <h1 class="text-center">
                        FORMULARIO DE CARGA
                    </h1>


                    <form
                        id="formCarga"
                        method="POST"
                        action="{{ route('envio.registrar') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        {{-- CARPETA --}}

                        <div class="mt-4">

                            <x-jet-label
                                for="documentacion"
                                value="{{ __('SELECCIONAR CARPETA') }}"
                            />

                            <x-jet-input
                                id="documentacion"
                                class="block mt-1 w-full"
                                type="file"
                                webkitdirectory
                                directory
                                multiple
                                name="documentacion[]"
                                accept=".pdf,.zip,.rar"
                                required
                            />

                        </div>


                        {{-- PERIODO --}}

                        <div class="mt-4">

                            <x-jet-label
                                for="periodo"
                                value="{{ __('PERIODO') }}"
                            />

                            <x-jet-input
                                id="periodo"
                                class="block mt-1 w-full"
                                type="text"
                                name="periodo"
                                :value="old('periodo')"
                                required
                                placeholder="mm/yyyy"
                            />

                        </div>


                        {{-- INFORMACIÓN DE LA CARGA --}}

                        <div
                            id="informacionCarga"
                            class="mt-4"
                            style="display:none;"
                        >

                            <p id="cantidadArchivos"></p>

                            <p id="estadoCarga"></p>

                            <div
                                style="
                                    width:100%;
                                    background:#e5e7eb;
                                    height:20px;
                                    border-radius:5px;
                                    overflow:hidden;
                                    margin-top:10px;
                                "
                            >

                                <div
                                    id="barraProgreso"
                                    style="
                                        width:0%;
                                        height:100%;
                                        background:#2563eb;
                                        transition:width .3s;
                                    "
                                >
                                </div>

                            </div>

                            <p
                                id="porcentaje"
                                style="margin-top:5px;"
                            >
                                0%
                            </p>

                        </div>


                        {{-- BOTÓN --}}

                        <div class="flex items-center justify-end mt-4">

                            <x-jet-button
                                id="btnEnviar"
                                type="submit"
                                class="ml-4"
                            >
                                {{ __('ENVIAR') }}
                            </x-jet-button>

                        </div>


                    </form>

                </x-jet-authentication-card>

            </div>

        </div>

    </div>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const formulario =
                document.getElementById('formCarga');

            const inputArchivos =
                document.getElementById('documentacion');

            const periodo =
                document.getElementById('periodo');

            const btnEnviar =
                document.getElementById('btnEnviar');

            const informacionCarga =
                document.getElementById('informacionCarga');

            const cantidadArchivos =
                document.getElementById('cantidadArchivos');

            const estadoCarga =
                document.getElementById('estadoCarga');

            const barraProgreso =
                document.getElementById('barraProgreso');

            const porcentaje =
                document.getElementById('porcentaje');


            /*
            |--------------------------------------------------------------------------
            | TAMAÑO MÁXIMO DE CADA LOTE
            |--------------------------------------------------------------------------
            |
            | 15 MB por petición.
            |
            | Esto ayuda a evitar el timeout del hosting.
            |
            */

            const TAMANIO_MAXIMO_LOTE =
                15 * 1024 * 1024;


            /*
            |--------------------------------------------------------------------------
            | MOSTRAR CANTIDAD DE ARCHIVOS
            |--------------------------------------------------------------------------
            */

            inputArchivos.addEventListener(
                'change',
                function () {

                    const archivos =
                        Array.from(this.files);

                    informacionCarga.style.display =
                        'block';

                    cantidadArchivos.innerText =
                        'Archivos seleccionados: ' +
                        archivos.length;

                    estadoCarga.innerText =
                        'Listo para comenzar la carga.';

                    barraProgreso.style.width =
                        '0%';

                    porcentaje.innerText =
                        '0%';
                }
            );


            /*
            |--------------------------------------------------------------------------
            | CREAR LOTES
            |--------------------------------------------------------------------------
            */

            function crearLotes(archivos) {

                const lotes = [];

                let loteActual = [];

                let tamanioActual = 0;


                archivos.forEach(function (archivo) {

                    /*
                    | Si agregar este archivo supera los
                    | 15 MB, cerramos el lote actual.
                    */

                    if (
                        loteActual.length > 0 &&
                        tamanioActual + archivo.size >
                        TAMANIO_MAXIMO_LOTE
                    ) {

                        lotes.push(loteActual);

                        loteActual = [];

                        tamanioActual = 0;
                    }


                    loteActual.push(archivo);

                    tamanioActual += archivo.size;
                });


                /*
                | Agregar el último lote
                */

                if (loteActual.length > 0) {

                    lotes.push(loteActual);
                }


                return lotes;
            }


            /*
            |--------------------------------------------------------------------------
            | SUBMIT
            |--------------------------------------------------------------------------
            */

            formulario.addEventListener(
                'submit',
                async function (event) {

                    /*
                    | Evitamos que el formulario mande
                    | todos los archivos juntos.
                    */

                    event.preventDefault();


                    const archivos =
                        Array.from(inputArchivos.files);


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDACIONES
                    |--------------------------------------------------------------------------
                    */

                    if (archivos.length === 0) {

                        alert(
                            'Debe seleccionar una carpeta.'
                        );

                        return;
                    }


                    if (periodo.value.trim() === '') {

                        alert(
                            'Debe ingresar el periodo.'
                        );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CREAR LOTES
                    |--------------------------------------------------------------------------
                    */

                    const lotes =
                        crearLotes(archivos);


                    console.log(
                        'Cantidad de archivos:',
                        archivos.length
                    );

                    console.log(
                        'Cantidad de lotes:',
                        lotes.length
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | BLOQUEAR BOTÓN
                    |--------------------------------------------------------------------------
                    */

                    btnEnviar.disabled = true;

                    informacionCarga.style.display =
                        'block';


                    let archivosProcesados = 0;


                    try {

                        /*
                        |--------------------------------------------------------------------------
                        | RECORRER LOS LOTES
                        |--------------------------------------------------------------------------
                        */

                        for (
                            let numeroLote = 0;
                            numeroLote < lotes.length;
                            numeroLote++
                        ) {

                            const lote =
                                lotes[numeroLote];


                            const formData =
                                new FormData();


                            /*
                            |--------------------------------------------------------------------------
                            | TOKEN CSRF
                            |--------------------------------------------------------------------------
                            */

                            formData.append(
                                '_token',
                                '{{ csrf_token() }}'
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | PERIODO
                            |--------------------------------------------------------------------------
                            */

                            formData.append(
                                'periodo',
                                periodo.value
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | ARCHIVOS
                            |--------------------------------------------------------------------------
                            */

                            lote.forEach(
                                function (archivo) {

                                    formData.append(
                                        'documentacion[]',
                                        archivo,
                                        archivo.name
                                    );

                                }
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | INFORMAR LOTE
                            |--------------------------------------------------------------------------
                            */

                            estadoCarga.innerText =
                                'Enviando lote ' +
                                (numeroLote + 1) +
                                ' de ' +
                                lotes.length +
                                '...';


                            /*
                            |--------------------------------------------------------------------------
                            | ENVIAR A LARAVEL
                            |--------------------------------------------------------------------------
                            */

                            const respuesta =
                                await fetch(
                                    formulario.action,
                                    {
                                        method: 'POST',

                                        headers: {

                                            'Accept':
                                                'application/json',

                                            'X-Requested-With':
                                                'XMLHttpRequest'
                                        },

                                        body: formData
                                    }
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | ERROR DEL SERVIDOR
                            |--------------------------------------------------------------------------
                            */

                            if (!respuesta.ok) {

                                let mensaje =
                                    'Error al procesar el lote.';


                                try {

                                    const error =
                                        await respuesta.json();


                                    if (error.message) {

                                        mensaje =
                                            error.message;
                                    }


                                    if (error.errors) {

                                        const errores =
                                            Object.values(
                                                error.errors
                                            ).flat();

                                        mensaje =
                                            errores.join('\n');
                                    }

                                } catch (e) {

                                    mensaje =
                                        await respuesta.text();

                                }


                                throw new Error(
                                    mensaje
                                );
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | ACTUALIZAR PROGRESO
                            |--------------------------------------------------------------------------
                            */

                            archivosProcesados +=
                                lote.length;


                            const progreso =
                                Math.round(
                                    (
                                        archivosProcesados /
                                        archivos.length
                                    ) * 100
                                );


                            barraProgreso.style.width =
                                progreso + '%';


                            porcentaje.innerText =
                                progreso + '%';


                            estadoCarga.innerText =
                                'Procesados ' +
                                archivosProcesados +
                                ' de ' +
                                archivos.length +
                                ' archivos.';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | FINALIZÓ CORRECTAMENTE
                        |--------------------------------------------------------------------------
                        */

                        barraProgreso.style.width =
                            '100%';

                        porcentaje.innerText =
                            '100%';


                        estadoCarga.innerText =
                            'Todos los archivos fueron procesados correctamente.';


                        alert(
                            'La carpeta se cargó correctamente.'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | REDIRECCIONAR AL LISTADO
                        |--------------------------------------------------------------------------
                        |
                        | Puedes cambiar esta URL si tu ruta
                        | de listado tiene otro nombre.
                        |
                        */

                        setTimeout(
                            function () {

                                window.location.reload();

                            },
                            1000
                        );


                    } catch (error) {

                        console.error(error);


                        estadoCarga.innerText =
                            'Error durante la carga.';


                        alert(
                            'Ocurrió un error:\n\n' +
                            error.message
                        );

                    } finally {

                        /*
                        |--------------------------------------------------------------------------
                        | HABILITAR BOTÓN
                        |--------------------------------------------------------------------------
                        */

                        btnEnviar.disabled = false;

                    }

                }
            );

        });

    </script>


</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const formulario = document.getElementById('formCarga');
    const inputArchivos = document.getElementById('documentacion');
    const periodo = document.getElementById('periodo');
    const btnEnviar = document.getElementById('btnEnviar');

    const informacionCarga =
        document.getElementById('informacionCarga');

    const cantidadArchivos =
        document.getElementById('cantidadArchivos');

    const estadoCarga =
        document.getElementById('estadoCarga');

    const barraProgreso =
        document.getElementById('barraProgreso');

    const porcentaje =
        document.getElementById('porcentaje');


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR ARCHIVOS SELECCIONADOS
    |--------------------------------------------------------------------------
    */

    inputArchivos.addEventListener('change', function () {

        const archivos = Array.from(this.files);

        informacionCarga.style.display = 'block';

        cantidadArchivos.innerText =
            'Archivos seleccionados: ' + archivos.length;

        estadoCarga.innerText =
            'Listo para comenzar.';

        barraProgreso.style.width = '0%';

        porcentaje.innerText = '0%';
    });


    /*
    |--------------------------------------------------------------------------
    | ENVIAR
    |--------------------------------------------------------------------------
    */

    formulario.addEventListener('submit', async function (event) {

        event.preventDefault();


        const archivos =
            Array.from(inputArchivos.files);


        if (archivos.length === 0) {

            alert('Debe seleccionar una carpeta.');

            return;
        }


        if (periodo.value.trim() === '') {

            alert('Debe ingresar el periodo.');

            return;
        }


        btnEnviar.disabled = true;

        informacionCarga.style.display = 'block';


        try {

            /*
            |--------------------------------------------------------------------------
            | UN ARCHIVO = UN POST
            |--------------------------------------------------------------------------
            */

            for (
                let i = 0;
                i < archivos.length;
                i++
            ) {

                const archivo = archivos[i];


                estadoCarga.innerText =
                    'Subiendo archivo ' +
                    (i + 1) +
                    ' de ' +
                    archivos.length +
                    ': ' +
                    archivo.name;


                /*
                |--------------------------------------------------------------------------
                | CREAR FORMDATA
                |--------------------------------------------------------------------------
                */

                const formData = new FormData();


                formData.append(
                    '_token',
                    '{{ csrf_token() }}'
                );


                formData.append(
                    'periodo',
                    periodo.value
                );


                /*
                | Aunque solamente enviamos uno,
                | mantenemos documentacion[] porque
                | Laravel espera un array.
                */

                formData.append(
                    'documentacion[]',
                    archivo,
                    archivo.name
                );


                /*
                |--------------------------------------------------------------------------
                | ENVIAR A LARAVEL
                |--------------------------------------------------------------------------
                */

                const respuesta = await fetch(
                    formulario.action,
                    {
                        method: 'POST',

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        body: formData
                    }
                );


                /*
                |--------------------------------------------------------------------------
                | VERIFICAR RESPUESTA
                |--------------------------------------------------------------------------
                */

                if (!respuesta.ok) {

                    let mensaje =
                        'Error al subir ' + archivo.name;


                    try {

                        const error =
                            await respuesta.json();


                        if (error.message) {

                            mensaje =
                                error.message;
                        }


                        if (error.errors) {

                            mensaje =
                                Object.values(
                                    error.errors
                                )
                                .flat()
                                .join('\n');
                        }

                    } catch (e) {

                        const texto =
                            await respuesta.text();

                        if (texto) {
                            mensaje = texto;
                        }

                    }


                    throw new Error(
                        mensaje
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | ACTUALIZAR PROGRESO
                |--------------------------------------------------------------------------
                */

                const progreso =
                    Math.round(
                        ((i + 1) / archivos.length)
                        * 100
                    );


                barraProgreso.style.width =
                    progreso + '%';


                porcentaje.innerText =
                    progreso + '%';


                estadoCarga.innerText =
                    'Procesados ' +
                    (i + 1) +
                    ' de ' +
                    archivos.length +
                    ' archivos.';

            }


            /*
            |--------------------------------------------------------------------------
            | FINALIZADO
            |--------------------------------------------------------------------------
            */

            barraProgreso.style.width = '100%';

            porcentaje.innerText = '100%';

            estadoCarga.innerText =
                'Todos los archivos fueron cargados correctamente.';


            alert(
                'Todos los archivos fueron procesados correctamente.'
            );


            window.location.reload();


        } catch (error) {

            console.error(error);


            estadoCarga.innerText =
                'La carga se interrumpió.';


            alert(
                'Error durante la carga:\n\n' +
                error.message
            );

        } finally {

            btnEnviar.disabled = false;

        }

    });

});
</script>
