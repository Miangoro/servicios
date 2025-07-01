<!DOCTYPE html>
<html>
<head>
    <title>Firma Completada</title>
</head>
<body>
    <h1>¡Gracias por firmar!</h1>

    <p>El documento fue firmado correctamente.</p>

    <a href="{{ route('docusign.descargar', ['envelopeId' => $envelopeId]) }}">Descargar documento firmado</a>
</body>
</html>
