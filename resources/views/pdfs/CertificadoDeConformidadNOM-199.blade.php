<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de conformidad NOM-199-SCFI-2017</title>
    <style>
        body {
            font-weight: 12px;
        }

        @page {
            margin-left: 80px;
            margin-right: 80px;
            margin-top: 40px;
            margin-bottom: 10px;

        }

/*         @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }
*/
        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        @font-face {
            font-family: 'Cambria';
            src: url('fonts/Cambria.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Cambria Negrita';
            src: url('fonts/cambria-bold.ttf') format('truetype');
        }




        body {
            font-family: 'Century Gothic', sans-serif;
            font-size: 10px;

        }

        .negrita {
            color: #cb8f2b;
            font-size: 14px;
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


        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid #cb8f2b;
            padding: 4px;
            font-size: 11px;
            text-align: center;
            font-family: 'Cambria';



        }

        th {
            background-color: black;
            color: white;
            text-align: center;

        }

        .td-border {
            border-bottom: 3px solid #cb8f2b;
            border-top: none;
            border-right: 3px solid #cb8f2b;
            border-left: 3px solid #cb8f2b;

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

        .no-padding-up-down {
            padding-top: 0;
            padding-bottom: 0;
        }


        .no-padding-r-l {
            padding-right: 0;
            padding-left: 0;
        }

        .letra-fondo {
            color: white;
            font-size: 12px;
            background-color: #028457;
            text-align: center;
            font-family: 'Century Gothic Negrita';


        }

        .letra-up {
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;

        }

        .header {
            padding: 10px;
            text-align: center;
            font-size: 10px;
        }

        .header img {
            max-width: 300px;
            padding: 0;
            margin-top: -30px;

        }

        .img-background {
            position: absolute;
            top: 567px;
            left: -80px;
            width: 820px;
            height: 450px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/membretado_certificado_199.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .page-break {
            page-break-before: always;
        }

        /* Estilo para la imagen flotante a la derecha */
        /* Estilo para el texto de fondo */
        .background-img {
            position: absolute;
            top: 930px;
            left: 510px;
            z-index: -1;
            width: 180px;
            height: 75px;

        }


        .letra1 {
            color: #0c1344;
            font-size: 15px;
            font-family: 'Cambria Negrita';

        }

        .letra2 {
            color: #cb8f2b;
            font-size: 11.5px;
            font-family: 'Cambria';


        }

        .letra3 {
            color: #cb8f2b;
            font-size: 38px;
            font-family: 'Cambria Negrita';

        }
    </style>
</head>

<body>
    <div class="img-background"></div>

    <div class="header">
        <center> <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" style="padding-right: 70px"></center>
        <img src="{{ public_path('img_pdf/sello_dorado.png') }}" alt="Logo Derecho"
            style="float: right; width: 195px; margin-right: -40px; margin-top: -78px">

        <!-- Texto centrado -->
        <div style="text-align: center">
            <div>
                <span style="font-family: Century Gothic Negrita; font-size: 14px">Centro de Innovación y Desarrollo Agroalimentario de Michoacán,</span><br>
                <span class="letra2" style="line-height: 0.5; font-family: 'Cambria'">Acreditado como Organismo de Certificación de producto con número de acreditación
                    144/18 <br>
                    ante la Entidad Mexicana de Acreditación, A.C.</span>
            </div>
            <div style="height: 5px"></div>
            <div style="color:  #0c1344; font-size: 13px;">
                <span style="font-family: 'Cambria'; font-size: 15px">Otorga el siguiente:</span><br>
                <span style="font-size: 24px;font-family: 'Cambria'">CERTIFICADO DE CONFORMIDAD A:</span><br>
                <span class="letra3">XXXXXXXXX</span>
            </div>
            <div>
                <span class="letra1">RFC:</span><br>
                <span style="color: #0c1344; font-size: 14px;font-family: 'Cambria';">Domicilio</span>
            </div>
        </div>
    </div>
    <div style="height: 10px"></div>
    <body>
        <div style="color: #0c1344; text-align: left; font-size: 15.5px; line-height: 0.9;font-family: 'Cambria'">
            Por haber demostrado que cuenta con la infraestructura, equipamiento y la competencia necesaria <br>
            para realizar el proceso de producción de las bebidas:
        </div>

        <br>
        <table>
            <tr>
                <td class="negrita">Familia</td>
                <td class="negrita">Denominación <br>
                    Genérica <br>
                    (Base Alcohólica)</td>
                <td class="negrita">Sabor</td>
                <td class="negrita">Marca</td>
                <td class="negrita">Presentación</td>
            </tr>
            <tr>
                <td style="height: 100px"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <div style="height: 10px"></div>
        <div style="color: #0c1344; font-size: 14.5px; text-align: justify; line-height: 1.1; font-family: Arial, sans-serif;">
            Este certificado de conformidad de Bebidas Alcohólicas se expide de acuerdo a la Norma Oficial 
            Mexicana NOM-199-SCFI-2017, Bebidas Alcohólicas-Denominación, Especificaciones 
            Fisicoquímicas, Información Comercial y Métodos de Prueba.
        </div>
        

        <div
            style="text-align: center; font-size: 10px; color: #0c1344; margin-right: 50px; float: right; margin-right: 80px;position: absolute">
            <span style="font-size: 14px; font-family: Arial, sans-serif;">Atentamente</span> <br> <br>
            <u class="letra1" style="font-size: 11px; font-family: Arial, sans-serif;"> <b>Gerente Técnico del Organismo Certificador</b></u> <br>
            <span class="letra1" style="font-size: 11px; font-family: Arial, sans-serif;"><b>del CIDAM A.C</b></span> 
        </div>
        <div style="margin: 27px"></div>
        <div style="text-align: left; color: #0c1344; font-size: 11px;font-family: Arial, sans-serif; ">
            Número de Reporte Técnico: <br>
            Número del Certificado: <br>
            Vigencia del Certificado: <br>
            Fecha de Actualización: <br>
        </div>
        <div style="height: 20px"></div>
        <div style="color: #0c1344; font-size: 14.5px; text-align: justify; line-height: 0.9;  font-family: Arial, sans-serif;">
            Este certificado está sujeto a vigilancias y mantendrá validez en tanto se conserven las mismas
            condiciones bajo las que fue otorgado y ampara únicamente el domicilio de producción, envasado
            y comercialización que se indica en el anexo. <br>
        </div>
        <div style="text-align: center; font-size: 10.5px; color: #0c1344; font-family: Arial, sans-serif;">*Este certificado no puede ser reproducido de
            manera parcial.
        </div>
        <footer style="color: white;position: absolute; bottom: 60px; width: 100%; font-size: 8.5px; line-height: 0.9">
            <div style="float: left;">
                <span style="color: black">Pag.1-2</span>
                <br>&nbsp;
                <br>&nbsp;
                <br>&nbsp;
                Cancela y sustituye al Certificado con clave:
            </div>
            <div style="float: right;">
                Kilometro 8. Antigua carretera a Pátzcuaro, S/N. Col. Otra no especificada <br>
                en el catálogo. C.P. 58341. Morelia, Michoacán. <br>
                F7.1-03-17. Certificado de conformidad NOM-199-SCFI-2017. Ed. 9. Entra en <br>
                vigor:01/08/2024.
            </div>
        </footer>



        {{-- Segunda hoja --}}
        <div class="page-break"></div>
        <div class="img-background"></div>
        <div class="header">
            <center> <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM"></center>
            <!-- Texto centrado -->
            <div style="text-align: center;">
                <div>
                    <span style="font-family: Century Gothic Negrita; font-size: 14px">Centro de Innovación y Desarrollo Agroalimentario de Michoacán,</span><br>
                    <span class="letra2" style=" font-family: 'Cambria'; line-height: 0.9;">Acreditado como Organismo de Certificación de producto con número de
                        acreditación
                        144/18 <br>
                        ante la Entidad Mexicana de Acreditación, A.C.</span>
                </div>
                <div style="height: 10px"></div>
                <div style="color:  #0c1344; font-size: 13px;">
                    <span style="font-size: 24px; font-family: 'Cambria';">ANEXO</span><div style="height: 1px"></div>
                    <span style="font-family: 'Cambria';">Productor, envasador y comercializador</span><br>
                    <span class="letra3">XXXXXXXXX</span>
                </div>
            </div>
        </div>
        <div style="height: 10px"></div>
        <div style="color: #0c1344; text-align: left; font-size: 14.5px; line-height: 0.9; font-family: 'Cambria'">
            La presente certificación se realiza de acuerdo a la Norma Oficial Mexicana NOM-199- SCFI-2017,
            mediante el esquema de certificación de producto. De conformidad a lo dispuesto en los artículos 53,
            60 y 62 – de la Ley de Infraestructura de la Calidad, 50 del Reglamento de la LFMN, 6 Fracc. II del
            anexo 2.4.1 “Fracciones arancelarias de la tarifa de la Ley de los impuestos generales de importación
            y de exportación en las que se clasifican las mercancías sujetas al cumplimiento de las NOMs en su
            punto de entrada al país, y en el de su salida (anexo de NOMs)”.
        </div>
        
        <br>
        <table>
            <tr>
                <td class="negrita">Domicilio de planta de producción, envasado y
                    comercialización
                </td>
                <td class="negrita">Identificación del
                    lote muestreado</td>
            </tr>
            <tr>
                <td style="height: 100px"></td>
                <td></td>
            </tr>
        </table>
        <div style="color: #0c1344; text-align: left; font-size: 14.5px; font-family: 'Cambria';">Certificación de Sistema de Gestión con la que
            cuenta: <br>
            Vigencia:
        </div>
        <br>
        <div style="color: #0c1344; font-size: 14px; font-family: 'Cambria';line-height: 1;">
            Dado lo anterior, el Certificado de Conformidad ampara el proceso de producción realizado durante el
            periodo de vigencia, siempre y cuando se conserven las mismas condiciones bajo las que fue otorgado.
        </div>
        <br>
        <div style="color: #0c1344; font-size: 14px; font-family: 'Cambria';line-height: 1;">
            De conformidad con lo establecido en los apartados 6, 7 y 8 de la NOM-199-SCFI-2017, Bebidas
            Alcohólicas-Denominación, Especificaciones fisicoquímicas, información comercial y métodos de
            prueba.
        </div>
        <div style="height: 30px"></div>
        <div class="letra1" style="text-align: center; font-size: 10px; color: #0c1344; font-family: Arial, sans-serif;">
           <b> <span style="font-size: 14.5px">Atentamente</span> <br> <br>
            ___________________________________________ <br>
            Gerente Técnico del Organismo Certificador<br>
            del CIDAM A.C</b>
        </div>
        <footer style="color: white; position: absolute; bottom: 100px; width: 100%; font-size: 8.5px; line-height: 0.9">
            <div style="float: left; color: black">
                <div style="height: 40px"></div>
                Pag.2-2
            </div>
            <div style="float: right;">
                <span style="float: right; text-align: right;">Cancela y sustituye al Certificado con clave:</span>
                <div style="height: 50px"></div>
                Kilometro 8. Antigua carretera a Pátzcuaro, S/N. Col. Otra no especificada <br>
                en el catálogo. C.P. 58341. Morelia, Michoacán. <br>
                F7.1-03-17. Certificado de conformidad NOM-199-SCFI-2017. Ed. 9. Entra en <br>
                vigor: 01/08/2024.
            </div>
        </footer>
        
    </body>


</html>
