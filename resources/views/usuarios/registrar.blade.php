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
            <h2>Formulario de Registro de Usuario</h2>
        </div>

        <form method="POST" action="{{ route('usuario.insert') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Usuario') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Correo Electronico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="estado" value="{{ __('Estado') }}" />
                <x-jet-input id="estado" class="block mt-1 w-full" type="text" name="estado" :value="old('estado')" required autocomplete="estado"/>
            </div>

            @if(Auth::user()->rol_usuario == 1)

                <div class="mt-4">
                    <x-jet-label for="areas" value="Area" />
                    <select name="areas" id="areas">
                        @foreach ($areas as $value)
                            <option value="{{ $value->ID }}">
                                {{ $value->ID }} - {{ $value->NOMBRE }}
                            </option>
                        @endforeach
                    </select>
                </div>

            @else

                <input type="hidden"
                    name="areas"
                    value="{{ Auth::user()->area_usuario }}">

            @endif
            <div class="mt-4">
                <x-jet-label for="areas" value="{{ __('Area') }}" />
                <select name="areas" id="areas">
                    @foreach ($areas as $item => $value)
                        <option value="{{ $value->ID }}">{{$value->ID}} - {{$value->NOMBRE}}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-jet-label for="nombre" value="{{ __('Nombre') }}" />
                <x-jet-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
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

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('usuario.back') }}">
                    {{ __('Cancelar') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Registrar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
