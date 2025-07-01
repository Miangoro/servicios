<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Técnico de cumplimiento </title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        @page {
            margin: 90px 30px;
        }
        
        .header {
            position: fixed;
            top: -35px; 
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

        .description-container {
            position: fixed;
            top: 0;
            right: 50px; 
            width: calc(100% - 60px); 
            font-family: Arial, sans-serif;
            text-align: right; 
        }

        .description1,
        .description2 {
            margin: 0;
            font-size: 14px;
        }

        .description2 {
            margin-top: 2px; 
        }

        .line-below {
            position: absolute;
            right: 0;
            width: 120%;
            border-top: 1px solid black;
            margin-top: 10px; 
        }

        .text {
            margin-top: 60px;
            font-size: 12.5px;
            margin-left: 50px;
            margin-right: 40px;
            text-align: center;
        }

        .title {
            font-size: 20px;
            font-weight: bold; 
            margin-left: 1%;
            text-align: center;
            color: #1F3463;
        }

        .subtema {
            font-weight: bold; 
            color: #1F3463;
            margin-left: 9%;
        }

        table {
            width: 85%;
            border-collapse: collapse;
            margin: auto;
            font-size: 12px;
            line-height: 1;
            vertical-align: top;
            font-family: Arial, Helvetica, Verdana;
        }

        td, th {
            border: 1px solid #BEBEBE;
            padding: 10px;
            vertical-align: top;
            word-wrap: break-word;
        }

        td {
            width: 50%;
        }

        .column {
            font-size: 14px;
            font-weight: bold;
            vertical-align: middle;
            text-align: center;
        }

        .column-x {
            font-size: 14px;
            font-weight: bold;
            vertical-align: middle;
            text-align: center;
            color: #333F50;
        }

        .column-c {
            font-size: 14px;
            vertical-align: middle;
            text-align: center;
        }

        .dotted-table {
            border-collapse: collapse;
            width: 85%;
            margin: auto;
        }

        .dotted-table td, .dotted-table th {
            border: 1px dotted black; 
            padding: 10px;
            vertical-align: top;
            white-space: nowrap;
        }

        .dotted-table tr {
            border-bottom: 1px dotted black;
        }

        .text-table {
            font-size: 12.5px;
            margin-left: 55px;
            margin-right: 55px;
            text-align: justify;
        }

        .text-x {
            margin-top: 55px;
            font-size: 12.5px;
            margin-left: 55px;
            margin-right: 55px;
            text-align: justify;
        }

        .footer {
            position: absolute;
            bottom: -30px; 
            left: 60px;
            right: 60px;
            width: calc(100% - 60px);
            font-size: 11px;
            text-align: center;
        }

        .pagination {
            color: #A6A6A6; 
            font-size: 14px;
            position: absolute;
            bottom: -60px;
            right: 30px;
        }

        .color {
            color: #808080;
        }

        .page-break {
        page-break-before: always;
        }

        .text-table2 {
            font-size: 13px;
            font-weight: bold;
            vertical-align: middle;
            text-align: center;
        }

        .bar {
            font-size: 13px;
        }

        .text-c {
            vertical-align: middle;
            text-align: center;
        }

        .firma {
               font-size: 13px;
            font-weight: bold;
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">
    </div>

    <div class="description-container">
        <div class="description1">Reporte Técnico de cumplimiento NOM-199-SCFI-2017 F7.1-03-24</div>
        <div class="description2">Ed. 9 Entrada en vigor 13-11-2023</div>
        <div class="line-below"></div>
    </div>

    <p class="text"><strong>El Organismo de Certificación del Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</strong> 
    acreditado como Organismo de Certificación con acreditación No.144/18 por la entidad mexicana de acreditación, A.C. emite el</p>

    <p class="title">REPORTE TÉCNICO Y AUTENTICIDAD DE LAS <br> BEBIDAS ALCOHÓLICAS</p>

    <p class="subtema">I. Datos del Reporte</p>
    <table>
        <tbody>
            <tr>
                <td colspan="2">Lorem</td>
                <td class="column">Número de Reporte</td>
                <td>Lorem</td>
            </tr>
            <tr>
                <td class="column">Fecha de emisión</td>
                <td>Lorem</td>
                <td class="column" style="white-space: nowrap;">Fecha de vencimiento</td>
                <td>Lorem</td>
            </tr>
        </tbody>
    </table>

    <p class="subtema">II. Datos de la empresa</p>
    <table>
        <tbody>
            <tr>
                <td class="column" style="width: 220px; white-space: nowrap;">Nombre de la empresa</td>
                <td>Lorem</td>
            </tr>
            <tr>
                <td class="column">RFC:</td>
                <td>Lorem</td>
            </tr>
            <tr>
                <td class="column">Dirección Fiscal</td>
                <td>Lorem</td>
            </tr>
            <tr>
                <td class="column">Dirección planta de producción, envasado, comercialización y/o distribución</td>
                <td>Lorem</td>
            </tr>
        </tbody>
    </table>

    <p class="subtema">III. Descripción del producto</p>
    <table class="dotted-table">
        <tbody>
            <tr>
                <td class="column-x" style="width: 50px;">No.</td>
                <td class="column-x" style="width: 130px;">Familia</td>
                <td class="column-x" style="width: 220px;">Denominación Genérica<br><br>(Base Alcohólica)</td>
                <td class="column-x">Marca</td>
            </tr>
            <tr>
                <td class="column">1</td>
                <td class="column-c" rowspan="3">Lorem</td>
                <td class="column-c">Tipo II:<br><br>Base alcohólica:</td>
                <td class="column-c">Lorem</td>
            </tr>
            <tr>
                <td class="column">2</td>
                <td class="column-c">Tipo II:<br><br>Base alcohólica:</td>
                <td class="column-c">Lorem</td>
            </tr>
            <tr>
                <td class="column">3</td>
                <td class="column-c">Lorem</td>
                <td class="column-c">Lorem</td>
            </tr>
        </tbody>
    </table>

    <p class="text-table">Este reporte técnico de cumplimiento de Bebidas Alcohólicas se expide de acuerdo a la Norma Oficial Mexicana NOM-199-SCFI-2017, 
    Bebidas Alcohólicas-Denominación, Especificaciones Fisicoquímicas, Información Comercial y Métodos de Prueba.</p>

    <!-- Pie de página -->
    <div class="footer">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
    </div>
    
    <!-- Paginación -->
    <div class="pagination">
        <p>Página <b class="color">1</b> de <b class="color">3</b></p>
    </div>

    <div class="page-break"></div>

    <p class="text-x">Se realizó la obtención de muestras tipo, las cuales fueron muestreadas y recolectadas en triplicado por laauditora xxxxxxxxxxx, la primera y segunda quedaron en resguardo del responsable solicitante para gestión del ensayo de pruebas correspondientes. 
    La tercera quedó en resguardo del Organismo de Certificación de Producto de CIDAM.</p>

    <p class="subtema">IV. Normas Aplicables al Producto</p>

    <p class="text-table">El solicitante presentó, en formato digital, informes de resultados de ensayos fisicoquímicos que determinan:</p>

    <table>
        <tbody>
            <tr>
                <td class="bar" style="width: 400px; height: 35px;">Bebidas alcohólicas-Determinación de furfural-Métodos de ensayo (prueba).</td>
                <td class="bar">NMX-V-004-NORMEX-2018</td>
            </tr>
            <tr>
                <td class="bar" style="height: 35px;">Bebidas alcohólicas-Determinación de aldehídos, esteres, metanol y alcoholes superiores -Métodos de ensayo (prueba).</td>
                <td class="bar">NMX-V-005-NORMEX-2018</td>
            </tr>
            <tr>
                <td class="bar" style="height: 35px;">Bebidas alcohólicas-Determinación de Contenido alcohólico(por ciento de alcohol en volumen a 20°C (%Alc. Vol.)- Métodos de ensayo (prueba).</td>
                <td class="bar">NMX-V-013-NORMEX-2018</td>
            </tr>
            <tr>
                <td class="bar" style="height: 35px;">Bebidas alcohólicas-Determinación de metales como Plomo y Arsénico- Métodos de ensayo (prueba).</td>
                <td class="bar">NMX-V-050-NORMEX-2010</td>
            </tr>
        </tbody>
    </table>

    <p class="subtema">V. ESTATUS DE CUMPLIMIENTO</p>

    <p class="text-table">Los resultados fueron analizados por el Organismo de Certificación de Producto de CIDAM por lo que se <b>REPORTA EL CUMPLIMIENTO</b> de cada especificación, 
    pues se encuentran dentro de los límites y tolerancias señaladas en normasNOM-199-SCFI-2017 y sus referencias.</p>

    <p class="text-table">La bebida alcohólica que ampara este documento es la siguiente:</p>

    <table>
        <tbody>
            <tr>
                <td class="text-table2">No.</td>
                <td class="text-table2">Producto</td>
                <td class="text-table2">Marca</td>
                <td class="text-table2">Contenido</td>
                <td class="text-table2">Lote</td>
                <td class="text-table2" style="white-space: nowrap;">No. Análisis</td>
                <td class="text-table2">Laboratorio</td>
            </tr>
            <tr>
                <td class="text-c">1</td>
                <td class="text-c">Bebidas Alcohólicas Preparadas</td>
                <td class="text-c">Lorem</td>
                <td class="text-c">Lorem</td>
                <td class="text-c">Lorem</td>
                <td class="text-c">Lorem</td>
                <td class="text-c">Lorem</td>
            </tr>
            <tr>
            <td class="text-c" colspan="7">Resultados de ensayos fisicoquímicos: <br><br> <strong><span style="color: #1F3463;">APROBADO</span></strong></td>
            </tr>
        </tbody>
    </table>

    <p class="text-table">Los ensayos se realizaron por 01 laboratorio acreditado:</p><br>

    <p class="text-table"><strong>xxxxxxxxxxxxxxxxxxxxxx.</strong></p>
    <p class="text-table">Número Acreditación: xxxxxxxxxxxxxxx</p>

        <!-- Pie de página -->
        <div class="footer">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
    </div>
    
    <!-- Paginación -->
    <div class="pagination">
        <p>Página <b class="color">2</b> de <b class="color">3</b></p>
    </div>

    <div class="page-break"></div>

    <p class="text-x">Este laboratorio se encuentra acreditado en la Norma NMX-EC-17065-IMNC-2014 ISO/IEC 17065:2012 por la entidaddeacreditación ema A.C.</p>

    <p class="text-table">A los Xxxxxx días del mes de Noviembre del año dos mil veintitrés, se emite el Reporte Técnico de Cumplimientoaxxxxxxxxxxxxx el cual está sujeto a vigilancia y mantendrá validez en tanto se conserven las mismas condiciones bajolasque fue otorgado y vigencia de tres años a partir de su emisión.</p><br><br><br><br><br><br>

    <p class="firma">Atentamente</p>
    <p class="firma">Gerente General del Organismo Certificador</p>

    <!-- Pie de página -->
    <div class="footer">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
    </div>
    
    <!-- Paginación -->
    <div class="pagination">
        <p>Página <b class="color">3</b> de <b class="color">3</b></p>
    </div>
</body>
</html>
