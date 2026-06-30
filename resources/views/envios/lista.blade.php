<x-app-layout>

    <div class="pt-4 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <h1 class="text-center"><strong>LISTA DE ENVIOS</strong> </h1>
                <br><br>
                <form method="POST" class="flex items-center justify-end my-3" role="search" action="{{ route('envio.buscar') }}">
                    @csrf
                    <x-jet-input id="name" class="block w-1/2" type="text" name="search" autofocus autocomplete="name" />
                    <x-jet-button class="ml-2">
                        {{ __('Buscar') }}
                    </x-jet-button>
                </form>
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
