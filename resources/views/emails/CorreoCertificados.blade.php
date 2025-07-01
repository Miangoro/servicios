<?php
switch ($tipo_certificado) {
    case 1:
        $tipoCertificadoTexto = "Productor";
        break;
    case 2:
        $tipoCertificadoTexto = "Envasador";
        break;
    case 3:
        $tipoCertificadoTexto = "Comercializador";
        break;
    case 4:
        $tipoCertificadoTexto = "Almacén y bodega";
        break;
    case 5:
        $tipoCertificadoTexto = "Área de maduración";
        break;
    default:
        $tipoCertificadoTexto = "Desconocido"; 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 10px;">
    <div style="background-color: #17905E; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;">
        <a href="https://oc.erpcidam.com" style="display: block; width: 100%; height: auto;">
            <img src="https://oc.erpcidam.com/apps/usuarios/img/logo.png" alt="Logo" style="width: 300px; display: block; margin: 0 auto; border-radius: 10px;">
        </a>
        <h1 style="color: #17202A; font-size: 18px; font-weight: bold; margin: 10px 0;">PLATAFORMA DEL ORGANISMO CERTIFICADOR DEL CIDAM</h1>
    </div>
    
    <div style="padding: 20px; text-align: center;">
        <h2 style="color: #333333;">REVISIÓN DE CERTIFICADO</h2>
<p style="color: #555555; margin-bottom: 10px;">
    Estimado(a) <strong>{{ $nombreRevisor }}</strong>,
</p>

<p style="color: #555555; margin-bottom: 10px;">
    Se le ha asignado la revisión del certificado <strong>{{ $num_certificado }}</strong>:
</p>

<ul style="color: #555555; margin-bottom: 10px; text-align:left;">
    <li><strong>Fecha de emisión:</strong> {{ $fecha_emision }}</li>
    <li><strong>Fecha de vigencia:</strong> {{ $fecha_vigencia }}</li>
    <li><strong>Cliente:</strong> {{ $razon_social }}</li>
    <li><strong>Número de cliente:</strong> {{ $numero_cliente }}</li>
    <li><strong>Tipo de certificado:</strong> {{ $tipo_certificado }}</li>
    <li><strong>Observaciones:</strong> {{ $observaciones ?? 'Ninguna' }}</li>
</ul>

<p style="color: #555555; margin-bottom: 10px;">
    Agradecemos su pronta atención y le recordamos que puede consultar el historial de este certificado en el apartado (Revisión de Certificados), utilizando su cuenta institucional.
</p>
        </p>
        <p style="color: #555555; margin-bottom: 10px;"></p>
      <a href="{{ url($url) }}" style="display: block; width: 200px; height: 50px; background-color: #0C1444; color: #ffffff; text-align: center; line-height: 50px; text-decoration: none; border-radius: 25px; margin: 20px auto;">Click aquí</a>

    </div>
    
    <div style="background-color: #17905E; padding: 20px; text-align: center; font-size: 12px; color: #ffffff; border-radius: 0 0 10px 10px;">
        <a href="https://oc.erpcidam.com" style="display: block; width: 100%; height: auto;">
            <img src="https://ci3.googleusercontent.com/meips/ADKq_NZYMS4OAqKcQS39YmpEYuUXJQbJtnkf0PhGOk1oBXoRfZiopnXTGxYHOutmPFT6VPaqFUUeklEqpM6WUtOZ5jdA4-Z4ROT0D-q-aGDP=s0-d-e1-ft#" alt="Agroinnovación" style="width: 150px; margin: 10px auto; display: block; border-radius: 50%;">
        </a>
        <p style="color: #000000; margin: 10px 0;">Agroinnovación, transformando ideas...</p>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="https://www.facebook.com/CIDAM.Agroinnovacion" target="_blank"><img src="https://img.icons8.com/?size=100&id=13912&format=png&color=000000" alt="Facebook" style="width: 30px; margin: 0 10px; background-color: #ffffff; border-radius: 50%; padding: 5px;"></a>
            <a href="https://twitter.com/cidam_ac?t=2VPEV2R2vH7fuqp3GBVOZg&s=08" target="_blank"><img src="https://img.icons8.com/?size=100&id=5MQ0gPAYYx7a&format=png&color=000000" alt="Twitter" style="width: 30px; margin: 0 10px; background-color: #ffffff; border-radius: 50%; padding: 5px;"></a>
            <a href="https://www.youtube.com/@CIDAM.Agroinnovacion" target="_blank"><img src="https://img.icons8.com/?size=100&id=19318&format=png&color=000000" alt="YouTube" style="width: 30px; margin: 0 10px; background-color: #ffffff; border-radius: 50%; padding: 5px;"></a>
            <a href="https://www.instagram.com/cidam.agroinnovacion/" target="_blank"><img src="https://img.icons8.com/?size=100&id=32323&format=png&color=000000" alt="Instagram" style="width: 30px; margin: 0 10px; background-color: #ffffff; border-radius: 50%; padding: 5px;"></a>
        </div>
    </div>
</div>

</body>
</html>
