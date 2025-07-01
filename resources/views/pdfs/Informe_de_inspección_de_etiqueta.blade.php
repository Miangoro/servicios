<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plan de auditoría de esquema de certificación</title>
    <style>
        body {
            font-weight: 12px;
        }

        @page {
            margin-left: 87px;
            margin-right: 115px;
            margin-top: 60px;
            margin-bottom: 60px;

        }

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
            font-size: 13px;
            font-family: 'Cambria Negrita';
        }

        .negrita4 {
            color: black;
            font-size: 18px;
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
            border: 2px solid #0c1344;
            padding: 4px;
            font-size: 11px;
            text-align: center;
            font-family: 'Cambria Negrita';
        }

        th {
            background-color: black;
            color: white;
            text-align: center;
        }

        .letra-fondo{
            background-color: #6d9eeb;
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
            max-width: 205px;
            padding: 0;
            margin-top: -60px;
            margin-left: -30px;
            margin-right: -10px;

        }
    </style>
</head>

<body>
    <div class="img-background"></div>

    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM" >
        <div style=" font-size: 14.5px;line-height: 0.9; ">Informe de Inspección de Etiqueta R-UNIIC-008<br>Edición 1,19/08/2024
        </div>
        <div style="margin-top: -18px; ">______________________________________________________________________</div>
        <div style="height: 15px;"></div>
        <div style="text-align: center">
            <div style="height: 10px"></div>
            <div>
                <div class="negrita" style=" font-size: 19.5px; line-height: 0.9; color: #00b050"><u>Informe De
                    Inspección De Etiqueta</u>

                </div>
                <div class="rightLetter"
                    style="font-size: 14.5px;color: #0c1344; font-family: Lucida Sans Unicode; padding-right: 30px;  margin-right: -20px ">
                    Número de Acreditación: UVNOM 145
                </div>
                <div class="rightLetter negrita" style="color: #eb7b08; font-size: 16px; padding-right: 30px; margin-right: -20px ">
                  No. de Informe: XXX-XXXXRX
                  
                </div>
                <div class="rightLetter"
                    style="padding-bottom: 20px; font-size: 13.5px; font-family: Lucida Sans Unicode; padding-right: 30px; margin-right: -20px ">
                    Morelia, Michoacán, a __ de ____ del ___
                </div>
            </div>
            <div style="font-size: 16px; font-family: Lucida Sans Unicode; text-align: justify">
                Por medio del presente la Unidad de Inspección de Información Comercial del
                CIDAM A.C., hace de su conocimiento a ________________, responsable del
                producto:
            </div>
            <div style="height: 10px;"></div>
            <table>
                <tr>
                    <td class="negrita3 letra-fondo">Nombre/Denominación del <br>
                        producto
                    </td>
                    <td class="negrita3 letra-fondo">Marca comercial del <br>
                        producto</td>
                    <td class="negrita3 letra-fondo">No. servicio</td>
                    <td class="negrita3 letra-fondo">No. de revisión</td>
                </tr>
                <tr>
                    <td style="height: 35px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div style="height: 10px;"></div>
            <div style="font-size: 15.5px; font-family: Lucida Sans Unicode;text-align: justify; line-height: 1.1; padding-bottom:9px">
                Las especificaciones de información comercial con los que la etiqueta NO CUMPLE
                de acuerdo con lo estipulado en la <span class="negrita"> NOM-XXXXXXX;</span> por lo que se le solicita realice
                los cambios pertinentes mencionados en el siguiente cuadro; en un plazo no mayor
                a ___ días naturales.
            </div>
            <table>
                <tr>
                    <td class="negrita3" style="width: 25px">No.</td>
                    <td class="negrita3">Especificaciones</td>
                    <td class="negrita3" style="width: 65px">Resultado <br>
                        (NC)</td>
                    <td class="negrita3" style="width: 200px">Observaciones</td>
                </tr>
                <tr>
                    <td style="height: 20px"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height: 35px"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="negrita4" style="padding-top: 28px; padding-bottom: 5px">Atentamente</div>
            <table>
                <tr>
                    <td class="td-no-border" style="color: #0c1344; font-family: Arial, sans-serif;">
                        <div style="color: #1e2d9e">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ </div>
                        <span class="negrita3" style="line-height: 1.1;  font-size: 15px">Nombre y Firma</span><br>
                        <span class="td-no-border negrita3" style="line-height: 0.9;  font-size: 15px">Inspector (a)</span>
                        <br>
                        <br><br> <br>
                    </td>
                    <td class="td-no-border" style="color: #0c1344; font-family: Arial, sans-serif;">
                        <div style="color: #1e2d9e">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ </div>
                        <span class="negrita3" style="line-height: 1.1; font-size: 15px">Nombre y Firma</span><br>
                        <span class="negrita3" style="line-height: 1.1;  font-size: 15px">Gerente Técnico de la Unidad <br>
                        de Inpeccion de Información <br> Comercial CIDAM</span>
                    </td>
                </tr>
            </table>
            <footer style="position: absolute; text-align: center; font-size: 11px; margin-top: 20px;">
                Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
            </footer>
</body>

</html>
