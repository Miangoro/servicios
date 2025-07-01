<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de asignación de usuario y contraseña para plataforma del OC</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 15px;
            position: relative; /* Añadido para que los elementos absolutos se posicionen correctamente */
            color: black;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative; /* Añadido para posicionamiento relativo */
        }

        .header img {
            width: 150px;
            float: left;
            margin-right: 10px;
            margin-left: 20px;
            margin-top: -44px;
        }

        .text p {
            font-size: 13px;
            text-align: left;
            margin-right: -10px;
            margin-top: -70px; /* Ajuste de margen para alinear con la imagen */
        }

        .text2 p {
            font-size: 13px;
            margin-top: -54px;
            margin-left: 515px; /* Ajuste de posición horizontal */
        }

        .text3 p {
            font-size: 13px;
            margin-top: -27px;
            margin-left: 351px;
        }

        .line {
            position: absolute;
            top: 79px; /* Ajuste la posición vertical */
            right: 56px; /* Ajusta la posición derecha */
            width: 64%; /* Largo*/
            border-bottom: 1.3px solid black; /* Estilo de la línea */
        }

        .section {
            font-size: 16px;
            margin-top: 50px;
            margin-bottom: 4rem;
            margin-left: 21rem;
        }

        .asunto {
            font-size: 15px;
            margin-top: -75px;
            margin-left: 210px;
            font-weight: bold;
        }

        /* Contenido */
        .contenido p {
            font-size: 20px;
            margin-top: 20px;
            margin-left: 8px;
            font-weight: bold;
        }

        .contenido_text p {
            font-size: 15.8px;
            margin-left: 8px;
            line-height: 1.3; /* Puedes ajustar este valor según lo necesites */
            text-align: justify; 
        }

        .link  p {
            margin-left: 8px;
            text-align: center;
            font-size: 22px;
            color: blue; /* Color azul para el enlace */
            text-decoration: underline; /* Subrayado */
            margin-top: -20px;
        }

        .Datos p {
            font-size: 16px;
            margin-left: 8px;
            line-height: 1.3; /* Puedes ajustar este valor según lo necesites */
            text-align: justify; 
        }

        .Atentamente p {
            font-size: 16px;
            text-align: center;
            margin-top: 10px;
        }

    </style>
</head>

<body>
    <div class="header">
        <br>
        <br>
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
    </div>
    <div class="text">
        <p>Carta de asignación de usuario y contraseña para plataforma del OC</p>
    </div>
    <div class="text2">
        <p>F7.1-01-46</p>
    </div>
    <div class="text3">
        <p>Edición 0 Entrada en vigor: 01-09-2022</p>
    </div>
    <div class="line"></div> <!-- Línea desde la esquina derecha inferior -->
    <div class="section">
        <p class="text_al left">Morelia, Mich. a <b>{{$dia}}</b> de <b>{{$mes}}</b> del <b>{{$anio}}</b></p>
    </div>
    <div class="asunto">
        <p>ASUNTO: Asignación de usuario para acceso a plataforma</p>
    </div>

    <!-- Contenido -->
    <div class="contenido">
        <p>C. {{$datos->name}}</p>
    </div>
    <div class="contenido_text">
        <p>Reciba un cordial saludo de nuestro equipo del Centro de Innovación y Desarrollo
            Agroalimentario de Michoacán, A.C. (CIDAM), particularmente de quienes integramos el
            Organismo Certificador de Bebidas Alcohólicas CIDAM, es un placer compartir con Usted
            su usuario y contraseña para acceso a la plataforma ERP CIDAM.
            </p>
            <p>Ingrese a:</p>
    </div>
    <div class="link">
        <p>https://occidam.com/</p>
    </div>
    <div class="Datos">
        <p>USUARIO: <b>{{$datos->email}}</b></p>
        <p>CONTRASEÑA: <b>{{$datos->password_original}}</b></p>
        <p>Con esta información Usted podrá solicitar los servicios que requiera y verificar la
            trazabilidad de los mismos, así también realizar descargas de archivos referentes a su
            proceso de certificación, le pedimos la resguarde como información de carácter
            confidencial e intransferible.
            </p>
            <br>
            <p>Sin otro particular quedamos de usted.</p>
            <br>
    </div>
    <div class="Atentamente">
        <p>Atentamente.</p>
        <p>_______________________</p>
    </div>
</body>
</html>
