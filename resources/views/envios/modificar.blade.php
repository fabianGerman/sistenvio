<x-app-layout>
    <x-slot name="header">
        <a href="{{route('usuario.registrar')}}">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('AGREGAR') }}
            </h2>
        </a>
    </x-slot>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
            <br><br>
            <h1 style="font-size: 20px"><strong>SALUD JUJUY</strong></h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <div class="text-center">
            <h2>Formulario de Modificacion de Envio</h2>
        </div>

        <form method="POST" action="{{ route('envio.actualizar',$envio) }}">
            @csrf

            <div>
                <x-jet-label for="id" value="{{ __('ID Envio') }}" />
                <x-jet-input id="id" class="block mt-1 w-full" type="text" name="id" value="{{ $envio->id }}" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-jet-label for="periodo" value="{{ __('Periodo') }}" />
                <x-jet-input id="periodo" class="block mt-1
                            w-full" type="text" name="periodo" value="{{ $envio->env_periodo }}" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-jet-label for="prestador" value="{{ __('Prestador') }}" />
                <x-jet-input id="prestador" class="block mt-1 w-full" type="text" name="prestador" value="{{ $envio->env_prestador }}" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-jet-label for="afiliado" value="{{ __('Afiliado') }}" />
                <x-jet-input id="afiliado" class="block mt-1 w-full" type="text" name="afiliado" value="{{ $envio->env_afiliado }}" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-jet-label for="prestacion" value="{{ __('Prestacion') }}" />
                <x-jet-input id="prestacion" class="block mt-1 w-full" type="text" name="prestacion" value="{{ $envio->env_prestacion }}" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-jet-label for="obrasocial" value="{{ __('Obra Social') }}" />
                <x-jet-input id="obrasocial" class="block mt-1 w-full" type="text" name="obrasocial" value="{{ $envio->env_obrasocial }}" required autofocus autocomplete="name" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-content mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Actualizar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
