<x-app-layout>
    <x-slot name="header">
        <!--
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Envios') }}
        </h2>
        -->
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
                    <h1 class="text-center">FORMULARIOS DE CARGA</h1>

                    <form method="POST" action="{{ route('envio.registrar')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-jet-label for="documentacion" value="{{ __('SELECCIONAR CARPETA') }}" />
                            <x-jet-input id="documentacion" class="block mt-1 w-full" type="file" webkitdirectory directory multple name="documentacion[]" accept=".pdf,.zip,.rar" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="periodo" value="{{ __('PERIODO') }}" />
                            <x-jet-input id="periodo" class="block mt-1 w-full" type="text" name="periodo" :value="old('periodo')" required autofocus autocomplete="address" placeholder="mm/yyyy"/>
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
