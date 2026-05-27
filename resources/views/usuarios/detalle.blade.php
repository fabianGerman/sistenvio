<div>
    <h4 style="size: 20%"><strong>-------- DATOS DEL USUARIO --------</strong></h4>
    <p><strong>ID:</strong> {{ $usuario->ID }}</p>
    <p><strong>Usuario:</strong> {{ $usuario->USUARIO }}</p>
    <p><strong>Correo Electrónico:</strong> {{ $usuario->CORREO_ELECTRONICO }}</p>
    <p><strong>Estado:</strong> {{ $usuario->ESTADO }}</p>
    <p><strong>Rol:</strong> {{ $usuario->ROLES }}</p>
    <h4><strong>-------- DATOS DE CLINICIA --------</strong></h4>
    <p><strong>C.U.I.T.:</strong>{{ $usuario->CUIT }}</p>
    <p><strong>Area:</strong> {{ $usuario->AREA }}</p>
    <p><strong>Direccion:</strong> {{ $usuario->DOMICILIO }} </p>
    <p><strong>Telefono:</strong> {{ $usuario->TELEFONO }} </p>
    <h4><strong>-------- DATOS EMPLEADO --------</strong></h4>
    <p><strong>Documento:</strong> {{ $persona->DOCUMENTO }} </p>
    <p><strong>Apellido y Nombre:</strong>{{ $persona->APELLIDO_NOMBRE }} </p>
</div>