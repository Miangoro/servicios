<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora de revisión de certificado de exportación NOM-070-SCFI-2016 F7.1-01-33</title>
    <style>
        body {
            font-weight: 12px;
            margin-top: 80px;
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
            position: fixed;
            top: 0;
            left: 0;
            right: -25px;
            height: 100px;
            /* Ajusta al tamaño real del header */
            font-family: 'Century Gothic';
            text-align: right;
            font-size: 14px;
            padding: 5px;
            z-index: 10;
        }

        .header {
            padding: 5px;
            text-align: right;
        }

        .header img {
            float: left;
            max-width: 165px;
            padding: 0;
            margin-top: -30px;
            margin-left: -50px;
        }


        .title {
            text-align: center;
            font-size: 17px;
        }

        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid black;
            padding: 5px;
            /*             padding-bottom: 6px;
            padding-top: 6px; */
            font-size: 10px;
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
            background-color: #9FC5E8;
            text-align: left;

        }

        .letra-title {
            font-family: 'Century Gothic negrita';
            color: black;
            font-size: 15px;
            background-color: #9FC5E8;
            text-align: left;
            margin-top: -10px;
            padding: 3px;

        }

        .letra-up {
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;

        }


        /* Estilo para el texto de fondo */
        .background-text {
            padding-top: -15px;
            margin-left: auto;
            margin-right: 0;
            width: 65%;
            /* o el ancho que desees */
            font-family: 'Century Gothic Negrita';
            border: #000000 1px solid;
            color: #000000;
            font-size: 12px;
            white-space: normal;
            text-align: left;
        }

        .espacio_letras td {}

        .sin-border td {
            padding-top: 10px;
            padding-bottom: 10px;
            border: none;
        }

        .td-negrita {
            font-size: 12.5px;
            color: #000000;
            text-align: left;
            padding: 0;
            padding-right: 5px;
        }

        .page-break {
            page-break-before: always;
            border-color: #000000 1px;
        }


        .footer {
            /*  position: fixed; */
            position: absolute;
            left: 0;
            bottom: 10px;
            width: 100%;
            font-size: 12px;
        }
        .background-text{
          margin-top: -13px;
          margin-bottom: 2px; /* 5 */
        }

        .recuadro_certificacion {
            width: 100%;
            border: 2px solid black;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .recuadro_certificacion td {
            font-size: 12px;
        }
    </style>


</head>

<body>

    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div>
            Bitácora de revisión de certificado de exportación NOM-070-SCFI-2016 F7.1-01-33<br>
            Ed. 6 Entrada en vigor 07/11/2023
        </div>
    </div>

    <div>
        <p class="letra-title">PRIMERA REVISIÓN POR PARTE DEL CONSEJO PARA LA DECISIÓN DE LA CERTIFICACIÓN</p>
    </div>

    <table>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="4">Razón social del cliente:</td>
            <td class="leftLetter" colspan="2">{{ $razon_social }}</td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">No. Cliente:</td>
            <td colspan="2">{{ $numero_cliente }}</td>
            <td class="letra-fondo" style="text-align: left">Fecha de primera revisión:</td>
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

    <table class="background-text">
        <tr>
            <td class="td-negrita">
                Nota: Para el llenado de la bitácora colocar {{-- <br>  --}}C= Cumple, NC= No Cumple, NA= No
                Aplica o {{-- <br> --}} bien una X en
                el recuadro correspondiente en {{-- <br> --}}cada uno de los requisitos y datos que estipula
                {{-- <br>  --}}la bitácora.
            </td>
        </tr>
    </table>
    <table style="width:100%; border: none;">
        <tr class="sin-padding">
            <td style="vertical-align: top; text-align: left; border: none;">
                <table style="display: inline-table; width: 200px;" {{-- class="espacio_letras tabla-1" --}}>
                    <!-- ...contenido de la primera tabla... -->
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Datos
                            generales del exportador
                        </td>
                        <td class="letra-fondo" style="width: 50px">C </td>
                        <td class="letra-fondo" style="width: 50px">N/C </td>
                        <td class="letra-fondo" style="width: 50px">N/A</td>
                    </tr>

                    @foreach ($preguntas as $pregunta)
                        @if ($pregunta['id_pregunta'] >= 38 && $pregunta['id_pregunta'] <= 44)
                            <tr>
                                <td style="text-align: left">{{ $pregunta['pregunta'] }}</td>
                                <td>{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }}</td>
                                <td>{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }}</td>
                                <td>{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr class="sin-border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="sin-border">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="sin-border">
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Destinatario
                        </td>
                        <td class="letra-fondo" style="width: 45px">C </td>
                        <td class="letra-fondo" style="width: 45px">N/C </td>
                        <td class="letra-fondo"style="width: 45px">N/A</td>
                    </tr>

                    @foreach ($preguntas as $pregunta)
                        @if ($pregunta['id_pregunta'] >= 45 && $pregunta['id_pregunta'] <= 47)
                            <tr>
                                <td style="text-align: left">{{ $pregunta['pregunta'] }}</td>
                                <td>{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }}</td>
                                <td>{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }}</td>
                                <td>{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                {{-- segunda tabla --}}
            </td>
            <td style="vertical-align: top; text-align: center; border: none;">
                <table style="display: inline-table; width: 300px;" {{-- class="tabla-2" --}}>
                    <!-- ...contenido de la segunda tabla... -->
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Descripción
                            del embarque que ampara el certificado
                        </td>
                        <td class="letra-fondo" style="width: 50px">C </td>
                        <td class="letra-fondo" style="width: 50px">N/C </td>
                        <td class="letra-fondo" style="width: 50px">N/A</td>
                    </tr>
                    @foreach ($preguntas as $pregunta)
                        @if ($pregunta['id_pregunta'] >= 48 && $pregunta['id_pregunta'] <= 62)
                            <tr>
                                <td style="text-align: left">{{ $pregunta['pregunta'] }}</td>
                                <td>{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }}</td>
                                <td>{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }}</td>
                                <td>{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
    </div>

    {{-- segunda pagina --}}
    <div class="page-break"></div>

    <!-- Aquí inicia la nueva maquetación para la siguiente página -->
    <div>
        <p class="letra-title">SEGUNDA REVISIÓN POR PARTE DEL CONSEJO PARA LA DECISIÓN DE LA CERTIFICACIÓN</p>
        <!-- Más contenido para la nueva página -->
    </div>

    <table style="width: 108%; border: none; ">
        <tr>
            <!-- Tabla 1 -->
            <td style="width: 80%; vertical-align: top; text-align: left; border: none;">
                <table style="width: 90%; text-align: left;">
                    <tr>
                        <td class="letra-fondo" style="height: 30px;">Revisión final de certificado </td>
                        <td class="letra-fondo">C</td>
                        <td class="letra-fondo">N/C</td>
                        <td class="letra-fondo">N/A</td>
                    </tr>
                    <tr>
                        <td class="leftLetter" style="height: 40px;"> Dictamen de cumplimiento para producto de
                            exportación</td>
                        <td class="leftLetter">C</td>
                        <td class="leftLetter">------</td>
                        <td class="leftLetter">------</td>
                    </tr>

                </table>
            </td>

            <!-- Tabla 2 -->
            <td style="width: 50%; vertical-align: top; text-align: left; border: none;">
                <table style="width: 80%; text-align: left;">
                    <tr>
                        <td class="letra-fondo">Fecha de segunda revisión</td>
                    </tr>
                    <tr>
                        <td style="height: 60px;" class="">2025-05-29</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <div class="footer">
        <table class="recuadro_certificacion">
            <tr>
                <td>
                    Derivado de la revisión minuciosa y con la documentación completa entregada de manera digital por
                    personal del OC CIDAM se revisa que el certificado cumple con cada uno de los requisitos mencionados
                    en este
                    documento, por consiguiente, se toma la decisión para otorgar la certificación de producto. <br>
                    Responsable de Revisión:
                    <div style="height: 20px;"></div>
                    @php
                        use Illuminate\Support\Facades\Storage;
                        $firmaPath = $firmaRevisor ? 'firmas/' . $firmaRevisor : null;
                    @endphp
                    <div style="width: 100%; text-align: right; position: fixed; margin-top: -30px; right: 20px;">
                        @if ($firmaRevisor && Storage::disk('public')->exists($firmaPath))
                            <img src="{{ public_path('storage/' . $firmaPath) }}" alt="Firma"
                                style="width: 120px; height: auto;">
                        @endif
                    </div>
                    <div style="height: 20px;"></div>
                    {{ $id_revisor }} <br>
                    {{ $puestoRevisor }}:
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
