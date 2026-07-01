<x-app-layout>

    <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-lg rounded-xl border border-gray-200">

            <!-- Encabezado -->
            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl">
                <h2 class="text-xl font-black">
                    🔎 Filtros de Búsqueda
                </h2>
                <p class="text-sm text-blue-100">
                    Busque envíos por Obra Social, Afiliado, Prestador o Prestación.
                </p>
            </div>

            <!-- Formulario -->
            <div class="p-6">

                <form method="POST" action="{{ route('envio.buscar') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Obra Social -->
                        <div>
                            <x-jet-label
                                for="obrassociales"
                                value="Obra Social" />

                            <select
                                name="obrassocial"
                                id="obrassocial"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                @foreach ($obrassociales as $value)
                                    <option value="{{ $value->ID }}">
                                        {{ $value->SIGLAS }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Buscador -->
                        <div class="md:col-span-2">
                            <x-jet-label
                                for="search"
                                value="Buscar" />

                            <x-jet-input
                                id="search"
                                name="search"
                                type="text"
                                class="block mt-2 w-full"
                                placeholder="N° Afiliado · DNI · Matrícula Prestador · Prestación..." />
                        </div>

                        <div class="md:col-span-3">
                            <x-jet-label
                                for="periodo"
                                value="Período" />

                            <x-jet-input
                                id="periodo"
                                name="periodo"
                                type="text"
                                class="block mt-2 w-full"
                                placeholder="Período..." />
                        </div>

                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-3 mt-6">

                        <a href="{{ route('envio.lista') }}"
                           class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">
                            Limpiar
                        </a>

                        <x-jet-button class="px-6">
                            Buscar
                        </x-jet-button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>


    <div class="pt-4 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <h1 class="text-center"><strong>LISTA DE ENVIOS</strong> </h1>
                <br><br>

                <div style="overflow-x: auto;">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">AFILIADO</th>
                                <th class="px-4 py-2">PRESTADOR</th>
                                <th class="px-4 py-2">OBRA SOCIAL</th>
                                <th class="px-4 py-2">PERIODO</th>
                                <th class="px-4 py-2">Nª PRESTACION</th>
                                <th class="px-4 py-2">FECHA DE CARGA</th>
                                <th class="px-4 py-2">DOCUMENTACION</th>
                                <th class="px-4 py-2">COMPROBANTE</th>
                                <th class="px-4 py-2">MODIFICAR</th>
                                <th class="px-4 py-2">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($envios as $envio)
                                <tr>
                                    <td class="border px-4 py-2">{{ $envio->AFILIADO }}</td>
                                    <td class="border px-4 py-2">{{ $envio->PRESTADOR }}</td>
                                    <td class="border px-4 py-2">{{ $envio->OBRASOCIAL }}</td>
                                    <td class="border px-4 py-2">{{ $envio->PERIODO }}</td>
                                    <td class="border px-4 py-2">{{ $envio->PRESTACION }}</td>
                                    <td class="border px-4 py-2">{{ $envio->FECHACREACION }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('envio.descargar', ['id' => $envio->id]) }}"
                                            class="text-blue-600 underline">
                                            Descargar documento
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('envio.comprobante',['id'=>$envio->id]) }}" target="_blank">ver comprobante</a>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <x-jet-button class="ml-2">
                                            <a href="{{route('envio.modificar',$envio->id)}}">
                                                {{ __('Modificar') }}
                                            </a>
                                        </x-jet-button>
                                    </td>
                                    <td>
                                        <x-jet-button class="ml-2">
                                            <a href="{{route('envio.eliminar',$envio->id)}}">
                                                {{ __('Eliminar') }}
                                            </a>
                                        </x-jet-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $envios->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
