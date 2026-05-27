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
    
                    
                </x-jet-authentication-card>
            </div>
        </div>
    </div>
</x-app-layout>