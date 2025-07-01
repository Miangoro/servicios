<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de servicio UNIIC</title>

    <style>
        body {
            font-family: 'century gothic', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        @page {
            margin: 30px 10px 0px 10px; 
        }


        table {
            width: 90%;
            border: 2px solid #1E4678;
            border-collapse: collapse;
            margin: auto;
            margin-top: -50px;
            font-size: 13.5px;
            line-height: 1;
            vertical-align: top;
            font-family: Arial, Helvetica, Verdana;
        }

        td, th {
            border: 2px solid #1E4678;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        td {
            width: 50%;
        }

        .header {
            position: fixed;
            top: 20px; 
            left: 30px;
            width: calc(100% - 60px);
            height: 100px; 
            overflow: hidden; 
        }

        .logo {
            margin-left: 30px;
            width: 150px;
            display: block;
        }

        .description1,
        .description2,
        .description3 {
            position: fixed;
            right: 30px;
            text-align: right;
        }

        .description1 {
            font-family: 'Arial', sans-serif;
            margin-right: 30px;
            top: 40px;
            font-size: 14px;
        }

        .description2 {
            font-family: 'Arial', sans-serif;
            margin-right: 30px;
            top: 60px;
            font-size: 14px;
        }

        .description3 {
            margin-right: 30px;
            top: 80px;
            font-size: 14px;
            padding-bottom: 5px;
            width: 63%;
        }

        .tema {
            text-align: center;
            margin-top: 80px; 
            font-size: 16px;
            font-family: 'century gothic negrita';
            margin-left: -120px;
        }

        .subtema {
            text-align: center;
            margin-top: 10px; 
            font-size: 15px;
            color: #ED7D31;
            font-family: 'century gothic negrita';
        }

        .subtema1 {
            margin-left: 60px;
            margin-top: 10px; 
            font-size: 13.5px;
            font-family: 'century gothic negrita';
            margin-bottom: 30px;
        }

        .subtema2 {
            margin-left: 60px;
            margin-top: 30px; 
            font-size: 13.5px;
            font-family: 'century gothic negrita';
            margin-bottom: 30px;
            color: #305496;
        }

        .subtema3 {
            text-align: center;
            margin-top: 10px; 
            font-size: 15px;
            color: #305496;
            margin-bottom: 30px;
            font-family: 'century gothic negrita';
        }

        .subtema4 {
            margin-left: 60px;
            margin-top: 10px; 
            font-size: 13.5px;
            font-family: 'century gothic negrita';
            margin-bottom: 30px;
        }

        .text {
            font-size: 13.5px;
            margin-left: 60px;
        }

        .text-x{
            margin-top: -20px;
            font-size: 13.5px;
            margin-left: 60px;
            margin-right: 500px;
            margin-bottom: 30px;
            line-height: 1;
        }

        .text-p1 {
            margin-top: -17px;
            font-size: 13.5px;
            margin-left: 120px;
            font-family: 'century gothic negrita';
        }

        .text-p2 {
            font-size: 13.5px;
            margin-left: 120px;
            font-family: 'century gothic negrita';
        }

        .text-p3 {
            font-size: 13.5px;
            margin-left: 120px;
            font-family: 'century gothic negrita';
        }

        .my-table {
            border-collapse: collapse;
            width: 40%; 
            margin-left: 60px;
            margin-top: 10px;
            font-family: 'century gothic';
        }

        .my-table td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #E36C09;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal;
            height: auto; 
            min-height: 30px; 
            max-width: 104px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table1 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-left: 420px;
            margin-top: -150px;
            font-family: 'century gothic';
        }

        .my-table1 td {
            font-size: 13.5px;
            vertical-align: middle;
            text-align: left;
            border: 3px solid #E36C09;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 104px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table2 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-left: 60px;
            margin-top: -10px;
            font-family: 'century gothic';
        }

        .my-table2 td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #E36C09;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 104px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table3 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 500px;
            margin-top: -105px;
            font-family: 'century gothic';
        }

        .my-table3 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .my-table3-x {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 500px;
            margin-top: -120px;
            font-family: 'century gothic';
        }

        .my-table3-x td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .my-table4 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-left: 60px;
            margin-top: 30px;
            font-family: 'century gothic';
        }

        .my-table4 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #2F5292;
            padding: 5px; 
            text-align: center;
        }

        .my-table5 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-right: 60px;
            margin-top: -195px;
            font-family: 'century gothic';
        }

        .my-table5 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #2F5292;
            padding: 5px; 
            text-align: center;
        }

        .my-table6 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-right: 60px;
            margin-top: -60px;
            font-family: 'century gothic';
        }

        .my-table6 td {
            font-size: 13.5px;
            vertical-align: middle;
            text-align: left; 
            border: 3px solid #2F5394;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal;
            height: auto; 
            min-height: 30px; 
            max-width: 104px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }
        
        .my-table7 {
            border-collapse: collapse;
            width: 85%; 
            margin-left: 60px;
            margin-right: 60px;
            margin-top: 10px;
            font-family: 'century gothic';
        }

        .my-table7 td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #2F5394;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto;
            min-height: 30px; 
            max-width: 104px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table8 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 300px;
            margin-top: -100px;
            font-family: 'century gothic';
        }

        .my-table8 td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid  #E36C09;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 150px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table9 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 60px;
            margin-top: 10px;
            background-color: #5B9BD5;
            font-family: 'century gothic';
        }

        .my-table9 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #000000;
            padding: 5px; 
            text-align: center;
        }

        .null {
            border-top: 3px solid rgb(255, 254, 254) !important;  
            border-right: 3px solid rgb(255, 254, 254) !important;  
            border-bottom-left-radius: 3px solid rgb(255, 254, 254) !important;  
        }

        .text-n{
            font-family: 'century gothic negrita';
        }

        .column-n {
            text-align: left !important;
            margin-top: 10px; 
            font-size: 12px;
            font-family: 'century gothic negrita';
        }

        .my-table-left{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 60px;
            margin-top: -10px;
            font-family: 'century gothic';
        }

        .my-table-left td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-center{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 290px;
            margin-top: -116px;
            font-family: 'century gothic';
        }

        .my-table-center td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-rigth{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 520px;
            margin-top: -116px;
            font-family: 'century gothic';
        }

        .my-table-rigth td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-rigth-x{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 500px;
            margin-top: -230px;
            font-family: 'century gothic';
        }

        .my-table-rigth-x td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-left-1{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 60px;
            margin-top: 30px;
            font-family: 'century gothic';
        }

        .my-table-left-1 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-center-1{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 290px;
            margin-top: -116px;
            font-family: 'century gothic';
        }

        .my-table-center-1 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-rigth-1{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 520px;
            margin-top: -116px;
            font-family: 'century gothic';
        }

        .my-table-rigth-1 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-l{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 60px;
            margin-top: 20px;
            font-family: 'century gothic';
        }

        .my-table-l td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #2F5394;
            padding: 0px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 100px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table-lp{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 60px;
            margin-top: 20px;
            font-family: 'century gothic';
        }

        .my-table-lp td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #2F5394;
            padding: 0px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 100px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table-lp2{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 290px;
            margin-top: -25px;
            font-family: 'century gothic';
        }

        .my-table-lp2 td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #2F5394;
            padding: 0px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 100px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        
        .my-table-control{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 520px;
            margin-top: -40px;
            font-family: 'century gothic';
        }

        .my-table-control td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #E36C09;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 100px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table-l2{
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 120px;
            margin-top: 50px;
            font-family: 'century gothic';
        }

        .my-table-l2 td {
            font-size: 13.5px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #ED7D31;
            padding: 0px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 100px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table-center-4 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 400px;
            margin-top: -100px;
            font-family: 'century gothic';
        }

        .my-table-center-4 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #EDEDED; 
            padding: 5px; 
            text-align: center;
        }

        .my-table-l3 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 120px;
            margin-top: 60px;
            font-family: 'century gothic';
        }

        .my-table-l3 td {
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #ED7D31; 
            padding: 0px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto; 
            min-height: 30px; 
            max-width: 100px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table-center-5 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 400px;
            margin-top: -120px;
            font-family: 'century gothic';
        }

        .my-table-center-5 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #EDEDED;
            padding: 5px; 
            text-align: center;
        }

        .my-table-adjuntar {
            border-collapse: collapse;
            width: 85%; 
            margin-left: 60px;
            margin-top: -10px;
            font-family: 'century gothic negrita';
        }

        .my-table-adjuntar td {
            font-size: 13.5px;
            vertical-align: middle;
            text-align: center;
            border: 3px solid #305496;
            padding: 5px; 
            text-align: center;
        }

        .my-table-informacion {
            border-collapse: collapse;
            width: 85%; 
            margin-left: 60px;
            margin-right: 60px;
            margin-top: -10px;
            font-family: 'century gothic';
        }

        .my-table-informacion td {
            font-size: 12px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #2F5394;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto;
            min-height: 30px; 
            max-width: 104px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .my-table-final {
            border-collapse: collapse;
            width: 85%; 
            margin-left: 60px;
            margin-right: 60px;
            margin-top: -10px;
            font-family: 'century gothic';
        }

        .my-table-final td {
            font-size: 12px;
            vertical-align: middle; 
            text-align: left; 
            border: 3px solid #2F5394;
            padding: 5px;
            word-wrap: break-word; 
            white-space: normal; 
            height: auto;
            min-height: 30px; 
            max-width: 200px; 
            overflow: hidden; 
            overflow-wrap: break-word; 
        }

        .page-break {
            page-break-before: always;
        }
    </style>

</head>
<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">
    </div>

    <div class="description1">R-UNIIC-001 Solicitud y especificaciones del Servicio para </div>
    <div class="description2">emisión de Constancias de Conformidad</div>
    <div class="description3">Edición 1 Entrada en Vigor: 19-08-2024</div>

    <p class="tema">Solicitud de servicio</p>
    <p class="subtema">Datos generales del cliente</p>

    <div>
        <table class="my-table-control">
            <tbody>
                <tr>
                    <td style="white-space: nowrap; width: 100px; color: #ED7D31; font-family: 'century gothic negrita';">No. de solicitud</td>
                    <td style="width: 85px;"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="text">Fecha de solicitud del servicio:</p>
    <p class="text">Nombre del cliente</p>
    <P class="text">Numero telefonico</P>
    <p class="text">Correo electronico</p>

    <p class="subtema1">Marca con una X la casilla que corresponda</p>

    <p class="text">¿Cuenta con una empresa Legal constituida?</p>

    <div class="table1">
        <table class="my-table">
            <tbody>
                <tr>
                    <td class="text-n">SI</td>
                    <td></td>
                    <td class="null"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: justify;">Nombre del representante Legal de la Marco o empresa</td>
                    <td rowspan="3"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left;">Domicilio fiscal</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left;">RFC</td>
                </tr>
            </tbody>
        </table>

        <table  class="my-table1">
            <tbody>
                <tr>
                    <td class="text-n">No</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: justify;">Domicilio del cliente (Indicando nombre, calle, número, código postal y entidad federativa)</td>
                    <td></td>
                </tr>
                <tr>
                    <td  style="text-align: left;">RFC</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p class="subtema2">Tu producto es:</p>

        <table class="my-table2">
            <tbody>
                <tr>
                    <td style="text-align: left;">Bebida alcohólica</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Alimento</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Bebida no alcohólica</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="page-break"></div>

    <p class="tema">Solicitud de servicio</p>
    <p class="subtema3">Datos para etiquetas de alimentos y bebidas no alcohólicas <br> NOM-051-SCFI/SSA1-2010 Mod 27.03.2020 </p>

    <p class="subtema1">Marca con una X la casilla que corresponda a tu producto</p>
    <p class="text">NOM-051-SCFI/SSA1-2010 Mod 27.03.2020</p>
    <p class="text">NOM-051-SCFI/SSA1-2010 Mod 27.03.2020 Producto importado</p>
    <p class="text">Etiquetado FDA</p>

    <div class="table1">
    <table class="my-table3">
        <tbody>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
        </tbody>
    </table>
    <br>

    <p class="subtema1">I. Infomación del producto</p>

    <table class="my-table4">
        <tbody>
            <tr>
                <td style="width: 200px; text-align: left;">Nombre de la marca comercial del producto</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="text-align: left;">Denominación del producto</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="text-align: left;">Presentación o contenido neto</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: left;">La caducidad de tu producto es mayor a tres meses</td>
                <td class="text-n" style="width: 50px;">SI </td>
                <td style="width: 50px;"></td>
            </tr>
            <tr>
                <td class="text-n">NO</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    
    <div>        
        <table class="my-table5">
            <tbody>
                <tr>
                    <td colspan="2" class="column-n">II. De acuerdo al registro de tu marca responde lo siguiente:</td>
                </tr>
                <tr>
                    <td colspan="2">¿Tu marca esta registrada ante el IMPI?</td>
                </tr>
                <tr>
                    <td style="color: #055EB8; text-decoration: underline;">SI</td>
                    <td style="color: #055EB8; text-decoration: underline;">NO</td>
                </tr>
            </tbody>
        </table>
    </div>


    <div>
        <table class="my-table6">
            <tbody>
                <tr>
                    <td style="text-align: left;">Tipo de marca y clase de registro</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left;">No. de Registro y No. Expediente de la marca</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left;">País de Origen (Bebidas importadas)</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: justify; font-size: 11.5px;">Es responsabilidad del cliente llevar a cabo y contra con el registro de marca ante el IMPI, la UNIIC, no se hace responsable de cualquier situación que pudiera darse por incumplimiento de dicho registro 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

<div class="page-break"></div>

<p class="tema">Solicitud de servicio</p>

<div>
    <table class="my-table7">
            <tbody>
                <tr>
                    <td colspan="3" rowspan="5" style="text-align: left;"><span style="font-family: 'century gothic negrita';">INGREDIENTES DEL PRODUCTO:</span> Enlistar todos los
                        ingredientes sin excepción en orden decreciente
                        (de mayor a menor) según la formulación del
                        producto, no es necesario mencionar las
                        cantidades.</td>
                    <td colspan="4" style="text-align: left;">1</td>
                    <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                    border-right: 3px solid rgb(255, 254, 254) !important; 
                    border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">2</td>
                    <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                    border-right: 3px solid rgb(255, 254, 254) !important; 
                    border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">3</td>
                    <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                    border-right: 3px solid rgb(255, 254, 254) !important; 
                    border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">4</td>
                    <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                    border-right: 3px solid rgb(255, 254, 254) !important; 
                    border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">5</td>
                    <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                    border-right: 3px solid rgb(255, 254, 254) !important; 
                    border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: left; font-size: 11px;"><span style="font-family: 'century gothic negrita';">¿Agrega agua a su producto?</span><br>
                        NOTA : Se debe indicar el agua añadida por orden de
                        predominio, excepto cuando ésta forme parte de un
                        ingrediente compuesto y la que se utilice en los procesos de
                        cocción y reconstitución. No es necesario declarar el agua u
                        otros ingredientes volátiles que se evaporan durante la
                        fabricación.
                    </td>
                    <td style="width: 50px; text-align: center;">Si</td>
                    <td></td>
                    <td style="width: 100px; text-align: center;">No</td>
                    <td style="width: 50px;"></td>
                    <td style="border-right: 3px solid rgb(255, 254, 254) !important;"></td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; font-family: 'century gothic negrita'; text-align: left">¿Se adicionan azúcares?</td>
                    <td style="width: 50px; text-align: center;">Si</td>
                    <td style="width: 50px;"></td>
                    <td style="width: 50px; text-align: center;">No</td>
                    <td style="width: 50px;"></td>
                    <td colspan="2" style="font-size: 11px; text-align: left; width: 40px; !imprtant">
                        En caso afirmativo, indique la cantidad que se añade en 100 g ó mL
                    </td>
                    <td>604 mg</td>
                </tr>
                <tr>
                    <td style="font-family: 'century gothic negrita'; text-align: left">¿Se adicionan aditivos?</td>
                    <td style="text-align: center;">Si </td>
                    <td></td>
                    <td style="width: 50px; text-align: center;">No</td>
                    <td></td>
                    <td colspan="2" style="font-size: 11px; text-align: left">En caso afirmativo, indique la
                        cantidad y tipo/s de aditivo que
                        se añade en 100 g ó mL:
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-family: 'century gothic negrita'; text-align: left">¿Se adiciona cafeína?</td>
                    <td style="text-align: center;">Si</td>
                    <td></td>
                    <td style="width: 50px; text-align: center;">No</td>
                    <td></td>
                    <td colspan="2" style="font-size: 11px; text-align: left;">En caso afirmativo, indique la
                        cantidad que se añade en 100 gó mL: 
                    </td>
                    <td style="width: 30px;"></td>
                </tr>
                <tr>
                    <td colspan="8" style="font-family: 'century gothic negrita'; text-align: left">Observaciones</td>
                </tr>
            </tbody>
        </table>
</div><br>

<p class="subtema1">III. Infomación de tabla nutrimental</p>

<p class="text-x">Los valores de la tabla nutrimental fueron obtenidos por medio de:</p>
<p class="text-p1">Análisis bromatológicos</p>
<p class="text-p2">Tablas reconocidas.</p>
<p class="text-p3">Otro.</p>

<div class="table1">
    <table class="my-table8">
        <tbody>
            <tr>
                <td style="width: 50px; height: 15px;"></td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-right: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-right: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-right: 3px solid rgb(255, 254, 254) !important;"></td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-right: 3px solid rgb(255, 254, 254) !important;"></td>
            </tr>
            <tr>
                <td></td>
                <td style="white-space: nowrap; font-family: 'century gothic negrita'; text-align: left;">Especificar ¿Cuál?</td>
                <td style="width: 200px;"></td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table9">
        <tbody>
            <tr>
                <td style="white-space: nowrap; font-family: 'century gothic negrita'; width: 290px;">Da click aquí para continuar</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="page-break"></div>

<p class="tema">Solicitud de servicio</p>

<p class="subtema1">I. Identifica a cual de las siguientes imágenes de parece el envase de tu producto</p>

<div>
    <table class="my-table-left">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen1.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-center">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen2.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-rigth">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen3.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 80px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-left-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen4.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-center-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen5.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-rigth-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen6.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-l">
        <tbody>
            <tr>
                <td style="width: 50px;">Alto</td>
                <td style="width: 102px;"></td>
                <td style="width: 50px;">cm</td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important; width: 17px !important;"></td>
                
                <td style="width: 50px;">Alto</td>
                <td style="width: 102px;"></td>
                <td style="width: 50px;">cm</td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important; width: 17px !important;"></td>

                <td style="width: 50px;">Alto</td>
                <td style="width: 102px;"></td>
                <td style="width: 50px;">cm</td>
            </tr>
            <tr>
                <td>Ancho</td>
                <td></td>
                <td>cm</td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>

                <td>Ancho</td>
                <td></td>
                <td>cm</td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>

                <td>Diametro</td>
                <td></td>
                <td>cm</td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-left-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen7.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-center-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen8.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-rigth-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen9.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-left-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen10.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-center-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen11.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-rigth-1">
        <tbody>
            <tr>
                <td style="height: 100px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/imagen12.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 100px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>


<div>
    <table class="my-table-lp">
        <tbody>
            <tr>
                <td style="width: 50px;">Diametro</td>
                <td style="width: 90px;"></td>
                <td style="width: 50px;">cm</td>            
            </tr>
        </tbody>
    </table>
</div>


<div>
    <table class="my-table-lp2">
        <tbody>
            <tr>                
                <td style="width: 50px;">Base</td>
                <td style="width: 102px;"></td>
                <td style="width: 50px;">cm</td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important; width: 17px !important;"></td>

                <td style="width: 50px;">Altura</td>
                <td style="width: 102px;"></td>
                <td style="width: 50px;">cm</td>
            </tr>
            <tr>
                <td>Altura</td>
                <td></td>
                <td>cm</td>
                <td style="border-top: 3px solid rgb(255, 254, 254) !important; 
                border-bottom: 3px solid rgb(255, 254, 254) !important;"></td>

                <td>Diametro</td>
                <td></td>
                <td>cm</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="page-break"></div>

<p class="tema">Solicitud de servicio</p>

<div style="border: 1px solid #7B7B7B; padding: 20px; margin: 40px; background-color: #f0f0f0;">
    <p class="subtema4">II. Infomación de la etiqueta </p>

    <p class="text">En base a esta imagen adjunta los siguientes datos</p>

    <div>
        <table class="my-table-l2">
            <tbody>
                <tr>
                    <td style="width: 60px;">Alto</td>
                    <td style="width: 104px;"></td>
                    <td>cm</td>
                </tr>
                <tr>
                    <td>Diámetro</td>
                    <td></td>
                    <td style="width: 40px;">cm</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <table class="my-table-center-4">
            <tbody>
                <tr>
                    <td style="height: 220px; width: 210px; overflow: hidden; position: relative;">
                        <img src="{{ public_path('img_pdf/imagen13.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 200px; transform: translate(-50%, -50%);">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <table class="my-table-l3">
            <tbody>
                <tr>
                    <td style="width: 60px;">Largo</td>
                    <td style="width: 104px;"></td>
                    <td>cm</td>
                </tr>
                <tr>
                    <td>Ancho</td>
                    <td></td>
                    <td style="width: 40px;">cm</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <table class="my-table-center-5">
            <tbody>
                <tr>
                    <td style="height: 200px; width: 200px; overflow: hidden; position: relative;">
                        <img src="{{ public_path('img_pdf/imagen14.png') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 150px; transform: translate(-50%, -50%);">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div>
    <table class="my-table-adjuntar">
        <tbody>
            <tr>
                <td style="text-align: left; vertical-align: top; height: 100px;">
                    Adjunta aquí imágenes de tu producto
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table9">
        <tbody>
            <tr>
                <td style="white-space: nowrap; font-family: 'century gothic negrita'; width: 290px;">Da click aquí para continuar</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="page-break"></div>

<p class="tema">Solicitud de servicio</p>

<p class="subtema3">Datos para etiquetas de bebidas alcohólicas <br> NOM-142-SSA1/SCFI-2014 NOM-199-SCFI-2017</p>

<p class="subtema1">Marca con una X la casilla que corresponda a tu producto</p>
<p class="text">NOM-142-SSA1/SCFI-2014 Bebidas Alcohólicas</p>
<p class="text">NOM-199-SCFI-2017 Producto Nacional</p>
<p class="text">NOM-142-SSA1/SCFI-2014 y/o NOM-199-SCFI-2017 Producto <br> Importado</p>

<div>
    <table class="my-table3-x">
        <tbody>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
        </tbody>
    </table>
</div>

<p class="subtema1">I. Infomación de la bebida alcohólica</p>

<div>
    <table class="my-table-informacion">
	<tbody>
		<tr>
			<td class="column-n" style="text-align: center !important;">Nombre / Denominación de la bebida alcohólica </td>
			<td class="column-n" style="text-align: center !important;">Categoría y/o Clasificación </td>
			<td class="column-n" style="text-align: center !important;">Presentación y Grado alcohólico </td>
			<td class="column-n" style="text-align: center !important;">Abocado o destilado con</td>
		</tr>
		<tr>
			<td style="height: 40px;"></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="column-n" style="text-align: center !important;">Tipo de marca </td>
			<td class="column-n" style="text-align: center !important;">Nombre de la marca comercial del producto</td>
			<td class="column-n" style="text-align: center !important;">No. de Registro y No. Expediente de la marca</td>
			<td class="column-n" style="text-align: center !important;">País de Origen (Bebidas importadas)</td>
		</tr>
		<tr> 
			<td style="height: 40px;"></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" rowspan="5"><span style="font-family: 'century gothic negrita';">INGREDIENTES DEL PRODUCTO (Bebidas alcohólicas
                preparadas, licores o cremas y todas las bebidas
                alcohólicas, que después de destiladas y/o antes de
                embotellar utilicen ingredientes opcionales y/o aditivos):</span>
            Enlistar todos los ingredientes sin excepción en orden
            decreciente:</td>
			<td colspan="2"><span style="font-family: 'century gothic negrita';">1</span></td>
		</tr>
		<tr>
			<td colspan="2"><span style="font-family: 'century gothic negrita';">2</span></td>
		</tr>
		<tr>
			<td colspan="2"><span style="font-family: 'century gothic negrita';">3</span></td>
		</tr>
		<tr>
			<td colspan="2"><span style="font-family: 'century gothic negrita';">4</span></td>
		</tr>
		<tr>
			<td colspan="2"><span style="font-family: 'century gothic negrita';">5</span></td>
		</tr>
		<tr>
			<td colspan="2"  style="font-family: 'century gothic negrita';">Observaciones</td>
			<td colspan="2"></td>
		</tr>
	</tbody>
</table>
</div>

<div class="page-break"></div>

<p class="tema">Solicitud de servicio</p>

<p class="subtema1">II. Infomación de la botella</p>

<p class="text">En vase a esta imagen adjunta los siguientes datos</p>

<div>
    <table class="my-table-l">
        <tbody>
            <tr>
                <td style="width: 50px;">Altura</td>
                <td style="width: 102px;"></td>
                <td style="width: 50px;">cm</td>
            </tr>
            <tr>
                <td>Diametro</td>
                <td></td>
                <td>cm</td>
            </tr>
        </tbody>
    </table>
</div>

<br>
<p class="text">¿Cuentas con ficha técnica por parte del proveedor?</p>

<div>
    <table class="my-table-l">
        <tbody>
            <tr>
                <td style="width: 80px;">SI</td>
                <td style="width: 80px;"></td>
            </tr>
            <tr>
                <td>NO</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <table class="my-table-rigth-x">
        <tbody>
            <tr>
                <td style="height: 200px; width: 200px; overflow: hidden; position: relative;">
                    <img src="{{ public_path('img_pdf/Botellas.jpg') }}" style="position: absolute; top: 50%; left: 50%; width: auto; height: 200px; transform: translate(-50%, -50%);">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<br>

<div>
    <table class="my-table-adjuntar">
        <tbody>
            <tr>
                <td style="text-align: left; vertical-align: top; height: 100px;">
                    Adjunta aquí imágenes de tu producto
                </td>
            </tr>
        </tbody>
    </table>
</div>

<br>

<div class="cuadrado" style="font-size: 11px; border: 1px solid #1F497D; margin-left: 30px; margin-right: 30px;">
    <p style="font-family: 'century gothic negrita'; text-align: center;">III. TÉRMINOS Y CONDICIONES DEL SERVICIO</p>

    <ol class="cuadro">
        <li>
            Para iniciar la revisión de la Información Comercial es necesario enviar la <strong>etiqueta en imagen vectorial en formato electrónico (.pdf), en tamaño real, indicando las medidas de la etiqueta;</strong> así como una imagen del empaque o envase original en el que es comercializado.
        </li>
        <li>
            El cliente es acreedor de <strong>3 revisiones</strong> por etiqueta; el primer informe de revisión de etiqueta se entregará en un lapso de 8 a 10 días hábiles posteriores a la recepción de la etiqueta y documentación requerida para iniciar con el servicio.
        </li>
        <li>
            Una vez enviado el primer informe de revisión, el cliente cuenta con un plazo de <strong>5 días naturales</strong> para enviar las correcciones estipuladas en el mismo. Si la etiqueta sigue presentando incumplimientos, se emite un segundo informe en donde se especifican los no cumplimientos. El cliente cuenta con un plazo de <strong>3 días naturales</strong> para realizarlos y enviar la etiqueta corregida. En caso de no realizarlos en el tiempo establecido, el cliente deberá pagar nuevamente el servicio para ser retomado.
        </li>
        <li>
            Si la etiqueta no cumple en la tercera revisión, el cliente deberá pagar nuevamente el servicio para continuar con 3 nuevas revisiones.
        </li>
        <li>
            Los requisitos ya aprobados en una primera y segunda revisión no se incluyen en subsecuentes revisiones, por lo que se solicita no realizar modificaciones a los requisitos ya aceptados con anterioridad.
        </li>
        <li>
            Para el caso del uso de marcas no registradas ante el IMPI, es responsabilidad del interesado realizar los trámites correspondientes; lo anterior sin perjuicio en contra de cualquiera que tenga derecho legítimo sobre dicha marca.
        </li>
        <li>
            Se emitirá una Constancia de Conformidad únicamente a los productos importados que se presentarán ya etiquetados en el despacho aduanero correspondiente para su importación. Las etiquetas de productos importados deben ser revisadas previo a la importación del producto.
        </li>
        <p>Por este medio acepto los términos y condiciones de la revisión de etiquetado antes mencionados.</p>
    </ol>

    <div style="text-align: center; margin-top: 5px; line-height: 0.5;">
        <!-- Caja con la línea superior y el texto centrado -->
        <p style="border-top: 1px solid #4472C4; padding-top: 5px; display: inline-block;">
            <strong>NOMBRE Y FIRMA DEL CLIENTE</strong>
        </p>
    </div>
</div>

<div class="page-break"></div>

<p class="tema">Solicitud de servicio</p>

<br>

<div>
    <table class="my-table-final">
        <tbody>
            <tr>
                <td colspan="5" class="subtema" style="text-align: center; font-size: 12;">(Campo exclusivo para personal de la Unidad de Inspección de Información Comercial)</td>
            </tr>
            <tr>
                <td style="width: 200px;">La unidad de Inspección tiene la
                experiencia técnica y los recursos
                adecuados para llevar a cabo el
                servicio.</td>
                <td style="width: 50px; text-align: center;">SI</td>
                <td style="width: 50px; text-align: center;"></td>
                <td style="width: 50px; text-align: center;">NO</td>
                <td style="width: 50px; text-align: center;"></td>
            </tr>
            <tr>
                <td>Nombre y firma del personal que
                revisa y valida la solicitud:</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td>Fecha de revisión y validación
            </td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td>No. de solicitud:
            </td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>