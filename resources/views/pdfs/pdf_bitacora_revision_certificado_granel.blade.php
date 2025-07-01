<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora de revisión de certificado NOM a Granel NOM-070-SCFI-2016 F7.1-01-34 </title>
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
            font-size: 13px;
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
            font-size: 11px;
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
            padding-top: 15px;
            margin-left: auto;
            margin-right: 0;
            width: 60%; /* o el ancho que desees */
            font-family: 'Century Gothic';
            border: #000000 1px solid;
            color: #000000;
            font-size: 12px;
            white-space: normal;
            text-align: left;
        }

        .espacio_letras td {
            padding-top: 1px;
            padding-bottom: 1px;
        }

        .sin-border td {
            padding-top: 10px;
            padding-bottom: 10px;
            border: none;
        }
          #footer {
              position: fixed;
              left: 0;
              bottom: 0;
              width: 100%;
              font-size: 12px;
          }
          .recuadro_certificacion {
              width: 100%;
              border: 2px solid black;
              font-size: 12px;
              margin-bottom: 10px;
          }
          .td-negrita {
              font-size: 11px;
              color: #000000;
               text-align: left;
          }
    </style>


    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div> Bitácora de revisión de certificado NOM a Granel NOM-070-SCFI-2016<br> F7.1-01-34 <br>Ed 3 Entrada en
            vigor 08/11/2023<br>_______________________________________________________________________________________
        </div>
    </div>
</head>

<body>

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

    <table style="width:100%; border: none;">
        <tr class="sin-padding">
            <td style="vertical-align: top; text-align: left; border: none;">
                <table style="display: inline-table; width: 200px;" {{-- class="espacio_letras tabla-1" --}}>
                    <!-- ...contenido de la primera tabla... -->
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Datos de la
                            Empresa
                        </td>
                        <td class="letra-fondo" style="width: 50px">C </td>
                        <td class="letra-fondo" style="width: 50px">N/C </td>
                        <td class="letra-fondo" style="width: 50px">N/A</td>
                    </tr>
                    @foreach ($preguntas as $pregunta)
                        @if ($pregunta['id_pregunta'] >= 104 && $pregunta['id_pregunta'] <= 109)
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="sin-border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                {{-- segunda tabla --}}

            </td>
            <td style="vertical-align: top; text-align: center; border: none;">
                <table style="display: inline-table; width: 300px;" {{-- class="tabla-2" --}}>
                    <!-- ...contenido de la segunda tabla... -->
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Descripción
                            del producto</td>
                        <td class="letra-fondo" style="width: 50px">C </td>
                        <td class="letra-fondo" style="width: 50px">N/C </td>
                        <td class="letra-fondo" style="width: 50px">N/A</td>
                    </tr>
                     @foreach ($preguntas as $pregunta)
                        @if ($pregunta['id_pregunta'] >= 114 && $pregunta['id_pregunta'] <= 123)
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

    <table style="display: inline-table; width: 300px;" class="espacio_letras tabla-1">

        <tr>
            <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Descripción del producto
            </td>
            <td class="letra-fondo" style="width: 45px">C </td>
            <td class="letra-fondo" style="width: 45px">N/C </td>
            <td class="letra-fondo"style="width: 45px">N/A</td>
        </tr>

        @foreach ($preguntas as $pregunta)
                        @if ($pregunta['id_pregunta'] >= 110 && $pregunta['id_pregunta'] <= 113)
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

      <table class="background-text">
        <tr>
          <td class="td-negrita">
        Nota: Para el llenado de la bitácora colocar {{-- <br>  --}}C= Cumple, NC= No Cumple, NA= No Aplica o {{-- <br> --}} bien una X en
        el recuadro correspondiente en {{-- <br> --}}cada uno de los requisitos y datos que estipula {{-- <br>  --}}la bitácora.
          </td>
        </tr>
      </table>

    <br>
   <div id="footer">
<table class="recuadro_certificacion">
    <tr>
        <td>
            Derivado de la revisión minuciosa y con la documentación completa entregada de manera digital por
            personal del OC CIDAM se revisa que el certificado cumple con cada uno de los requisitos mencionados en este
            documento, por consiguiente, se toma la decisión para otorgar la certificación de producto.
            <div style="height: 20px;"></div>
            @php
                use Illuminate\Support\Facades\Storage;
                $firmaPath = $firmaRevisor ? 'firmas/' . $firmaRevisor : null;
            @endphp
            <div style="width: 100%; text-align: right; position: fixed; margin-top: -30px; right: 20px;">
                @if ($firmaRevisor && Storage::disk('public')->exists($firmaPath))
                    <img src="{{ public_path('storage/' . $firmaPath) }}" alt="Firma" style="width: 120px; height: auto;">
                    @endif
            </div>
            <div style="height: 20px;"></div>
            {{ $id_revisor }} <br>
                {{ $puestoRevisor }}:
        </td>
    </tr>
</table>
    <p style="font-size: 11px; margin-top: 10px; text-align: center; font-family: 'Century Gothic';">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser <br>
        distribuido externamente sin la autorización escrita del Director Ejecutivo.
    </p>
</div>
</body>

</html>
