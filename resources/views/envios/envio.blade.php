<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <x-jet-authentication-card>
                    <x-slot name="logo">
                        <x-jet-authentication-card-logo />
                        <br><br>
                        <h1><strong>SALUD JUJUY</strong></h1>
                    </x-slot>
            
                    <x-jet-validation-errors class="mb-4" />
                    <h1 class="text-center">FORMULARIOS DE ENVIO</h1>
    
                    <form method="POST" action="{{ route('envio.registrar')}}" enctype="multipart/form-data">
                        @csrf
            
                        <div>
                            <x-jet-label for="documentacion" value="{{ __('DOCUMENTACION') }}" />
                            <x-jet-input id="documentacion" class="block mt-1 w-full" type="file" name="documentacion" accept=".pdf" required autofocus />
                        </div>
            
                        <div class="mt-4">
                            <x-jet-label for="obrasocial" value="{{ __('OBRA SOCIAL') }}" />
                            <x-jet-input id="obrasocial" class="block mt-1 w-full" type="text" name="obrasocial" :value="old('obrasocial')" required autofocus autocomplete="cuit"/>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="periodo" value="{{ __('PERIODO') }}" />
                            <x-jet-input id="periodo" class="block mt-1 w-full" type="text" name="periodo" :value="old('periodo')" required autofocus autocomplete="address"/>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="prestador" value="{{ __('PRESTADOR') }}" />
                            <x-jet-input id="prestador" class="block mt-1 w-full" type="text" name="prestador" :value="old('prestador')" required autofocus autocomplete="phone"/>
                        </div>
            
                        <div class="mt-4">
                            <x-jet-label for="prestacion" value="{{ __('NUMERO PRESTACION') }}" />
                            <x-jet-input id="prestacion" class="block mt-1 w-full" type="text" name="prestacion" :value="old('prestacion')" required autofocus autocomplete="phone"/>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="afiliado" value="{{ __('AFILIADO') }}" />
                            <x-jet-input id="afiliado" class="block mt-1 w-full" type="text" name="afiliado" :value="old('afiliado')" required autofocus autocomplete="phone"/>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button class="ml-4">
                                {{ __('ENVIAR') }}
                            </x-jet-button>
                        </div>
                    </form>
                </x-jet-authentication-card>
            </div>
        </div>
    </div>
</x-app-layout>