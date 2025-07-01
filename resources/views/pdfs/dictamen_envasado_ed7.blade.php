<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Mezcal Envasado</title>
    <style>
    @page {
        size: 227mm 292mm;/*Tamaño carta*/
    }
    @font-face {
        font-family: 'fuenteNegrita';
        src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
    }

    body {
        margin-top: 9%;
        font-family: 'calibri';
        margin-left: 15px;
        margin-right: 20px;
        font-size: 13px;
    }

    .title {
        font-family: 'Arial Negrita', Gadget, sans-serif;
        text-align: center;
        font-size: 22px;
    }

    .text {
        margin-top: 1px; 
        text-align: justify;
        font-size: 16px;
        line-height: 0.9;
    }

    .subtema {
        font-size: 14px;
        margin-top: -7px; 
        margin-left: 0px;
        margin-right: 30px;
        color: #002800;
        font-family: 'Arial Negrita'
    }

    .subtema2 {
        margin-top: 12px;
        font-size: 14px;
        margin-bottom: 15px;
        margin-left: 0px;
        margin-right: 30px;
        color: #002800;
        font-family: 'Arial Negrita'
    }

    /*inicia firma digital DIV*/
    .images-container {
        position: relative;
        width: 100%;
        /*vertical-align: bottom;*/
    }
    .image-right {
        position: absolute;
        width: 200px;
        right: 10px;
        margin-top: -5px;
    }
    .sello {
        position: absolute;
        right: 5%;
        margin-top: -13px;
        font-size: 11px;
        font-family: 'Arial Negrita' !important;
    }
    .textx {
        line-height: 0.5;
        font-size: 9px;
        font-family: Arial, Helvetica, Verdana;
    }
    .textsello {
        width: 85%; 
        text-align: left;
        word-wrap: break-word;
        margin-top: -5px;
        line-height: 1.2;
        font-size: 8px;
        font-family: Arial, Helvetica, Verdana;
    }

    .pie {
        position: fixed;
        right: 12px;
        bottom: 4px;
        text-align: right;
        line-height: 0.9;
        font-family: 'Lucida Sans Unicode';
        font-size: 9px;
    }

    
        .text2 {
            text-align: justify;
            font-size: 15px;
            margin-left: 5px;
            margin-right: 80px;
            margin-top: -1px;
            line-height: 0.8;
        }

        table {
            width: 93%;
            border: 2px solid #003300;
            border-collapse: collapse;
            margin: auto;
            margin-left: 0px;
            margin-top: -15px;
            line-height: 1;
            vertical-align: top;
        }

        td, th {
            border: 2px solid #003300;
            padding: 3px;
            vertical-align: top;
            word-wrap: break-word;
            text-align: center;
            vertical-align: middle;
        }

        td {
            width: 50%;
        }

        .column {
            text-align: center;
            font-family: 'lucida sans seminegrita';
            color: #003366;
        }

        .colum-title {
            font-size: 12px;
            text-align: center;
            font-family: 'Calibri', sans-serif;
            font-weight: normal; 
        }

        .column2 {
            color: #003366;
            text-align: center;
            font-family: 'lucida sans seminegrita';
        }

        .primera-tabla {
            border: 2px solid #1e6364;
            width: 100% !important;
        }

        .primera-tabla td, .primera-tabla th {
            border: 2px solid #1e6364; 
        }
        .segunda-tabla {
            width: 100% !important;
            max-width: none;
            margin-left: 0;
            margin-right:0;
        }

        
    /*inicia header DIV*/
    .header {
        position: fixed;
        width: 100%;
        top: -12px;
    }
    .header-text {
        color: #151442;
        display: inline-block;
        text-align: center;
        margin-left: 16%;
    }
    .header-text p {
        margin: 5px;
    }

    .large-text {
        font-size: 16px;
        font-family: 'Arial Negrita', Gadget, sans-serif;
        line-height: 0.8;
    }
    .small-text {
        font-size: 11px;
        font-family: 'Arial Negrita', Gadget, sans-serif;
        line-height: 0.8;
    }
    .normal-text {
        font-family: sans-serif;
        font-size: 11px;
    }

    .footer {
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
    .footer p {
        margin: 0;
        line-height: 1;
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

<div class="header">
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="width: 255px; height: 95px; padding-left:6px" alt="Logo CIDAM">
    <div class="header-text">
        <p class="large-text">Unidad de Inspección<br>No. UVNOM-129</p>
        <p class="small-text">Centro de Innovación y Desarrollo Agroalimentario de<br>Michoacán, A.C.</p>
        <p class="normal-text">Acreditados ante la Entidad Mexicana de Acreditación, A.C.</p>
    </div>
</div>

<div class="footer">
    <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
    <p style="font-family: Lucida Sans Unicode; font-size: 10px;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341.
        Morelia Michoacán</p>
</div> 



    <div class="title">Dictamen de Cumplimiento NOM de Mezcal Envasado </div>
    <p class="text"> La Unidad de Inspección CIDAMA.C. con domicilio en Kilómetro 8 Antigua Carretera a Pátzcuaro,
     S/N Colonia Otra no Especificada en el Catálogo, C.P. 58341, Morelia, Michoacán. Unidad de Inspección tipo A.</p>

    <p class="subtema" >I. &nbsp;&nbsp;&nbsp;&nbsp;Datos de la empresa</p>

<table class="primera-tabla" style=" text-align: center; ">
    <tbody>
        <tr>
            <td class="column" style="width: 20%; vertical-align: middle;">Nombre de la empresa</td>
            <td colspan="3" style="width: 80%; vertical-align: middle;">{{ $data->inspeccion?->solicitud?->empresa?->razon_social ?? 'No encontrado' }}</td>
        </tr>
        <tr>
            <td class="column" style="width: 20%; vertical-align: middle;">Representante legal</td>
            <td style="width: 39%; vertical-align: middle;">{{ $data->inspeccion?->solicitud?->empresa?->representante ?? 'No encontrado' }}</td>
            <td class="column" style="width: 16%; vertical-align: middle;">Número de dictamen</td>
            <td style="width: 25%; vertical-align: middle;">{{ $data->num_dictamen ?? 'No encontrado' }}</td>
        </tr>
        <tr>
            <td class="column" style="width: 20%; vertical-align: middle; ">Dirección</td>
            <td style="width: 39%; vertical-align: middle; text-align: justify; line-height: 0.8;">
                <span style="font-family: fuenteNegrita; font-size: 11px;">Domicilio Fiscal:</span> {{ $data->inspeccion?->solicitud?->empresa?->domicilio_fiscal ?? 'No encontrado' }}
                <br><span style="font-family: fuenteNegrita; font-size: 11px;">Domicilio de Instalaciones:</span> {{ $data->inspeccion?->solicitud?->instalacion?->direccion_completa ?? 'No encontrado' }}
            </td>
            <td class="column" style="width: 16%; vertical-align: middle;">Fecha de emisión</td>
            <td style="width: 25%; vertical-align: middle;">{{ $fecha_emision ?? '' }}</td>
        </tr>
        <tr>
            <td class="column" style="width: 20%; vertical-align: middle;">RFC</td>
            <td style="width: 39%; vertical-align: middle;">{{ $data->inspeccion?->solicitud?->empresa?->rfc ?? 'No encontrado' }}</td>
            <td class="column" style="width: 16%; vertical-align: middle;">Fecha de vencimiento</td>
            <td style="width: 25%; vertical-align: middle;">{{-- {{ $fecha_vigencia ?? '' }} --}}Indefinido</td>
        </tr>
        <tr>
            <td class="column" style="width: 20%; vertical-align: middle;">No. servicio</td>
            <td style="width: 39%; vertical-align: middle;">{{ $data->inspeccion?->num_servicio ?? 'No encontrado' }}</td>
            <td class="column" style="width: 16%; vertical-align: middle;">Fecha del servicio</td>
            <td style="width: 25%; vertical-align: middle;">{{ $fecha_servicio }}</td>
        </tr>
    </tbody>
</table>

    <p class="subtema2">II. &nbsp;&nbsp;&nbsp;&nbsp;Descripción del producto</p>

<table class="segunda-tabla">
    <tbody>
        <tr>
            <td colspan="8" class="colum-title"><strong>PRODUCTO:</strong>
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ strtoupper($loteGranel->categoria->categoria ?? 'No encontrado') }}
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    --
                @endif
                <br><strong>ORIGEN:</strong> 
                {{ strtoupper($data->inspeccion->solicitud->instalacion->estados->nombre ?? 'N/A') }}
            </td>
        </tr>
        <tr>
            <td class="column2">No. de Certificado NOM a Granel</td>
            <td>{{-- {{ $data->certificado_nom_granel ?? 'N/A' }} --}}
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ $loteGranel->folio_certificado ?? 'N/A' }}
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td class="column2">No. de Lote a Granel</td>
            <td>
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ $loteGranel->nombre_lote ?? 'N/A' }}
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td class="column2">No. de Análisis</td>
            <td>
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ $loteGranel->folio_fq ?? 'N/A' }}
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td class="column2">Contenido Alcohólico</td>
            <td>
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ $loteGranel->cont_alc ?? 'N/A' }}% Alc. Vol.
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </td>
        </tr>
      <tr>
            <td class="column2" style="text-align: center; height: 30px; padding: 3px; line-height: 1;">Categoría y Clase</td>
            <td style="text-align: center; font-size: 12px;">
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ $loteGranel->categoria->categoria ?? 'N/A' }},
                        {{ $loteGranel->clase->clase ?? 'N/A' }}
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td rowspan="2" class="column2" style="text-align: center; vertical-align: middle;">No. de Lote Envasado</td>
            <td rowspan="2" style="text-align: center; vertical-align: middle;">{{ $data->lote_envasado->nombre ?? 'No encontrado' }}</td>
            <td rowspan="2" class="column2" style="text-align: center; vertical-align: middle;">No. de Botellas</td>
            <td rowspan="2" style="text-align: center; vertical-align: middle;">{{ $data->lote_envasado->cant_botellas ?? 'N/A' }}</td>
            <td rowspan="2" class="column2" style="text-align: center; vertical-align: middle;">Presentación</td>
            <td rowspan="2" style="text-align: center; vertical-align: middle;">{{ $data->lote_envasado->presentacion ?? 'N/A' }} {{ $data->lote_envasado->unidad ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="column2" style="text-align: center;">Tipo de Maguey</td>
            <td style="text-align: center; font-size: 11px;">
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        @php
                            $tipos = $loteGranel->tiposRelacionados ?? collect();
                        @endphp
                        @if ($tipos->isNotEmpty())
                            @foreach ($tipos as $tipo)
                                {{ $tipo->nombre }} <i>({{ $tipo->cientifico }})</i>
                                @if (!$loop->last), @endif
                            @endforeach
                        @else
                            No encontrado
                        @endif
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
        <tr>
            <td class="column2">Ingredientes</td>
            <td>
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ !empty($loteGranel->ingredientes) ? $loteGranel->ingredientes : '----' }}
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td class="column2">Edad</td>
            <td>
                @if ($lotesGranel->isNotEmpty())
                    @foreach ($lotesGranel as $loteGranel)
                        {{ !empty($loteGranel->edad) ? $loteGranel->edad : '----' }}
                        @if (!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td class="column2">Marca</td>
            <td>{{ $marca->marca ?? 'N/A' }}</td>
            <td class="column2">Volumen del Lote Envasado</td>
            <td>
                {{ $data->lote_envasado->volumen_total ?? 'No encontrado' }} L
            </td>
        </tr>
    </tbody>
</table>


    <p class="text2">Este dictamen de cumplimiento de lote de mezcal envasado se expide de acuerdo a la
        Norma Oficial Mexicana NOM-070-SCFI-2016. Bebidas alcohólicas -mezcal-especificaciones.</p>


<!--FIRMA DIGITAL-->
<div>
    <div class="images-container">
        <img src="{{ $qrCodeBase64 }}" alt="QR" width="75px">
        <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Sello UI" class="image-right">
    </div>
    <p class="sello">Sello de Unidad de Inspección</p>
    

        @php
            use Illuminate\Support\Facades\Storage;
            $firma = $data->firmante->firma ?? null;
            $firmaPath = $firma ? 'firmas/' . $firma : null;
        @endphp

        @if ($firma && Storage::disk('public')->exists($firmaPath))
            <img style="position: absolute; margin-top: -10%; left: 45%;" height="60px"
            src="{{ public_path('storage/' . $firmaPath) }}">
        @endif

    <p class="textx" style="margin-top: -5px">
        <strong>AUTORIZÓ</strong>
        <span style="margin-left: 54px; display: inline-block; text-align: center; position: relative;">
            <strong>{{ $data->firmante->puesto ?? '' }} | {{ $data->firmante->name ?? '' }}</strong>
        </span>
    </p>
    <p class="textx">
        <strong>CADENA ORIGINAL</strong>
        <span style="margin-left: 14px;">
            <strong>{{ $firmaDigital['cadena_original'] }}</strong>
        </span>
    </p>
    <p class="textx">
        <strong>SELLO DIGITAL</strong>
    </p>
    <p class="textsello">
        {{ $firmaDigital['firma'] }}
    </p>
</div>

    
    <p class="pie">
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>F-UV-04-17 Dictamen de Cumplimiento NOM de Mezcal Envasado Ed. 7
        <br>Entrada en vigor: 10-12-2024
    </p>


</body>
</html>
