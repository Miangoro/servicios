<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $datos->num_dictamen }} Dictamen de cumplimiento de Instalaciones como productor</title>
    <style>
      
    @font-face {
        font-family: 'fuenteNormal';
        src: url('{{ storage_path('fonts/lsansuni.ttf') }}');
    }

    @font-face {
        font-family: 'fuenteNegrita';
        src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
    }
        body {
            font-family: 'fuenteNormal';
            margin-left: 20px;
            margin-right: 20px;
        }

        .header {
            margin-top: -30px;
            width: 100%;
        }

        .header img {
            display: block;
            width: 275px;
        }

        .description1,
        .description2,
        .description3,
        .textimg {
            position: absolute;
            right: 10px;
            text-align: right;
        }

        .description1 {
            font-size: 18px;
            color: #151442;
            font-family: 'Arial Negrita' !important;
            top: 35px;
        }

        .description2 {
            color: #151442;
            font-family: 'Arial Negrita' !important;
            font-size: 9.5px;
            top: 60px;
        }

        .description3 {
            font-size: 10px;
            top: 72px;
            margin-right: 40px;
        }

        .textimg {
            font-weight: bold;
            position: absolute;
            top: 100px;
            left: 10px;
            text-align: left;
            font-size: 13px;
        }

        .text {
            text-align: justify;
            font-size: 13px;
            line-height: 0.7;
            margin-right: 10px;
        }

        .text1 {
            text-align: justify;
            font-size: 11px;
            line-height: 0.7;
        }

        .textp {
            text-align: justify;
            font-size: 13px;
            line-height: 0.7;
            margin-right: 10px;
            font-family: 'Lucida Sans Seminegrita';
            margin-top: 20px;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-family: 'Arial Negrita', Gadget, sans-serif;
            line-height: 20px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border: 2px solid #1E4678;
            border-collapse: collapse;
            margin: auto;
            font-size: 12px;
            line-height: 1;
            vertical-align: top;
            font-family: 'fuenteNormal';
        }

        td,
        th {
            border: 2px solid #1E4678;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        td {
            width: 50%;
        }

        .images-container {
            position: relative;
            display: flex;
            margin-top: -40px;
            width: 100%;
        }

        .image-left {
            margin-right: 60%;
            width: 12%;
        }

        .textsello {
            text-align: left;
            font-size: 8px;
            margin: 0;
            padding: 0;
        }

        .numpag {
            font-size: 10px;
            position: fixed;
            bottom: 10px;
            right: 15px;
            margin: 0;
            padding: 0;
        }

        .sello {
            text-align: right;
            font-size: 11px;
            margin: 0;
            padding: 0;
            position: absolute;
            right: 50px;
            top: 835px;
            font-family: 'Arial Negrita' !important;
        }

        .container {
            margin-top: 0px;
            position: relative;
        }

        .textx,
        .textsello {
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }

        .image-right {
            position: absolute;
            right: 10px;
            top: -20px;
            width: 240px;
        }


        .footer-bar {
            position: fixed;
            bottom: -55px;
            left: -70px;
            right: -70px;
            width: calc(100% - 40px);
            height: 45px;
            background-color: #158F60;
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 10px 0px;
        }

        .footer-bar {
            position: fixed;
            bottom: -55px;
            left: -70px;
            right: -70px;
            width: calc(100% - 40px);
            height: 45px;
            background-color: #158F60;
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 10px 0px;
        }

        .footer-bar p {
            margin: 0;
            line-height: 1;
        }

        .negrita {
            font-family: 'fuenteNegrita', sans-serif;
        }

        .pie {
            text-align: right;
            font-size: 9px;
            line-height: 1;
            position: fixed;
            bottom: -4;
            left: 0;
            right: 0;
            width: calc(100% - 40px);
            height: 45px;
            margin-right: 30px;
            padding: 10px 0px;
            font-family: 'Lucida Sans Unicode';
        }

        .interlineado{
            line-height: 10px;
        }

        .watermark-cancelado {
            font-family: Arial;
            color: red;
            position: fixed;
            top: 48%;
            left: 45%;
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            opacity: 0.5;
            /* Opacidad predeterminada */
            letter-spacing: 3px;
            font-size: 150px;
            white-space: nowrap;
            z-index:-1;
        }
        
    </style>
</head>
<body>

@if ($watermarkText)
    <div class="watermark-cancelado">
        Cancelado
    </div>
@endif


<div class="container">
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo UVEM" width="275px">
    </div>
    <br>
    <div class="description1">Unidad de Inspección No. UVNOM-129</div>
    <div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</div>
    <div class="description3">Acreditados ante la Entidad Mexicana de Acreditación, A.C</div>
    <div class="textimg negrita">No.: <u>{{ $datos->num_dictamen ?? '' }}</u></div>
    <div class="title">Dictamen de cumplimiento de Instalaciones como <br> productor</div>
    <div class="text">
        <p>De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección No. UVNOM 129 para
        la revisión de procesos de producción del producto Mezcal, su envasado y comercialización; y con fundamento
        en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la Calidad que establece el
        funcionamiento de las Unidades de Inspección.</p>
        <p>Después de realizar la inspección de las instalaciones en fecha del <u><span  class="negrita">{{ $fecha_inspeccion }}</span></u> partiendo del acta
        circunstanciada o número de inspección: <u><span  class="negrita">{{ $datos->inspeccione->num_servicio ?? '' }}</u></span></p>
        <p class="textp">Nombre del productor/empresa: <u>{{ $datos->inspeccione->solicitud->empresa->razon_social ?? '' }}</u></p>
    </div>
    <table class="interlineado">
        <tbody>
            <tr>
            <td style="text-align: justify;">
            <span class="negrita">Número de cliente:</span><br>
            (Otorgado por el Organismo Certificador del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.) (CIDAM)
            </td>
                <td style="text-align: center; vertical-align: middle;" class="negrita">
                    @php
                        // Encuentra el primer número de cliente válido
                        $numeroCliente = null;

                        if (isset($datos->inspeccione->solicitud->empresa->empresaNumClientes)) {
                            foreach ($datos->inspeccione->solicitud->empresa->empresaNumClientes as $cliente) {
                                if (!empty($cliente->numero_cliente)) {
                                    $numeroCliente = $cliente->numero_cliente;
                                    break; // Sal del bucle en cuanto encuentres un cliente válido
                                }
                            }
                        }
                    @endphp

                    <!-- Mostrar el número de cliente encontrado -->
                    @if($numeroCliente)
                        <b>{{ $numeroCliente }}</b>
                    @else
                        <span>No hay número de cliente disponible.</span>
                    @endif

                </td>
            </tr>
            <tr>
            <td>
            <span class="negrita">Domicilio Fiscal:</span>
            </td>

                <td style="text-align: center; vertical-align: middle;">{{ $datos->inspeccione->solicitud->empresa->domicilio_fiscal ?? '' }}</td>
            </tr>
            <tr>
            <td>
            <span class="negrita">Domicilio de la unidad de producción:</span>
            </td>
                <td style="text-align: center; vertical-align: middle;">{{ $datos->instalaciones->direccion_completa ?? '' }}</td>
            </tr>
            <tr>
                <td class="negrita">Responsable de la inspección:</td>
                <td style="text-align: center; vertical-align: middle;">{{ $datos->inspeccione->inspector->name ?? '' }}</td>
            </tr>
            <tr>
                <td class="negrita">Fecha de emisión de dictamen:</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fecha_emision }}</td>
            </tr>
            <tr>
                <td class="negrita">Periodo de vigencia hasta:</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fecha_vigencia }}</td>
            </tr>
        </tbody>
    </table>
    <p class="text">
    Se dictamina que la <span class="negrita">Unidad de producción</span> cuenta con la infraestructura, el equipo y los procesos necesarios
    para la producción de <span class="negrita"><u>{{ $datos->inspeccione->solicitud->categorias_mezcal()->pluck('categoria')->implode(', ') }}</u>, clase(s) <u>{{$datos->inspeccione->solicitud->clases_agave()->pluck('clase')->implode(', ') }}</u></span>, requisitos establecidos en la NOM-070-SCFI-2016,
    Bebidas alcohólicas-Mezcal-Especificaciones y por el Organismo de Certificación del Centro de Innovación y
    Desarrollo Agroalimentario de Michoacán A.C. (CIDAM).
   </p>

    <p class="text1">Las instalaciones se encuentran en región de los estados y municipios que contempla la resolución mediante el cual se otorga la protección
    prevista a la denominación de origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28 de noviembre
    de 1994, así como sus modificaciones subsecuentes.</p>


    <br><br>
    <p class="sello">Sello de Unidad de Inspección</p>
    <div class="images-container">
        <img src="{{ $qrCodeBase64 }}" alt="Logo UVEM" width="90px">
        <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right">
    </div>
    
    <p class="textx" style="font-size: 9px; margin-bottom:-8px; position: relative;">
        <strong>AUTORIZÓ</strong>
        <span style="margin-left: 25px; display: inline-block; text-align: center; position: relative;">
            @php
                use Illuminate\Support\Facades\Storage;
    
                $firma = $datos->firmante->firma ?? null;
                $firmaPath = $firma ? 'firmas/' . $firma : null;
            @endphp
    
            @if ($firma && Storage::disk('public')->exists($firmaPath))
                <img style="position: absolute; top: -45px; left: 170; right: 0; margin: 0 auto;" height="60px"
                    src="{{ public_path('storage/' . $firmaPath) }}">
            @endif
    
            <strong>{{ $datos->firmante->puesto ?? '' }} | {{ $datos->firmante->name ?? '' }}</strong>
        </span>
    </p>
    
    <p class="textx" style="font-size: 9px; margin-bottom:-8px">
        <strong>CADENA ORIGINAL</strong>
        <span style="margin-left: 14px;">
            <strong>{{ $firmaDigital['cadena_original'] }}</strong>
        </span>
    </p>

    <p class="textx" style="font-size: 9px; margin-bottom:1px">
        <strong>SELLO DIGITAL</strong>
    </p>

    <p class="textsello" style="width: 85%; word-wrap: break-word; white-space: normal;">
        {{ $firmaDigital['firma'] }}
    </p>
    

    <p class="pie">
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>Entrada en vigor: 15-07-2024
        <br>F-UV-02-04 Ver 10.
    </p>
    
    <div class="footer-bar">
        <p class="negrita">www.cidam.org . unidadverificacion@cidam.org</p>
        <p>Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341.
            Morelia Michoacán</p>
    </div>
    

</div>

</body>
</html>
