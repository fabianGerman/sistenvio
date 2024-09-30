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
            <h2>Formulario de Modificacion de Usuario</h2>
        </div>

        <form method="POST" action="{{ route('usuario.edit',$usuario) }}">
            @csrf

            <div>
                <x-jet-label for="id" value="{{ __('Id') }}" />
                <x-jet-input id="id" class="block mt-1 w-full" type="number" name="id" value="{{ $usuario->id }}" required autofocus autocomplete="name" />
            </div>
            
            <div>
                <x-jet-label for="name" value="{{ __('Usuario') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $usuario->name }}" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Correo Electronico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $usuario->email }}" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="estado" value="{{ __('Estado') }}" />
                <x-jet-input id="estado" class="block mt-1 w-full" type="text" name="estado" value="{{ $usuario->estado }}" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="rol" value="{{ __('Rol') }}" />
                <x-jet-input id="rol" class="block mt-1 w-full" type="text" name="rol" value="{{ $usuario->rol }}" required />
            </div>

            <div>
                <x-jet-label for="documento" value="{{ __('Documento') }}" />
                <x-jet-input id="documento" class="block mt-1 w-full" type="text" name="documento" value="{{ $persona->per_documento }}" required autofocus autocomplete="documento" />
            </div>

            <div>
                <x-jet-label for="nombre" value="{{ __('Nombre') }}" />
                <x-jet-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ $persona->per_nombres }}" required autofocus autocomplete="nombre" />
            </div>

            <div>
                <x-jet-label for="instituto" value="{{ __('Instituto') }}" />
                <x-jet-input id="instituto" class="block mt-1 w-full" type="text" name="instituto" value="{{ $persona->per_instituto }}" required autofocus autocomplete="instituto" />
            </div>

            <div>
                <x-jet-label for="direccion" value="{{ __('Direccion') }}" />
                <x-jet-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" value="{{ $persona->per_direccion }}" required autofocus autocomplete="direccion" />
            </div>

            <div>
                <x-jet-label for="telefono" value="{{ __('Telefono') }}" />
                <x-jet-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" value="{{ $persona->per_telefono }}" required autofocus autocomplete="telefono" />
            </div>

            <div class="mt-4">
                <x-jet-label for="roles" value="{{ __('Rol') }}" />
                <select name="roles" id="roles">
                    @foreach ($roles as $item => $value)
                        <option value="{{ $value->id }}">{{$value->ID}} - {{$value->ROL}}</option>   
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="areas" value="{{ __('Area') }}" />
                <select name="areas" id="areas">
                    @foreach ($areas as $item => $value)
                        <option value="{{ $value->ID }}">{{$value->ID}} - {{$value->NOMBRE}}</option>   
                    @endforeach
                </select>
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
                    {{ __('Cancel') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
