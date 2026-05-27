
    <h1>Envio: {{ $envio->id }}</h1>

    <p><strong>Prestador:</strong> {{ $envio->PRESTADOR }}</p>
    <p><strong>Obra Social:</strong> {{ $envio->OBRASOCIAL }}</p>
    <p><strong>Afiliado:</strong> {{ $envio->AFILIADO }}</p>
    <p><strong>Periodo:</strong> {{ $envio->PERIODO }}</p>
    <p><strong>Prestación:</strong> {{ $envio->PRESTACION }}</p>
    <p><strong>FECHA DE CARGA:</strong>{{ $envio->FECHACREACION}}</p>
    <p><strong>Documento:</strong></p>
  
    <a href="{{ $envio->DOCUMENTACION }}" target="_blank">Ver documento</a>
 


    
