<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora de revisión documental y aprobación por el personal del OC CIDAM</title>
    <style>
        body {
            
        }

        @page {
            margin-left: 55px;
            margin-right: 55px;
            margin-top: 40px;
            margin-bottom: 10px;

        }

        /*   @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

       @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }*/

        .negrita {

            font-family: 'Century Gothic Negrita';
        }


        .header {
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
            padding: 4px;
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
        }

        .no-margin-top {
            margin-top: 0;
        }

        .no-padding {
            padding: 0;
        }

        .letra-fondo {
            color: black;
            font-size: 11.5px;
            background-color: #8cb2ee;
            text-align: center;

        }

        .letra-fondoOPcional {
            color: black;
            font-size: 11.5px;
            background-color: #c8daf8;
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
            font-family: 'Century Gothic';
            font-size: 12px;
        }

        .header img {
            float: left;
            max-width: 165px;
            padding: 0;
            margin-top: -20px;
            margin-left: -30px;


        }

        /* Estilo para el texto de fondo */
        .background-text {
            position: absolute;
            top: 248px;
            left: 365px;
            z-index: -1;
            color: #000000;
            font-size: 14px;
            line-height: 1.4;
            white-space: nowrap;
            text-align: left;
        }
    </style>


    
</head>


<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div style="margin-right: 25px"> Bitácora de revisión documental y aprobación por el personal
            del OC CIDAM <br>NOM-070-SCFI-2016
            <br>F7.1-01-49 Ed. 6 <br>Entrada en vigor 27/06/2024
        </div>

    </div>
    <div style="margin-top: 15px" class="background-text">
            <table class="letra-fondo" style="width: 340px; table-layout: fixed; border-collapse: collapse;">
            <tr>
                <td class="negrita" style="font-size: 9px; padding: 10px" colspan="4">REVISIÓN CERTIFICADO {{ $tipo_certificado }}</td>
            </tr>
            <tr>
                <td class="negrita" style="font-size: 8px; width: 60%;">DOCUMENTO</td>
                <td class="negrita" style="font-size: 8px">C</td>
                <td class="negrita" style="font-size: 8px">N/C</td>
                <td class="negrita" style="font-size: 8px">N/A</td>
            </tr>
        </table>
        <br>
        <table style="width: 340px; table-layout: fixed; border-collapse: collapse;">
            
            @foreach ($preguntas as $pregunta)
            @if ($pregunta['id_pregunta'] > 5 && !($pregunta['id_pregunta'] >= 18 && $pregunta['id_pregunta'] <= 22) && !($pregunta['id_pregunta'] >= 63 && $pregunta['id_pregunta'] <= 67) && !($pregunta['id_pregunta'] >= 85 && $pregunta['id_pregunta'] <= 90))
                    <tr>
                        <td class="leftLetter" style="font-size: 8.5px; width: 60%;   white-space: normal;;">{{ $pregunta['pregunta'] }}</td>
                        <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }} </td>
                        <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }} </td>
                        <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }} </td>
                    </tr>
                @endif
            @endforeach

        </table>
    </div>

    <table>
        <tr>
            <td class="letra-fondo negrita " style="text-align: right; padding-top: 0; padding-bottom: 0">RAZON SOCIAL O
                NOMBRE DEL CLIENTE:</td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $razon_social }}</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita " style="text-align: right; padding-top: 0; padding-bottom: 0">NO. CLIENTE:
            </td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $numero_cliente }}</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita" style="text-align: right; padding-top: 0; padding-bottom: 0">NO. DE
                CERTIFICADO:</td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $num_certificado }}</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita " style="text-align: right; padding-top: 0; padding-bottom: 0">TIPO DE
                CERTIFICADO:</td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $tipo_certificado }}</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td class="td-no-border" style="width: 358px;padding-top: 0; padding-bottom: 0"></td>
            <td class="leftLetter" style="padding-top: 0; padding-bottom: 0; font-size: 9.5px">C= Cumple, NC= No Cumple, NA= No Aplica &nbsp;</td>
            <td class="td-no-border" style="width: 0px;padding-top: 0; padding-bottom: 0"></td>
        </tr>
    </table>
    <div style="height: 7px"></div>
    <table style="width: 340px">
        <tr>
            <td class="letra-fondo negrita" colspan="4" style="font-size: 9px">REVISIÓN DOCUMENTAL PARA LA TOMA DE
                DECISIÓN PARA LA <br>
                CERTIFICACIÓN DE CERTIFICADOS DE GRANEL, EXPORTACIÓN, <br>
                NACIONAL Y/O INSTALACIONES.<br>
        </tr>

        <tr>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">DOCUMENTO</td>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">C</td>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">N/C</td>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">N/A</td>
        </tr>
        @foreach ($preguntas as $pregunta)
            @if (($pregunta['id_pregunta'] >= 1 && $pregunta['id_pregunta'] <= 5) || $pregunta['id_pregunta'] >= 18 && $pregunta['id_pregunta'] <= 22 || $pregunta['id_pregunta'] >= 63 && $pregunta['id_pregunta'] <= 67) 
                <tr>
                    <td style="padding-top: 0; padding-bottom: 0; font-size: 8.5px;text-align: left">
                        {{ $pregunta['pregunta'] }}</td>
                    <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }} </td>
                    <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }} </td>
                    <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }} </td>
                </tr>
            @endif
        @endforeach



    </table>
    <br>
    <table style="width: 340px">
        <tr>
            <td style="background-color: #FFE598; text-align: left; font-size: 9.4px;padding-top: 0; padding-bottom: 0; line-height: 0.9">
                <div> <span class="negrita"> NOTA:</span> Resaltar el recuadro correspondiente para la toma de la <br>
                    decisión para la certificación. Si la decisión es negativa explicar el <br>
                    motivo por el cuál no es apto pasar al Consejo para la Decisión de <br>
                    la Certificación para poder emitir el certificado. <br>
                    <span class="negrita">*Cancelar los recuadros que no sean utilizados*.</span>
                </div>
            </td>
        </tr>
    </table>
    <br>

    <!-- Tabla decision -->
    <table style="width: 340px">
        <tr>
            <td class="letra-fondo negrita" style="font-size: 10.5px; padding-top: 0" colspan="2">
                TOMA DE DECISIÓN PARA LA CERTIFICACIÓN POR PARTE DEL PERSONAL DEL OC CIDAM
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 8px; padding: 0">
                Derivado de la revisión minuciosa y con la documentación completa entregada de manera digital y/o física
                por el cliente, el personal del OC CIDAM determina que:
            </td>
        </tr>
        <tr>
            <td
                style="background-color: {{ $decision == 'positiva' ? '#b6d7a7' : 'white' }}; font-size: 10px; padding-top: 0; vertical-align: top; width: 50%; text-align: center;">
                SI
            </td>
            <td
                style="background-color: {{ $decision == 'negativa' ? '#b6d7a7' : 'white' }}; font-size: 10px; padding-top: 0; vertical-align: top; width: 50%; text-align: center;">
                NO
            </td>
        </tr>
        <tr>
            @if ($decision === 'positiva')
                <!-- Si la decisión es "SI", la celda de "SI" tiene contenido y la de "NO" está vacía -->
                <td class="leftLetter"
                    style="background-color: #b6d7a7; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: justify;">
                    Cumple con cada uno de los requisitos mencionados en este documento para poder
                    turnarse a uno de los miembros del Consejo para la decisión de la Certificación y decidan
                    otorgar o denegar la certificación de (producto Y/O instalaciones, según corresponda) y así
                    emitir el certificado correspondiente.
                </td>
                <td
                    style="color: red; background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                    ------
                </td>
            @elseif($decision === 'negativa')
                <!-- Si la decisión es "NO", la celda de "NO" tiene contenido y la de "SI" está vacía -->
                <td class="leftLetter"
                    style="background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                    ------
                </td>
                <td
                    style="color: red; background-color: #b6d7a7; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: justify;">
                    No cumple con cada uno de los requisitos mencionados en este documento para poder
                    turnarse a uno de los miembros del Consejo para la decisión de la Certificación y decidan
                    otorgar o denegar la certificación de (producto Y/O instalaciones, según corresponda) y así
                    emitir el certificado correspondiente.
                </td>
            @else
                <!-- Si no hay decisión, dejar ambas celdas con "---" -->
                <td class="leftLetter"
                    style="background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center; height: 100px;">
                    ------
                </td>
                <td
                    style="color: red; background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                    ------
                </td>
            @endif
        </tr>
    </table>
    <!-- end -->

    <br>

    <table style="width: 340px">
        <tr>
            <td class="letra-fondo negrita" colspan="2"
                style="font-size: 10.5px; padding-top: 0; vertical-align: top"> FIRMAS DE LAS PERSONAS RESPONSABLES DE
                LA TOMA DE
                DECISIÓN</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita"
                style="font-size: 10px; padding-top: 0; vertical-align: top;padding-left: 0; width: 175px">NOMBRE, FIRMA
                , FECHA Y CARGO <br>
                DE QUIEN HACE LA REVISIÓN
            </td>
            <td class="leftLetter" style="font-size: 8px;padding-top: 0"><span class="negrita">{{ $id_revisor }}</span><br>
                {{ $puestoRevisor }}<br>
                Revisión realizada el <span class="negrita">{{ $fecha }}</span> por el personal OC <span class="negrita">{{ ucfirst($decision) }}</span> <div style="padding-top: 10px"></div>
            </td>
        </tr>
        <tr>
            <td class="letra-fondo negrita"
                style="font-size:10px; padding-top: 0; vertical-align: top; padding-left: 0">NOMBRE, FIRMA , FECHA Y
                CARGO <br>
    
                @php
                    use Illuminate\Support\Facades\Storage;
                    $firmaPath = $firmaRevisor ? 'firmas/' . $firmaRevisor : null;
                @endphp
                @if ($firmaRevisor && Storage::disk('public')->exists($firmaPath))
                    <img style="position: absolute; top: 830px; left: 165; right: 0; margin: 0 auto;" height="50px"
                        src="{{ public_path('storage/' . $firmaPath) }}">
                @endif
                DE QUIEN TOMA LA APROBACIÓN</td>
            <td class="leftLetter" style="font-size: 8px;padding-top: 0"><span class="negrita">{{ $id_aprobador === 'Sin asignar' ? 'Q.F.B. Mayra Gutierrez Romero' : $id_aprobador }}</span><br>
                Gerente Técnico del Organismo <br>
                Certificador de CIDAM <br>
                <span class="negrita">{{ $fecha_aprobacion === 'N/A' ? $fecha : $fecha_aprobacion }}<div style="padding-top: 20px"></span></div>
                <img style="position: absolute; top: 900px; left: 140; right: 0; margin: 0 auto;" height="50px"
                        src="{{ public_path('storage/firmas/firma_Q.F.B._Mayra_Gutiérrez_Romero_1739201715.png') }}">
            </td>
        </tr>
    </table>
    @if($numero_revision == 2)
    <div style="page-break-before: always;"></div>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div style="margin-right: 25px"> Bitácora de revisión documental y aprobación por el personal
            del OC CIDAM <br>NOM-070-SCFI-2016
            <br>F7.1-01-49 Ed. 6 <br>Entrada en vigor 27/06/2024
        </div>

    </div>

    <div style="font-family: 'Century Gothic'; border: solid 2px; font-size: 10px; margin-bottom: 10px; text-align: left; padding: 3px" class="letra-fondoOPcional">
    <span class="negrita">INSTRUCCIONES DE LLENADO PARA SEGUNDA REVISIÓN SOLO EN EXPORTACIÓN:</span><br>
    En las siguientes tablas se encuentran los requisitos documentales necesarios para la segunda revisión del CERTIFICADO DE EXPORTACIÓN en su SEGUNDA REVISIÓN. Se cancelarán las tablas que no se utilicen con líneas en forma diagonal abarcando todos los campos de la tabla.
    </div>

    
   <table style="width: 340px">
        <tr>
            <td style="background-color: #FFE598; text-align: left; font-size: 9.4px;padding-top: 0; padding-bottom: 0; line-height: 0.9">
                <div> <span class="negrita"> NOTA:</span> Resaltar el recuadro correspondiente para la toma de la <br>
                    decisión para la certificación. Si la decisión es negativa explicar el <br>
                    motivo por el cuál no es apto pasar al Consejo para la Decisión de <br>
                    la Certificación para poder emitir el certificado. <br>
                    <span class="negrita">*Cancelar los recuadros que no sean utilizados*.</span>
                </div>
            </td>
        </tr>
    </table>
    <br>

     <table style="width: 340px; float: left; margin-right: 10px;">
        <tr>
            <td class="letra-fondo negrita" colspan="4" style="font-size: 9px">REVISIÓN DOCUMENTAL PARA LA TOMA DE
                DECISIÓN PARA LA <br>
                CERTIFICACIÓN DE CERTIFICADOS DE GRANEL, EXPORTACIÓN, <br>
                NACIONAL Y/O INSTALACIONES.<br>
        </tr>

        <tr>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">DOCUMENTO</td>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">C</td>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">N/C</td>
            <td class="letra-fondoOPcional" style="font-size: 8.5px;">N/A</td>
        </tr>
        @foreach ($preguntas as $pregunta)
            @if (($pregunta['id_pregunta'] >= 85 && $pregunta['id_pregunta'] <= 90)) 
                <tr>
                    <td style="padding-top: 0; padding-bottom: 0; font-size: 8.5px;text-align: left">
                        {{ $pregunta['pregunta'] }}</td>
                    <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'C' ? 'C' : '------' }} </td>
                    <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'NC' ? 'NC' : '------' }} </td>
                    <td style="font-size: 9.5px">{{ $pregunta['respuesta'] == 'NA' ? 'NA' : '------' }} </td>
                </tr>
            @endif
        @endforeach



    </table>

    <!-- Tabla decision -->
   <table style="width: 340px; float: left; margin-right: 10px;">
        <tr>
            <td class="letra-fondo negrita" style="font-size: 10.5px; padding-top: 0" colspan="2">
                TOMA DE DECISIÓN PARA LA CERTIFICACIÓN POR PARTE DEL PERSONAL DEL OC CIDAM
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 8px; padding: 0">
                Derivado de la revisión minuciosa y con la documentación completa entregada de manera digital y/o física
                por el cliente, el personal del OC CIDAM determina que:
            </td>
        </tr>
        <tr>
            <td
                style="background-color: {{ $decision == 'positiva' ? '#b6d7a7' : 'white' }}; font-size: 10px; padding-top: 0; vertical-align: top; width: 50%; text-align: center;">
                SI
            </td>
            <td
                style="background-color: {{ $decision == 'negativa' ? '#b6d7a7' : 'white' }}; font-size: 10px; padding-top: 0; vertical-align: top; width: 50%; text-align: center;">
                NO
            </td>
        </tr>
        <tr>
            @if ($decision === 'positiva')
                <!-- Si la decisión es "SI", la celda de "SI" tiene contenido y la de "NO" está vacía -->
                <td class="leftLetter"
                    style="background-color: #b6d7a7; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: justify;">
                    Cumple con cada uno de los requisitos mencionados en este documento para poder
                    turnarse a uno de los miembros del Consejo para la decisión de la Certificación y decidan
                    otorgar o denegar la certificación de (producto Y/O instalaciones, según corresponda) y así
                    emitir el certificado correspondiente.
                </td>
                <td
                    style="color: red; background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                    ------
                </td>
            @elseif($decision === 'negativa')
                <!-- Si la decisión es "NO", la celda de "NO" tiene contenido y la de "SI" está vacía -->
                <td class="leftLetter"
                    style="background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                    ------
                </td>
                <td
                    style="color: red; background-color: #b6d7a7; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: justify;">
                    No cumple con cada uno de los requisitos mencionados en este documento para poder
                    turnarse a uno de los miembros del Consejo para la decisión de la Certificación y decidan
                    otorgar o denegar la certificación de (producto Y/O instalaciones, según corresponda) y así
                    emitir el certificado correspondiente.
                </td>
            @else
                <!-- Si no hay decisión, dejar ambas celdas con "---" -->
                <td class="leftLetter"
                    style="background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center; height: 100px;">
                    ------
                </td>
                <td
                    style="color: red; background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                    ------
                </td>
            @endif
        </tr>
    </table>
    <!-- end -->

<div style="clear: both;"></div> 



  <table style="width: 340px; float: right; margin-top: -100px;">
        <tr>
            <td class="letra-fondo negrita" colspan="2"
                style="font-size: 10.5px; padding-top: 0; vertical-align: top"> FIRMAS DE LAS PERSONAS RESPONSABLES DE
                LA TOMA DE
                DECISIÓN</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita"
                style="font-size: 10px; padding-top: 0; vertical-align: top;padding-left: 0; width: 175px">NOMBRE, FIRMA
                , FECHA Y CARGO <br>
                DE QUIEN HACE LA REVISIÓN
            </td>
            <td class="leftLetter" style="font-size: 8px;padding-top: 0"><span class="negrita">{{ $id_revisor }}</span><br>
                {{ $puestoRevisor }}<br>
                Revisión realizada el <span class="negrita">{{ $fecha }}</span> por el personal OC <span class="negrita">{{ ucfirst($decision) }}</span> <div style="padding-top: 10px"></div>
            </td>
        </tr>
        <tr>
            <td class="letra-fondo negrita"
                style="font-size:10px; padding-top: 0; vertical-align: top; padding-left: 0">NOMBRE, FIRMA , FECHA Y
                CARGO <br>
    
        
                @if ($firmaRevisor && Storage::disk('public')->exists($firmaPath))
                    <img style="position: absolute; top: 480px; left: 165; right: 0; margin: 0 auto;" height="50px"
                        src="{{ public_path('storage/' . $firmaPath) }}">
                @endif
                DE QUIEN TOMA LA APROBACIÓN</td>
            <td class="leftLetter" style="font-size: 8px;padding-top: 0"><span class="negrita">{{ $id_aprobador === 'Sin asignar' ? 'Q.F.B. Mayra Gutierrez Romero' : $id_aprobador }}</span><br>
                Gerente Técnico del Organismo <br>
                Certificador de CIDAM <br>
                <span class="negrita">{{ $fecha_aprobacion === 'N/A' ? $fecha : $fecha_aprobacion }}<div style="padding-top: 20px"></span></div>
                <img style="position: absolute; top: 425; left: 140; right: 0; margin: 0 auto;" height="50px"
                        src="{{ public_path('storage/firmas/firma_Q.F.B._Mayra_Gutiérrez_Romero_1739201715.png') }}">
            </td>
        </tr>
    </table>
    @endif

</body>
