<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora de revisión de certificados de Instalaciones NOM-070-SCFI-2016 F7.1-01-40 </title>
    <style>
        body {
            font-weight: 12px;
        }

        @page {
            margin-left: 70px;
            margin-right: 70px;
            margin-top: 40px;
            margin-bottom: 10px;

        }

        @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        .negrita {

            font-family: 'Century Gothic Negrita';
        }


        .header {
            font-family: 'Century Gothic';
            text-align: right;
            font-size: 12px;
            margin-right: -30px;

        }

        .title {
            text-align: center;
            font-size: 17px;
        }

        .footer {
            position: absolute;
            transform: translate(0px, 180px);
            /* Mueve el elemento 50px en X y 50px en Y */
            text-align: center;
            font-size: 11px;
        }

        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid black;
            padding: 3px;
            font-size: 10.5px;
            text-align: center;
            font-family: 'Century Gothic';



        }

        th {
            background-color: black;
            color: white;
            text-align: center;

        }

        .td-border {
            border-bottom: none;
            border-top: none;
            border-right: 1px solid black;
            border-left: 1px solid black;

        }

        .td-no-border {
            border: none;
        }

        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }

        .letra_td {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .leftLetter {
            text-align: left;

        }

        .rightLetter {
            text-align: right;
            vertical-align: top;
            padding-bottom: 8px;
            padding-top: 0;
        }

        .no-margin-top {
            margin-top: 0;
        }

        .no-padding {
            padding: 0;
        }

        .letra-fondo {
            /* font-weight: 300; */
            font-family: 'Century Gothic negrita';
            color: black;
            font-size: 12px;
            background-color: #8eaadb;
            text-align: center;

        }

        .letra-up {
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;

        }

        .header {
            padding: 10px;
            text-align: right;
        }

        .header img {
            float: left;
            max-width: 165px;
            padding: 0;
            margin-top: -40px;
            margin-left: -30px;


        }

        /* Estilo para el texto de fondo */
        .background-text {
            font-family: 'Century Gothic';
            position: absolute;
            top: 450px;
            left: 410px;
            z-index: -1;
            color: #000000;
            font-size: 12px;
            /* line-height: 1.4; */
            white-space: nowrap;
            text-align: left;
        }

        .espacio_letras td {
            padding-top: 1px;
            padding-bottom: 1px;
        }
    </style>


    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div> Bitácora de revisión de certificados de Instalaciones NOM-070-SCFI-2016<br> F7.1-01-40 <br>Ed 6 Entrada en
            vigor 27/05/2024<br>_______________________________________________________________________________________
        </div>
    </div>
</head>

<body>
    <div class="background-text">
        Nota: Para el llenado de la bitácora colocar <br> C= Cumple, NC= No Cumple, NA= No Aplica o <br> bien una X en
        el recuadro correspondiente en <br>cada uno de los requisitos y datos que estipula <br> la bitácora.
    </div>
    <table>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="4">Razón social del cliente:</td>
            <td class="leftLetter" colspan="2">{{ $razon_social }}</td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">No. Cliente:</td>
            <td colspan="2">{{ $numero_cliente }}</td>
            <td class="letra-fondo" style="text-align: left">Fecha de revisión:</td>
            <td>{{ $fecha }}</td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">No. De certificado:</td>
            <td colspan="2">{{ $num_certificado }}</td>
            <td class="td-no-border"></td>
            <td class="td-no-border"></td>
        </tr>

    </table>
    <br>

    <table style="width: 395px" class="espacio_letras">
        <tr>
            <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 180px;">Requisitos documentales
                <br>
                para certificación
            </td>
            <td class="letra-fondo" style="width: 45px">C </td>
            <td class="letra-fondo">N/C </td>
            <td class="letra-fondo">N/A</td>
        </tr>
        @foreach ($preguntas as $pregunta)
            @if ($pregunta['id_pregunta'] >= 91 && $pregunta['id_pregunta'] <= 95)
                <tr>
                    <td style="text-align: left">{{ $pregunta['pregunta'] }}</td>
                    <td>{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }}</td>
                    <td>{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }}</td>
                    <td>{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }}</td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 180px; height: 30px">Datos del
                certificado</td>
            <td class="letra-fondo">C </td>
            <td class="letra-fondo">N/C </td>
            <td class="letra-fondo">N/A</td>
        </tr>
        @foreach ($preguntas as $pregunta)
            @if ($pregunta['id_pregunta'] >= 96 && $pregunta['id_pregunta'] <= 103)
                <tr>
                    <td style="text-align: left">{{ $pregunta['pregunta'] }}</td>
                    <td>{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }}</td>
                    <td>{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }}</td>
                    <td>{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }}</td>
                </tr>
            @endif
        @endforeach
    </table>
    <br>
    <table>
        <tr>
            <td>
                Derivado de la revisión minuciosa y con la documentación completa entregada de manera digital por
                personal del
                OC CIDAM se revisa que el certificado cumple con cada uno de los requisitos mencionados en este
                documento, por
                consiguiente, se toma la decisión para otorgar la certificación de instalaciones como comercializador.
                <div style="padding: 30px"></div>
                @php
                    use Illuminate\Support\Facades\Storage;
                    $firmaPath = $firmaRevisor ? 'firmas/' . $firmaRevisor : null;
                @endphp
                <div style="width: 100%; text-align: right; position: fixed; margin-top: -35px; right: 20px;">
                    @if ($firmaRevisor && Storage::disk('public')->exists($firmaPath))
                    <img src="{{ public_path('storage/' . $firmaPath) }}" alt="Firma" style="width: 120px; height: auto;">
                    @endif
                </div>
                {{ $id_revisor }} <br>
                {{ $puestoRevisor }}:
            </td>
        </tr>
    </table>
    <div style="margin-bottom: 15px">
        <p style="font-size: 11px; margin-top: 20px; text-align: center;  font-family: 'Century Gothic';">Este documento
            es propiedad del Centro de
            Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser <br>
            distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
    </div>

</body>

</html>
