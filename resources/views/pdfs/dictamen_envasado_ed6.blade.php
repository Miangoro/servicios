<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Mezcal Envasado</title>
    <style>
        body {
            font-family: 'calibri';
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

        .container {
            margin-top: 0px;
            position: relative;
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
            top: 5px;
        }

        .description2 {
            color: #151442;
            font-family: 'Arial Negrita' !important;
            font-size: 9.5px;
            top: 30px;
        }

        .description3 {
            font-size: 10px;
            top: 42px;
            margin-right: 60px;
        }

        .title {
            font-family: 'Arial Negrita', Gadget, sans-serif;
            text-align: center;
            font-size: 22px;
            line-height: 20px;
            margin-top: -20px;
        }

        .subtema {
            font-size: 17px;
            margin-top: -25px;
            margin-left: 55px;
            margin-right: 30px;
            color: #002800;
        }

        .subtema2 {
            font-size: 17px;
            margin-top: -5px;
            margin-bottom: 30px;
            margin-left: 55px;
            margin-right: 30px;
            color: #002800;
        }

        .text {
            text-align: justify;
            font-size: 15px;
            margin-top: -25px;
            margin-left: 30px;
            margin-right: 30px;
            line-height: 0.8;
        }

        .text2 {
            text-align: justify;
            font-size: 15px;
            margin-left: 30px;
            margin-right: 30px;
            margin-top: -1px;
            line-height: 0.8;
        }

        table {
            width: 93%;
            border: 2px solid #003300;
            border-collapse: collapse;
            margin: auto;
            margin-left: 30px;
            margin-top: -15px;
            font-size: 12px;
            line-height: 1;
            vertical-align: top;
        }

        td,
        th {
            border: 2px solid #003300;
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
            margin-top: 12px;
            margin-left: 30px;
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
            right: 20px;
            top: 860px;
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
            margin-left: 30px;
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

        .footer-bar p {
            margin: 0;
            line-height: 1;
        }

        .font-lucida-sans-seminegrita {
            font-family: 'Lucida Sans Seminegrita', sans-serif;
        }

        .pie {
            text-align: right;
            font-size: 9px;
            line-height: 1;
            position: fixed;
            bottom: -12;
            left: 0;
            right: 0;
            width: calc(100% - 40px);
            height: 45px;
            margin-right: 30px;
            padding: 10px 0px;
            font-family: 'Lucida Sans Unicode';
        }

        .column {
            text-align: center;
            font-family: 'lucida sans seminegrita';
        }

        .colum-title {
            font-size: 14px;
            text-align: center;
            font-family: 'calibri-bold';
        }

        .column2 {
            color: #303C4C;
            text-align: center;
            font-family: 'lucida sans seminegrita';
        }


        .textimg {
            font-weight: bold;
            position: absolute;
            top: 100px;
            left: 10px;
            text-align: left;
            font-size: 13px;
        }

        .watermark {
            color: red;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            opacity: 0.5;
            /* Opacidad predeterminada */
            letter-spacing: 3px;
            font-size: 150px;
            white-space: nowrap;
            z-index: -1;
        }
    </style>
</head>

<body>

    @if ($watermarkText)
        <div class="watermark">
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
        <div class="description3">Acreditados ante la Entidad Mexicana de Acreditación, A.C.</div>
        {{-- <div class="textimg font-lucida-sans-seminegrita">No.: UMC-00_/20</div><br> --}}

        <div class="title">Dictamen de Cumplimiento NOM de Mezcal <br> Envasado</div><br>

        <p class="text" style="margin-bottom: 20px;">La Unidad de Inspección CIDAM A.C. con domicilio en Kilómetro 8 Antigua Carretera a
            Pátzcuaro, S/N Colonia Otra no Especificada en el Catálogo, C.P. 58341, Morelia,
            Michoacán. Unidad de Verificación tipo A con acreditación No. UVNOM-129, acreditada
            por la entidad mexicana de acreditación, A.C.</p>

        <p class="subtema" >I. &nbsp;&nbsp;&nbsp;&nbsp;Datos de la empresa</p>

        <table>
            <tbody>
                <tr>
                    <td class="column">Nombre de la empresa</td>
                    <td colspan="3" style="text-align: center;">{{ $data->inspeccion?->solicitud?->empresa?->razon_social ?? 'No encontrado' }}</td>
                </tr>
                <tr>
                    <td class="column">Representante legal</td>
                    <td>{{ $data->inspeccion?->solicitud?->empresa?->representante ?? 'No encontrado' }}</td>
                    <td class="column">Número de dictamen</td>
                    <td>{{ $data->num_dictamen ?? 'No encontrado'}}</td>
                </tr>
                <tr>
                    <td class="column">Dirección</td>
                    <td> {{ $data->inspeccion?->solicitud?->empresa?->domicilio_fiscal ?? 'No encontrado'}}</td>
                    <td class="column">Fecha de emisión</td>
                    <td> {{ $fecha_emision ?? ''}}</td>
                </tr>
                <tr>
                    <td class="column">RFC</td>
                    <td> {{ $data->inspeccion?->solicitud?->empresa?->rfc ?? 'No encontrado' }}</td>
                    <td class="column">Fecha de vencimiento</td>
                    <td>{{-- {{ $fecha_vigencia ?? ''}} --}}Indefinido</td>
                </tr>
                <tr>
                    <td class="column">No. servicio</td>
                    <td>{{ $data->inspeccion?->num_servicio ?? 'No encontrado' }}</td>
                    <td class="column">Fecha del servicio</td>
                    <td>{{ $fecha_servicio}}</td>
                </tr>
            </tbody>
        </table>

        <p class="subtema2">II. &nbsp;&nbsp;&nbsp;&nbsp;Descripción del producto</p>

        <table>
            <tbody>
                <tr>
                    <td colspan="6" class="colum-title">PRODUCTO
                        @if ($lotesGranel->isNotEmpty())
                            @foreach ($lotesGranel as $loteGranel)
                                {{ $loteGranel->categoria->categoria ?? 'No encontrado' }}
                                <!-- Añade una separación si es necesario -->
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            --
                        @endif
                        <br> ORIGEN
                        {{ $data->inspeccion->solicitud->instalacion->estados->nombre ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td class="column2">Categoría y clase</td>
                    <td>
                        @if ($lotesGranel->isNotEmpty())
                            @foreach ($lotesGranel as $loteGranel)
                                <!-- Mostrar la categoría y la clase -->
                                {{ $loteGranel->categoria->categoria ?? 'N/A' }},
                                {{ $loteGranel->clase->clase ?? 'N/A' }}

                                <!-- Añade una separación si hay más elementos en el loop -->
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>{{-- aun no se de donde se jala --}}
                    <td rowspan="2" class="column2">No. de lote envasado</td>
                    <td rowspan="2">{{ $data->lote_envasado->nombre ?? 'No encontrado' }}</td>
                    <td rowspan="2" class="column2">No. de botellas</td>
                    <td rowspan="2">{{ $data->lote_envasado->cant_botellas ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="column2">Ingredientes</td>
                    <td>
                        @if ($lotesGranel->isNotEmpty())
                            @foreach ($lotesGranel as $loteGranel)
                                {{ !empty($loteGranel->ingredientes) ? $loteGranel->ingredientes : '----' }}
                                <!-- Añade una separación si deseas entre los nombres de lotes -->
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="column2">Edad</td>
                    <td>
                        @if ($lotesGranel->isNotEmpty())
                            @foreach ($lotesGranel as $loteGranel)
                                {{ !empty($loteGranel->edad) ? $loteGranel->edad : '----' }}
                                <!-- Añade una separación si deseas entre los nombres de lotes -->
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="column2">No. de lote a granel</td>
                    <td>
                        @if ($lotesGranel->isNotEmpty())
                            @foreach ($lotesGranel as $loteGranel)
                                {{ $loteGranel->nombre_lote ?? '' }}
                                <!-- Añade una separación si deseas entre los nombres de lotes -->
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="column2">No. de análisis</td>
                    <td>
                        @if ($lotesGranel->isNotEmpty())
                            @foreach ($lotesGranel as $loteGranel)
                                {{ $loteGranel->folio_fq ?? ''}}
                                <!-- Añade una separación si deseas entre los nombres de lotes -->
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>{{-- no se de donde se jala --}}
                </tr>
                <tr>
                    <td class="column2">Presentación</td>
                    <td>{{ $data->lote_envasado->presentacion ?? 'No encontrado' }}</td>
                    <td class="column2">Volumen del lote</td>

                    <td>
                        {{ $data->lote_envasado->volumen_total ?? 'No encontrado' }} L
                    </td> {{-- no se de donde se jala --}}
                    <td class="column2">Contenido alcohólico</td>
                    <td>
                        @if ($lotesGranel->isNotEmpty())
                            @foreach ($lotesGranel as $loteGranel)
                                {{ $loteGranel->cont_alc ?? '' }}
                                <!-- Añade una separación si deseas entre los nombres de lotes -->
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            N/A
                        @endif % Alc. Vol.
                    </td> {{-- no se de donde se jala --}}
                </tr>
                <tr>
                    <td class="column2">Tipo de maguey</td>
                    <td colspan="2">
                    @if ($lotesGranel->isNotEmpty())
                        @foreach ($lotesGranel as $loteGranel)
                            @php
                                $tipos = $loteGranel->tiposRelacionados ?? collect();
                            @endphp
                
                            @if ($tipos->isNotEmpty())
                                @foreach ($tipos as $tipo)
                                    {{ $tipo->nombre }} <i>({{ $tipo->cientifico }})</i>@if (!$loop->last), @endif
                                @endforeach
                            @else
                                No encontrado
                            @endif
                
                            @if (!$loop->last)
                             ,
                            @endif
                        @endforeach
                    @else
                        N/A
                    @endif
                    </td>
                    <td class="column2">Marca</td>
                    <td colspan="2">{{ $marca->marca ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <p class="text2">Este dictamen de cumplimiento de lote de mezcal envasado se expide de acuerdo a la
            Norma Oficial Mexicana NOM-070-SCFI-2016. Bebidas alcohólicas -mezcal-
            especificaciones.</p>


<!--FIRMA DIGITAL-->
<div style="margin-left: -5px;">
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
                        {{-- src="{{ asset('storage/' . $firmaPath) }}"> --}}
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

    <div class="footer-bar">
        <p class="font-lucida-sans-seminegrita">www.cidam.org . unidadverificacion@cidam.org</p>
        <p>Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341.
            Morelia Michoacán</p>
    </div> 

    <p class="pie">Entrada en vigor: 15-07-2024<br>
        F-UV-04-17 Ver 6.
    </p>
    
</div>




</body>
</html>
