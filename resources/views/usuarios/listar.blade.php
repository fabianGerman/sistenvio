<x-app-layout>
    <x-slot name="header">
        <a href="{{route('usuario.registrar')}}">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('AGREGAR') }}
            </h2>
        </a>
    </x-slot>

    <div class="pt-4 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl  sm:rounded-lg ">

                <h1 class="text-center"><strong>LISTA DE USUARIOS</strong> </h1>
                
                <br><br>
                <form method="POST" class="flex items-center justify-end my-3" role="search" action="{{route('usuario.search')}}">
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
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">USUARIO</th>
                                <th class="px-4 py-2">CORREO ELECTRONICO</th>
                                <th class="px-4 py-2">ESTADO</th>
                                <th class="px-4 py-2">ROL</th>
                                <th class="px-4 py-2">AREA</th>
                                <th class="px-4 py-2">MOSTRAR</th>
                                <th class="px-4 py-2">MODIFICAR</th>
                                <th class="px-4 py-2">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($lista as $item)
                                <tr>
                                    <td class="border px-4 py-2">{{ $item->ID }}</td>
                                    <td class="border px-4 py-2">{{ $item->USUARIO }}</td>
                                    <td class="border px-4 py-2">{{ $item->CORREO_ELECTRONICO }}</td>
                                    <td class="border px-4 py-2">{{ $item->ESTADO }}</td>
                                    <td class="border px-4 py-2">{{ $item->ROLES }}</td>
                                    <td class="border px-4 py-2">{{ $item->AREA }}</td>
                                    <td class="border px-4 py-2">
                                        <x-jet-button type="button" class="ml-2" data-toggle="modal" data-target="#modelId" data-id="{{$item->ID}}">
                                            {{ __('Mostrar') }}
                                        </x-jet-button>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <x-jet-button class="ml-2">
                                            <a href="{{route('usuario.update',$item->ID)}}">
                                                {{ __('Modificar') }}
                                            </a>
                                        </x-jet-button>
                                    </td>
                                    <td>
                                        
                                        <x-jet-button class="ml-2">
                                            
                                            <a href="{{route('usuario.delete',$item->ID)}}">
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
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Ficha del Uusario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        Add rows here
                    </div>
                </div>
                <!--
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
                -->
            </div>
        </div>
    </div>
    
</x-app-layout>

