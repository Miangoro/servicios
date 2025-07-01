<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento para Producto de Exportación</title>
    <style>
        @page {
            margin-top: 30;
            margin-right: 80px;
            margin-left: 80px;
            margin-bottom: 1px;
        }

        @font-face {
            font-family: 'Lucida Sans Unicode';
            src: url('fonts/lsansuni.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Lucida Sans Seminegrita';
            src: url('fonts/LSANSD.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Arial Negrita';
            src: url('fonts/arial-negrita.ttf') format('truetype');
        }

        .negrita {
            font-family: 'Arial Negrita';
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            padding-top: 13%;
            padding-right: 4px;
            padding-left: 4px;
        }
        .leftLetter {
            text-align: left;
        }
        .rightLetter {
            text-align: right;
        }
        .letter-color {
            color: black;
            text-align: center;
            margin-left: 0;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            border: 2px solid black;
            padding-top: 8px;
            padding-bottom: 8px;
            text-align: center;
            font-size: 11px;
        }
        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-size: 11px;
        }

        .td-margins {
            border-bottom: 1px solid #366091;
            border-top: 1px solid #366091;
            border-right: none;
            border-left: none;
            font-size: 11px;
        }
        .td-margins-none {
            border-bottom: 1px solid #366091;
            border-top: none;
            border-right: none;
            border-left: none;
            font-size: 11px;
        }
        .td-no-margins {
            border: none;
        }
        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }
        .titulos {
            font-size: 22px;
            line-height: 0.9;
            padding: 10px;
            text-align: center;
            font-family: 'Arial Negrita';
        }

        .encabezado {
            position: fixed;
            width: 100%; 
            top: 0;
            left: 0;
        }
        .footer{
            position: fixed;
            bottom: -1;
            font-size: 10px;
            text-align: center;
            left: -80px;
            right: -80px;
            font-size: 11px;
            z-index: 9999;
        }
        .img-footer {
            left: -80px;
            right: -80px;
            background-color: #158F60;
            color: white;
            padding-bottom: 5px;
            padding-top: 0.6px;
        }

        .sello {
            text-align: right;
            font-size: 11px;
            margin: 0;
            padding: 0;
            position: absolute;
            right: 20px;
            top: 800px;
            font-family: 'Arial Negrita' !important;
        }
        .textx, .textsello {
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }
        .textsello {
            text-align: left;
            font-size: 8px;
            margin: 0;
            padding: 0;
        }

        .images-container {
            position: relative;
            display: flex;
            margin-top: -40px;
            width: 100%;
        }

        .image-right {
            position: absolute; 
            right: -20px; 
            top: -20px; 
            width: 240px;
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

<!-- Aparece la marca de agua solo si la variable 'watermarkText' tiene valor -->
@if ($watermarkText)
    <div class="watermark-cancelado">
        Cancelado
    </div>
@endif

<div class="encabezado">
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}"
        style="width: 270px; float: left; margin-left: -40px; margin-top: -30px;" alt="logo de CIDAM 3D">
    <div class="letter-color" style=" line-height: 0.6; color: #151442">
        <p class="rightLetter" style="font-size: 16px"><span class="negrita">Unidad de Inspección No. UVNOM-129</span>
            <br>
            <span class="negrita rightLetter" style="font-size: 9px"> Centro de Innovación y Desarrollo Agroalimentario
                de Michoacán, A.C. </span><br><span class="rightLetter" style="font-size: 9.5px">Acreditados ante la
                Entidad Mexicana de Acreditación, A.C.</span>
        </p>
    </div>
</div>

<div class="footer">
    <p style="text-align: right; padding-right: 10%; padding-bottom:9px; margin-bottom: -2px;  font-family: Lucida Sans Unicode; font-size: 9px; line-height:1;">
        <!-- Aparece  solo si tiene valor -->
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>Entrada en vigor: 15-07-2024
        <br>F-UV-04-18 Ver 2.
    </p>

    <div class="img-footer">
        <p style="font-lucida-sans-seminegrita"><b>www.cidam.org . unidadverificacion@cidam.org</b></p>
        <p style="margin-top: -10px">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el
            catálogo C.P. 58341. Morelia Michoacán</p>
    </div>
</div>


    <div class="titulos">
        Dictamen de Cumplimiento para Producto de
        <br> Exportación
    </div>
    <div class="negrita" style="font-size: 14px">PRODUCTO: {{ $producto }}</div>
    <table>
        <tr>
            <td style="font-size: 15px;padding-bottom: 15px; padding-top: 15px"><b>Fecha de emisión</b></td>
            <td style="width: 130px">{{ $fecha_emision }}</td>
            <td style="font-size: 15px; width: 170px"><b>Número de dictamen:</b></td>
            <td style="width: 130px">{{ $no_dictamen }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;padding-bottom: 25px; padding-top: 25px"><b>Razón social</b></td>
            <td>{{ $empresa }}</td>
            <td style="font-size: 15px"><b>Domicilio fiscal</b></td>
            <td>{{$domicilio}}</td>
        </tr>
        <tr>
            <td style="font-size: 15px; padding-bottom: 15px; padding-top: 15px"><b>RFC</b></td>
            <td>{{$rfc}}</td>
            <td style="font-size: 15px"><b>Registro de productor autorizado</b></td>
            <td>{{$productor_autorizado}}&nbsp;</td>
        </tr>
    </table>

    <div style="height: 20px"></div>
    <div style="font-size: 14px; text-align: justify;">
        Con fundamento en los artículos 53, 54, 55, 56, 57 y 69 de la Ley de Infraestructura de la Calidad, la
        Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal- Especificaciones y el
        apartado 7.4 de la Norma Mexicana NMX-EC-17020-INMC-2014 “Evaluación de la conformidadRequisitos para el
        funcionamiento de diferentes tipos de unidades (organismos) que realizan la verificación
        (Inspección)”; la Unidad de Inspección CIDAM A.C. con domicilio en Kilómetro 8 Antigua Carretera a
        Pátzcuaro, S/N Colonia Otra no Especificada en el Catálogo, C.P. 58341, Morelia, Michoacán.con número
        de acreditación UVNOM 129 ante la Entidad Mexicana de Acreditación A.C. y debidamente aprobada por
        la Dirección General de Normas de la Secretaría de Economía.
    </div>
    <div style="font-size: 14px; text-align: justify;padding-bottom: 20px; padding-top: 20px">El producto tiene como
        destino la <b> venta de exportación</b> a:
    </div>

    <table>
        <tr>
            <td style="font-size: 15px; width: 160px; padding-bottom: 15px; padding-top: 15px"><b>Importador</b></td>
            <td style="width: 160px">{{$importador}}</td>
            <td style="font-size: 15px; width: 120px"><b>Dirección</b></td>
            <td style="width: 180px">{{$direccion}}</td>
        </tr>
        <tr>
            <td style="font-size: 15px"><b>País de destino</b></td>
            <td>{{$pais}}</td>
            <td style="font-size: 15px" rowspan="2"><b>Aduana de <br>
                    salida</b></td>
            <td rowspan="2">{{$aduana}}</td>
        </tr>
        <tr>
            <td style="font-size: 15px"><b>RFC</b></td>
            <td>---</td>
        </tr>
    </table>

    <div style="page-break-after: always;"></div>



@foreach($lotes as $lote) 
    <table>
        <tr>
            <td style="font-size: 15px; padding-bottom: 15px; padding-top: 15px; width: 90px"><b>Identificación</b></td>
            <td style="width: 90px">---</td>
            <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 90px"><b>Marca</b></td>
            <td style="width: 90px">{{ $lote->marca->marca ?? "No encontrada"}} </td>
            <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 90px"><b>Producto</b></td>
            <td style="width: 90px">{{ $lote->lotesGranel->first()->categoria->categoria ?? "No encontrada"}}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>Categoría</b></td>
            <td>{{ $lote->lotesGranel->first()->categoria->categoria ?? "No encontrada"}}</td>
            <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>Clase</b></td>
            <td>{{ $lote->lotesGranel->first()->clase->clase ?? "N"}}</td>
            <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>% Alc. Vol.<br>(etiqueta)</b></td>
            <td> {{ $lote->lotesGranel->first()->cont_alc ?? "No encontrada" }}% </td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>Cont. Net. <br>(mL)</b></td>
            <td>{{ $presentacion ?? '' }} </td>
            <td style="font-size: 15px;"><b>No. Botellas</b></td>
            <td>{{$botellas}}</td>
            <td style="font-size: 15px;"><b>No. Cajas</b></td>
            <td>{{$cajas}}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>Lote de <br>Envasado</b></td>
            <td>{{ $lote->nombre ?? "No encontrada" }}</td>
            <td style="font-size: 15px;"><b>Estado <br>Productor</b></td>
            <td>{{$envasado_en}}</td>
            <td style="font-size: 15px;"><b>Lote a <br>granel</b></td>
            <td>{{ $lote->lotesGranel->first()->nombre_lote ?? "No encontrada" }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>No. Análisis</b></td>
            <td>{{ $lote->lotesGranel->first()->folio_fq ?? "No encontrada" }}</td>
            <td style="font-size: 15px;"><b>% Alc. Vol. <br>(No. análisis)</b></td>
            <td>{{ $lote->lotesGranel->first()->cont_alc ?? "No encontrada" }}% Alc. Vol.</td>
            <td style="font-size: 15px;" rowspan="2"><b>Especie de agave o maguey</b></td>
            <td style="font-size: 12px;" rowspan="2">
                {{ $lote->lotesGranel->first()->tiposRelacionados->pluck('nombre')->implode(', ') ?? 'No encontrado' }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>Ingrediente</b></td>
            <td>---</td>
            <td style="font-size: 15px;"><b>Sellos</b></td>
            <td>---</td>
        </tr>
    </table>

     


@if($loop->last)<!--AL FINAL DE LA TABLA-->
    <div style="height: 15px"></div>
    <div>OBSERVACIONES:</div>
    
    <div style="height: 40%"></div><!--espacio alto-->

    <!--FIRMA DIGITAL-->
{{-- <div style="margin-left: -20px;">
    <p class="sello">Sello de Unidad de Inspección</p>
        <div class="images-container">
            <img src="{{ $qrCodeBase64 }}" alt="QR" width="90px">
            <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Logo UI" class="image-right">
        </div>
        <p class="textx" style="font-size: 9px; margin-bottom:-8px; margin-top:-2px; position: relative;">
            <strong>AUTORIZÓ</strong>
            <span style="margin-left: 53px; display: inline-block; text-align: center; position: relative;">
           
                @php
                    use Illuminate\Support\Facades\Storage;
                    $firma = $data->firmante->firma ?? null;
                    $firmaPath = $firma ? 'firmas/' . $firma : null;
                @endphp
                @if ($firma && Storage::disk('public')->exists($firmaPath))
                    <img style="position: absolute; top: -45px; left: 170; right: 0; margin: 0 auto;" height="60px"
                        src="{{ asset('storage/' . $firmaPath) }}">
                @endif

                <strong>{{ $data->firmante->puesto ?? '' }} | {{ $data->firmante->name ?? '' }}</strong>
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
</div> --}}

@endif


@if( !$loop->last ) <!--salto de página si NO es el último lote-->
    <div style="page-break-after: always;"></div>
@endif
@endforeach


<!--FIRMA DIGITAL-->
<div style="margin-left: -20px;">
    <p class="sello">Sello de Unidad de Inspección</p>
        <div class="images-container">
            <img src="{{ $qrCodeBase64 }}" alt="QR" width="90px">
            <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Logo UI" class="image-right">
        </div>
        <p class="textx" style="font-size: 9px; margin-bottom:-8px; margin-top:-2px; position: relative;">
            <strong>AUTORIZÓ</strong>
            <span style="margin-left: 54px; display: inline-block; position: relative;">
           
                @php
                    use Illuminate\Support\Facades\Storage;
                    $firma = $data->firmante->firma ?? null;
                    $firmaPath = $firma ? 'firmas/' . $firma : null;
                @endphp
                @if ($firma && Storage::disk('public')->exists($firmaPath))
                    <img style="position: absolute; top: -35%; left: 125;" height="60px"
                        src="{{ public_path('storage/' . $firmaPath) }}">
                @endif

                <strong>{{ $data->firmante->puesto ?? '' }} | {{ $data->firmante->name ?? '' }}</strong>
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
</div> 


</body>
</html>
