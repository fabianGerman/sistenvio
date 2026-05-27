<x-app-layout>
    <x-slot name="header">
        <a href="{{route('rol.registrar')}}">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('AGREGAR') }}
            </h2>
        </a>
    </x-slot>

    <div class="pt-4 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">

                <h1 class="text-center"><strong>LISTA DE ROLES</strong> </h1>

                <br><br>
                <form method="POST" class="flex items-center justify-end my-3" role="search" action="{{route('rol.search')}}">
                    @csrf
                    <x-jet-input id="search" class="block w-1/2" type="text" name="search" autofocus autocomplete="name" />
                    <x-jet-button class="ml-2">
                        {{ __('Buscar') }}
                    </x-jet-button>
                </form>
                <div style="overflow-x: auto;">
                    <table class="table-auto w-full text-center">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">NOMBRE</th>
                                <th class="px-4 py-2">DESCRIPCION</th>
                                <th class="px-4 py-2">MODIFICAR</th>
                                <th class="px-4 py-2">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($lista as $item)
                                <tr>
                                    <td class="border px-4 py-2">{{ $item->NOMBRE }}</td>
                                    <td class="border px-4 py-2">{{ $item->DESCRIPCION }}</td>
                                    <td class="border px-4 py-2">
                                        <x-jet-button class="ml-2">
                                            <a href="{{route('rol.modificar',$item->ID)}}">
                                                {{ __('Modificar') }}
                                            </a>
                                        </x-jet-button>
                                    </td>
                                    <td>
                                        <x-jet-button class="ml-2">
                                            <a href="{{route('rol.eliminar',$item->ID)}}">
                                                {{ __('Eliminar') }}
                                            </a>
                                        </x-jet-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $lista->links() }}
                </div>
                
            </div>
            
        </div>
    </div>
</x-app-layout>