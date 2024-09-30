<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div>
        <x-jet-application-logo class="block h-12 w-auto" />
    </div>

    <div class="mt-8 text-2xl">
        Welcome to your Jetstream application!
    </div>

    <div class="mt-6 text-gray-500">
        Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
        to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
        you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
        ecosystem to be a breath of fresh air. We hope you love it.
    </div>
</div>


<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">

    <!-- MODULO DE USUARIO -->
    <div class="p-6">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                <path d="M5.121 19a9.004 9.004 0 0 1 13.758 0m-6.879-7a4 4 0 1 0-5.5 0 4 4 0 0 0 5.5 0z"></path>
              </svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><h4><strong>USUARIO</strong></h4></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                <p>Modulo para el control de usuario, en este modulo se puede agregar, modificar, eliminar, y generar reportes de los usuarios</p>
            </div>
            @if (Auth::user()->rol_usuario != 3)
                <a href="{{route('usuario.listar')}}">
                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Ingrese Aqui</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                    </div>
                </a>
            @else
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>
                        <h1>Modulo no disponible para este usuario</h1>
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    <!-- MODULO AFILIADO -->
    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><h4><strong>AFILIADOS</strong></h4></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Modulo de gestion para los afiliados del instituto
            </div>
            @if (Auth::user()->rol_usuario != 3)
                <a href="{{ route('afiliado.listar')}}">
                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Ingrese Aqui</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                    </div>
                </a>
            @else
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>
                        <h1>Modulo no disponible para este usuario</h1>
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    <!-- MODULO PRESTADOR -->
    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><h4><strong>PRESTADORES</strong></h4></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Modulo de gestion para los prestadores
            </div>
            @if (Auth::user()->rol_usuario != 3)
                <a href="{{route('prestador.listar')}}">
                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Ingrese Aqui</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                    </div>
                </a>
            @else
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>
                        <h1>Modulo no disponible para este usuario</h1>
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    <!-- MODULO OBRA SOCIAL -->
    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><h4><strong>OBRAS SOCIALES</strong></h4></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Modulo de gestion de obras sociales
            </div>
            @if (Auth::user()->rol_usuario != 3)
                <a href="{{ route('obrasocial.listar')}}">
                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Ingrese Aqui</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                    </div>
                </a>
            @else
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>
                        <h1>Modulo no disponible para este usuario</h1>
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    <!-- MODULO ROL -->
    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><h4><strong>ROLES</strong></h4></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Modulo de gestion de roles
            </div>
            @if (Auth::user()->rol_usuario == 1)
                <a href="{{ route('rol.listar') }}">
                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Ingrese Aqui</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                    </div>
                </a>
            @else
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>
                        <h1>Modulo no disponible para este usuario</h1>
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    <!-- MODULO AREA -->
    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><h4><strong>AREAS</strong></h4></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Modulo de gestion de area
            </div>
            @if (Auth::user()->rol_usuario == 1)
                <a href="{{ route('area.listar') }}">
                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Ingrese Aqui</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                    </div>
                </a>
            @else
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>
                        <h1>Modulo no disponible para este usuario</h1>
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    <!-- MODULO ARCHIVO -->
    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><h4><strong>ARCHIVO</strong></h4></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Modulo de gestion de envio
            </div>
            @if (Auth::user()->rol_usuario == 1)
                <a href="{{ route('area.listar') }}">
                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Ingrese Aqui</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                    </div>
                </a>
            @else
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>
                        <h1>Modulo no disponible para este usuario</h1>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>
