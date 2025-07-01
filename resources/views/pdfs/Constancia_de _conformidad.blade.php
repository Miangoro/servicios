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
            margin-left: 100px;
            margin-right: 100px;
            margin-top: 60px;
            margin-bottom: 10px;

        }

        /*         @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }
*/
        @font-face {
            font-family: 'Lucida Sans Unicode';
            src: url('fonts/lsansuni.ttf') format('truetype');
        }

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

        @font-face {
            font-family: 'Arial Negrita';
            src: url('fonts/arial-negrita.ttf') format('truetype');
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
            font-size: 14px;
            font-family: 'Century Gothic Negrita';
        }

        .negrita2 {
            color: #0c1344;
            font-size: 10px;
            font-family: 'Arial Negrita';
        }

        .negrita3 {
            color: #0c1344;
            font-size: 15px;
            font-family: 'Cambria Negrita';
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
            border: 1px solid #0c1344;
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

        .no-padding-top {
            padding-top: 0;
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

        .img-background-left {
            position: absolute;
            top: -60px;
            right: -75px;
            width: 48px;
            height: 120%;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/fondo_amarillo.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }


        .img-background-right {
            position: absolute;
            top: -60px;
            right: -75px;
            width: 48px;
            height: 120%;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/mariposas_amarillo.png') }}');
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
            color: black;
            font-size: 38px;
            font-family: 'Cambria Negrita';

        }

        .signature-line {
            border-top: 1px solid #0c1344;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="img-background-left"></div>
    <div class="img-background-right"></div>


    <div class="img-background"></div>

    <div class="header">
        <img src="{{ public_path('img_pdf/uniic_logo.png') }}" alt="Logo Derecho"
            style="float: left; width: 230px; margin-left: -30px; padding-top: 27px">

        <!-- Texto centrado -->
        <div style="text-align: center">
            <div>
                <span class="negrita" style=" font-size: 14.5px; line-height: 0.9; color: #03a66a">CONSTACIA DE
                    CUMPLIMIENTO <br>
                    NOM-051-SCFI/SSA1-2010 M0D 27.03.2020</span><br>
                <span class="negrita" style="line-height: 0.9; font-size: 13px">Centro de Innovación y Desarrollo
                    Agroalimentario de <br>
                    Michoacán, A.C.</span>
            </div>
            <div style="color: #eb7b08; font-size: 10px;">
                <span class="negrita">Número de Acreditación:</span> UVNOM 145
            </div>
            <div style="padding-top: 27px; padding-bottom: 27px;text-align: center; color: #0c1344; font-size: 11px;margin-right: -30px"
                class="negrita2">
                NO. DOCUMENTO: &nbsp;&nbsp;&nbsp;&nbsp; XX145UCCNOM-051-
                SCFI/SSA1-201000000X
            </div>
            <div class="rightLetter"
                style="padding-bottom: 40px; font-size: 14px;color: #0c1344; font-family: Lucida Sans Unicode; padding-right: 30px">
                Morelia, Michoacán a ** de ** del 2024
            </div>

        </div>
    </div>
    <div style="height: 10px"></div>

    <body>


        <br>
        <table>
            <tr>
                <td class="leftLetter negrita2 no-padding-top" style="font-size: 10px">TITULAR</td>
                <td style="width: 200px">&nbsp;</td>
                <td class="leftLetter negrita2 no-padding-top">RFC</td>
                <td style="width: 200px">&nbsp;</td>
            </tr>
            <tr>
                <td class="leftLetter negrita2 no-padding-top">MARCA</td>
                <td>&nbsp;</td>
                <td class="leftLetter negrita2 no-padding-top">NO. DE REVISIÓN</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="leftLetter negrita2 no-padding-top">E-MAIL</td>
                <td>&nbsp;</td>
                <td class="leftLetter negrita2 no-padding-top">TELÉFONO</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="leftLetter negrita2 no-padding-top">PRODUCTO <br>
                    VERIFICADO</td>
                <td>&nbsp;</td>
                <td class="leftLetter negrita2 no-padding-top">PRESENTACIÓN</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <div style="height: 40px"></div>
        <div
            style="color: #0c1344; font-size: 15.5px; text-align: justify; line-height: 1.2; font-family: Arial, sans-serif">
            De conformidad a lo dispuesto en los artículos 43, 62, 63, 64, 65, 66, 67, 68 y 69 - de la Ley de
            Infraestructura de la Calidad, 50 del reglamento de la LFMN, 6 fracc. II del anexo2.4.1 "Fracciones
            arancelarias de la tarifa de la Ley de los impuestos generales de importación y de exportación en las que se
            clasifican las mercancías sujetas al cumplimiento de las NOMs en su punto de entrada al país, y en el de su
            salida (anexo de NOMs)"
        </div>
        <div style="padding: 5px"></div>
        <table>
            <tr>
                <td class="negrita2" style="padding: 10px; font-size: 20px; color: #0c1344">RESULTADO</td>
            </tr>
        </table>
        <div style="padding: 10px"></div>
        <div
            style="color: #0c1344; text-align: center; font-size: 15.5px; line-height: 1.2;font-family: Arial, sans-serif">
            <center>Condiciones de constancia</center>
        </div>
        <div style="padding: 2px"></div>
        <div class="signature-line"></div>
        <div
            style="color: #0c1344; text-align: justify; font-size: 15.5px; line-height: 1.2;font-family: Arial, sans-serif">
            Este documento solo ampara la información contenida en el producto cuya etiqueta muestra, se presenta en
            esta constancia, cualquier modificación a la etiqueta debe ser sometida a la consideración de la Unidad de
            Inspección acreditada y aprobada en los términos de la Ley de Infraestructura de la Calidad, para que
            Inspeccione su cumplimiento con la Norma Oficial Mexicana <samp class="negrita2" style="font-size: 14.5px">
                NOM-051-SCFI/SSA1-2010 MOD. 27.03.2020</samp>
        </div>
        <div style="padding: 30px"></div>
        <table class="signature-table">
            <tr>
                <td class="td-no-border" style="color: #0c1344; font-family: Arial, sans-serif;">
                    <div>___________________________________________</div>
                    <span class="negrita3" style="line-height: 0.9">Nombre y Firma</span><br>
                    <span class="td-no-border negrita3" style="line-height: 0.9">Inspector (a)</span>
                </td>
                <td class="td-no-border" style="color: #0c1344; font-family: Arial, sans-serif;">
                    <div>___________________________________________</div>
                    <span class="negrita3" style="line-height: 0.9">Nombre y Firma</span><br>
                    <span class="negrita3" style="line-height: 0.9">Gerente Técnico</span>
                </td>
            </tr>
        </table>

        <footer style="position: absolute; bottom: 60px; width: 100%; font-size: 8.5px; line-height: 0.9">
            <div style="float: left">
                <img src="{{ public_path('img_pdf/uniic_CIDAM.jpg') }}" alt="Logo CIDAM" style="width: 220px">
            </div>
            <div class="rightLetter" style="float: right; color: #0c1344; font-size: 11px">
                <span class="negrita2">Pag. 1-2 </span><br>R-UNIIC-009 Constancia de Conformidad NOM-051-SCFI/SSA1-2010 y <br>MOD.27.03.2020 <br> Ed.
                1. Entra en vigor: 19/08/24
            </div>
        </footer>



        {{-- Segunda hoja --}}
        <div class="page-break"></div>
        <div class="img-background"></div>
        <div class="img-background-left"></div>
        <div class="img-background-right"></div>
        <div class="header">
            <img src="{{ public_path('img_pdf/uniic_logo.png') }}" alt="Logo Derecho"
                style="float: left; width: 230px; margin-left: -30px; padding-top: 27px">

            <!-- Texto centrado -->
            <div style="text-align: center">
                <div>
                    <span class="negrita" style=" font-size: 14.5px; line-height: 0.9; color: #03a66a">CONSTACIA DE
                        CUMPLIMIENTO <br>
                        NOM-051-SCFI/SSA1-2010 M0D 27.03.2020</span><br>
                    <span class="negrita" style="line-height: 0.9; font-size: 13px">Centro de Innovación y Desarrollo
                        Agroalimentario de <br>
                        Michoacán, A.C.</span>
                </div>
                <div style="color: #eb7b08; font-size: 10px;">
                    <span class="negrita">Número de Acreditación:</span> UVNOM 145
                </div>
                <div style="padding-top: 27px; padding-bottom: 27px;text-align: center; color: #0c1344; font-size: 11px;margin-right: -30px"
                    class="negrita2">
                    NO. DOCUMENTO: &nbsp;&nbsp;&nbsp;&nbsp; XX145UCCNOM-051-
                    SCFI/SSA1-201000000X
                </div>
                <div class="rightLetter"
                    style="padding-bottom: 40px; font-size: 14px;color: #0c1344; font-family: Lucida Sans Unicode; padding-right: 30px">
                    Morelia, Michoacán a ** de ** del 2024
                </div>

            </div>
        </div>
        <div style="padding: 10px"></div>
        <div style="color: #0c1344; font-size: 15.5px; line-height: 1.2;font-family: Arial, sans-serif">
            Medidas
        </div>
        <div style="padding: 50px"></div>
        <table style="padding-left: 200px; padding-right: 200px">
            <tr>
                <td style="padding: 20px" class="negrita2">IMAGEN DE ETIQUETA
                </td>
            </tr>
        </table>
        <div style="padding: 40px"></div>
        <div style="color: #0c1344; font-size: 15px; line-height: 0.8;font-family: Lucida Sans Unicode; padding-right: -20px">
            Observaciones: La veracidad de la información es responsabilidad del titular de la constancia. El lote y
            fecha de caducidad o consumo preferente será colocado de conformidad con el punto 4.2.6 y 4.2.7 previo a la
            comercialización del producto.
        </div>
        <div style="padding: 40px"></div>
        <table class="signature-table">
            <tr>
                <td class="td-no-border" style="color: #0c1344; font-family: Arial, sans-serif;">
                    <div>___________________________________________</div>
                    <span class="negrita3" style="line-height: 0.9">Nombre y Firma</span><br>
                    <span class="td-no-border negrita3" style="line-height: 0.9">Inspector (a)</span>
                </td>
                <td class="td-no-border" style="color: #0c1344; font-family: Arial, sans-serif;">
                    <div>___________________________________________</div>
                    <span class="negrita3" style="line-height: 0.9">Nombre y Firma</span><br>
                    <span class="negrita3" style="line-height: 0.9">Gerente Técnico</span>
                </td>
            </tr>
        </table>
        <div style="padding: 15px"></div>
        <div class="signature-line"></div>
        <div style="color: #0c1344; font-size: 15.5px; line-height: 1.2;font-family: Arial, sans-serif">
            La presente constancia no deberá ser alterada ni reproducida en forma parcial o total sin la autorización
            del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.
        </div>
        <footer style="position: absolute; bottom: 60px; width: 100%; font-size: 8.5px; line-height: 0.9">
            <div style="float: left">
                <img src="{{ public_path('img_pdf/uniic_CIDAM.jpg') }}" alt="Logo CIDAM" style="width: 220px">
            </div>
            <div class="rightLetter" style="float: right; color: #0c1344; font-size: 11px">
                <span class="negrita2">Pag. 2-2</span> <br>R-UNIIC-009 Constancia de Conformidad NOM-051-SCFI/SSA1-2010 y <br>MOD.27.03.2020 <br> Ed.
                1. Entra en vigor: 19/08/24
            </div>
        </footer>

    </body>


</html>
