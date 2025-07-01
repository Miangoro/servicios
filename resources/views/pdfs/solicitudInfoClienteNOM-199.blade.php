<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F7.1-03-02 Solicitud de Información al Cliente NOM-199-SCFI-2017 Ed. 4 VIGENTE</title>
    <style>
        @page {
            size: 216mm 279mm; /* Establece el tamaño de página a 216mm de ancho por 279mm de alto */
            margin: 0; /* Elimina todos los márgenes */
            margin-top: 80px;
        }
        body {
            font-size: 12px;
            font-family: Arial, sans-serif;
        }
        .img img {
            width: 140px;
            height: auto;
            display: block;
            margin-left: 5px;
        }

        .header-table {
            width: 72%;
            margin: 0 auto; /* Centra la tabla horizontalmente */
            table-layout: fixed; /* Asegura que las celdas tengan un ancho fijo */
        }

        .img {
            width: 30%; /* Ajusta el ancho de la celda de la imagen */
        }

        .text-titulo {
            width: 70%; /* Ajusta el ancho de la celda del texto */
        }

        .centro {
            text-align: right; /* Alínea el texto a la derecha */
        }

        p {
            margin: 0;
            padding: 0;
        }

        p + p {
            margin-top: 0; /* Ajusta este valor según sea necesario */
        }

        .line {
            position: relative;
            margin-top: 2px; /* Reduce el margen superior */
            width: 98%; /* Largo */
            border-bottom: 1px solid black; /* Estilo de la línea */
        }

        .container {
            width: 75%;
            border: 2px solid black; /* Estilo de la línea */
            border-top: none;
            border-bottom: none;
            margin: 0 auto; /* Centra la tabla horizontalmente */
 /*  */
        }
        .contene{
            width: 75%;
            margin: 0 auto; /* Centra la tabla horizontalmente */
        }
        
        .header {
            background-color: #4081b2;
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            border: solid black 1px;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
        }

        .table-title {
            text-align: center;
            font-weight: bold;
            padding: 15px;
            margin-left: 170px;
            margin-right: 170px ;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
        .nested-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .info {
            text-align: right;
            font-size: 12px;
        }

        .table-cell {
        border: 1px solid black;
        margin-left: 50px;
        margin-right: 50px;
        padding: 7px; /* Reducir el padding */
        vertical-align: top;
        font-size: 12px; /* Reducir el tamaño de la fuente */
        text-align: center; /* Centrar el texto horizontalmente */
        vertical-align: middle; /* Centrar el texto verticalmente */
    }
    .tablas{
        margin-left: 30px;
        margin-right: 30px;
    }
    .footer{
        margin-left: 70px;
        margin-right: 70px;
    }

        .custom-table {
        margin: 0 auto; /* Centers the table horizontally */
        border-collapse: collapse;
        width: 552px; /* Adjust the width as needed */
    }

    .custom-table td, .custom-table th {
        border: solid black 1px;
        padding: 0;
        text-align: center; /* Center the text for a cleaner look */
    }

    .custom-table th {
        font-weight: bold;
        height: 40px;
        font-size: 12px;
    }
    .custom-table td {
        height: 40px;
    }
    .certification-table {
        margin: 0 auto; /* Centers the table horizontally */
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif; /* Ensures a clean and readable font */
    }

    .info-table{
        margin: 0 auto; /* Centers the table horizontally */
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif; /* Ensures a clean and readable font */
    }

    .info-table td, .info-table th{
        border: solid black 0.5px;
        padding: 5px;
        text-align: left;
        vertical-align: middle;
        font-size: 12px;
    }

.certification-table td, .certification-table th {
    border: solid black 0.5px;
    padding: 7px;
    text-align: left;
    vertical-align: middle;
}

    .certification-table th {
        font-weight: bold;
        text-align: center;
    }

    .checkbox-cell-small {
        width: 40px;
        height: 20px;
        border: solid black 1px;
        display: inline-block;
    }

    .checkbox-cell-smallss {
        width: 40px;
        height: 45px;
        border: solid black 1px;
    }

    .underline-cell {
        display: inline-block;
        border-bottom: solid black 1px;
        width: 300px;
    }
    .full-width-cell {
    width: 75%; /* Full width for alignment purposes */
    float: right; /* Align the underline element to the right */
}


        </style>
</head>
<body>
    {{-- encabezado --}}
    <table class="header-table">
        <tr>
            <td class="img" style="border: none;">
                <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM">
            </td>
            <td class="text-titulo"  style="border: none;">
                <div class="centro">
                    <p>Solicitud de Información al Cliente NOM-199-SCFI-2017 F7.1-03-02</p>
                    <p>Edición 4 Entrada en vigor. 20/06/2024</p>  
                    <div class="line"></div>      
                </div>
            </td>
        </tr>
    </table> <br>
    {{--  --}}
    <div class="container">
        <div class="header" style="font-size: 12px;">
            INFORMACIÓN DEL CLIENTE (Exclusivo cliente)
        </div>
        <table class="section-content" style="border: solid black 1px;">
            <tr style="border: solid black 1px;">
                <td class="section-title">Fecha de solicitud:</td>
            </tr>
            <tr style="border: solid black 1px;">
                <td class="section-title">Nombre / Razón Social del cliente:</td>
            </tr>
            <tr style="border: solid black 1px;">
                <td class="section-title">Teléfono y Correo electrónico:</td>
            </tr>
        </table>
{{-- tabla fisica --}}
    <div class="section-content" style="border: solid black 1px;">
        <div class="section-title" style="text-align: center; font-size: 13px;">Dirección de las ubicaciones físicas:</div>
        
        <table class="nested-table">
            <tr>
                <th rowspan="3" class="rowspan-title" style="position: relative; width: 124px; text-align: center; ">
                    <div style="border: solid #000000 2px; width: 35px; height: 85px; position: absolute; left: 102px; top: 6.6%; transform: translateY(-50%);"></div>
                    Fiscal:
                </th>
                <td >Calle:</td>
                <td >Número:</td>
            </tr>
            <tr>
                <td style="border-top: solid black 1px;">Colonia:</td>
                <td style="border-top: solid black 1px;">C.P.:</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: solid black 1px;">Localidad/Municipio/Ciudad/Estado:</td>
            </tr>
        </table>
        

        <table class="nested-table" style="border-top: solid black 1px;">
            <tr>
                <th rowspan="3" class="rowspan-title" style="position: relative; width: 124px;">
                    <div style="border: solid #000000 2px; width: 35px; height: 85px; position: absolute; left: 102px; top: 6.6%; transform: translateY(-50%);"></div>
                    Producción, Envasador y
                    Comercializador:
                </th>
                <td>Calle:</td>
                <td>Número:</td>
            </tr>
            <tr>
                <td style="border-top: solid black 1px;">Colonia:</td>
                <td style="border-top: solid black 1px;">C.P.:</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: solid black 1px;">Localidad/Municipio/Ciudad/Estado:</td>
            </tr>
        </table>

    </div>
    <p style="border: solid black 1px; font-size: 11px; text-align: center;"><b>En caso de contar con más instalaciones en domicilios diferentes donde lleve a cabo su actividad (planta de producción, envasado, bodega de maduración u otro) agregar las tablas necesarias y especificar domicilios*</b></p>
    
        <div class="table-title">
            Clasificación de Bebida(s) Alcohólica(s) por su proceso de elaboración.
        </div>
    <div class="tablas">
  <table>
            <tr>
                <td class="table-cell" style="border-bottom: none; "></td>
                <td class="table-cell" style="width: 125px;">Cerveza</td>
                <td class="table-cell" style="width: 30px;"></td>
                <td style="border: solid black 1px; border-bottom: none;"></td>
                <td class="table-cell" style="width: 30px;">Aguardiente</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" rowspan="6" style="border-top: none; width: 90px;"><strong>Bebidas Alcohólicas Fermentadas (2% a 20% Alc. Vol.)</strong></td>
                <td class="table-cell">“_____Ale”</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" rowspan="6" style="border-top: none; width: 90px;"><strong>Bebidas Alcohólicas Destiladas (32% a 55% Alc. Vol.)</strong></td>
                <td class="table-cell">Armagnac</td>
                <td style="border: solid black 1px; width: 30px"></td>
            </tr>
            <tr>
                <td class="table-cell">Pulque</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Bacanora</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Sake</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Brandy</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Sidra</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Cachaca</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Vino</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Comiteco</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Otro (Especifique):</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Ginebra</td>
                <td style="border: solid black 1px;"></td>
            </tr>

               
        </table>
    </div>

    </div>
    <br><br><br><br>
<div class="footer">
        <p style="text-align: center; margin-top: 15px; font-size: 10.5px;">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
        </p>
        <p style="text-align: right; margin-top: 20px; font-size: 12px;">
        1/3
        </p>
</div>
<br> 

{{-- seccion 2 --}}
 {{-- encabezado --}}
 <table class="header-table">
    <tr>
        <td class="img" style="border: none;">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM">
        </td>
        <td class="text-titulo"  style="border: none;">
            <div class="centro">
                <p>Solicitud de Información al Cliente NOM-199-SCFI-2017 F7.1-03-02</p>
                <p>Edición 4 Entrada en vigor. 20/06/2024</p>  
                <div class="line"></div>      
            </div>
        </td>
    </tr>
</table> <br>


<div class="container" style="border-bottom: solid black 2px; padding-bottom: 10px; border-top: solid black 2px;">
    <div class="tablas">
        <table>
            <tr>
                <td class="table-cell" style="border-bottom: none;"></td>
                <td class="table-cell" style="width: 100px; vertical-align: top;">Anís</td>
                <td class="table-cell" style="width: 30px;"></td>
                <td style="border: solid black 1px; border-bottom: none;"></td>
                <td class="table-cell" style="width: 100px; vertical-align: top;" >habanero</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" rowspan="6" style="border-top: none; border-bottom: none; width: 90px;"><strong>Licores o cremas (13.5% a 55% Alc. Vol.)</strong></td>
                <td class="table-cell" style="vertical-align: top;">Amaretto</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" rowspan="6" style="border-top: none; border-bottom: none; width: 90px;"><strong>Bebidas Alcohólicas Destiladas (32% a 55% Alc. Vol.)</strong></td>
                <td class="table-cell" style="vertical-align: top;">Kirsch</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="vertical-align: top;">Crema o licor de cassis</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" style="vertical-align: top;">Poire o Perry</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="vertical-align: top;">Crema o licor de café</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" style="vertical-align: top;">Ron</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="vertical-align: top;">Crema o licor de cacao</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" style="vertical-align: top;">Raicilla</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="vertical-align: top;">Crema o licor de menta</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" style="vertical-align: top;">Sambuca</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="vertical-align: top;">Fernet</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" style="vertical-align: top;">Sotol</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="border-top: none; border-bottom: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Irish cream</td>
                <td class="table-cell"></td>
                <td class="table-cell" style="border-top: none; border-bottom: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Vodka</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="border-top: none; border-bottom: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Licor amargo</td>
                <td class="table-cell"></td>
                <td style="border-top: none; border-bottom: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Whisky o Whiskey</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="border-top: none; border-bottom: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Licores de frutas</td>
                <td class="table-cell"></td>
                <td style="border-top: solid black 1px;"></td>
                <td class="table-cell" style="vertical-align: top;">“Cóctel de _______”</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="border-top: none; border-bottom: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Sambuca</td>
                <td class="table-cell"></td>
                <td style="padding: 6px;"></td>
                <td class="table-cell">“Cóctel sabor de___________”</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="border-top: none; border-bottom: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Xtabentún</td>
                <td class="table-cell"></td>
                <td style="text-align: center;"><strong>Cócteles (12% a 32% Alc. Vol.)</strong></td>
                <td class="table-cell" style="vertical-align: top;">“Cóctel de o al ____________”</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" style="border-top: none;"></td>
                <td class="table-cell" style="vertical-align: top;">Otro (Especifique):</td>
                <td style="border: solid black 1px; padding: 6px;"></td>
                <td style="border-bottom: solid black 1px;"></td>
                <td class="table-cell" style="vertical-align: top;">“Cóctel con __________”</td>
                <td class="table-cell" style="border: solid black 1px;"></td>
            </tr>
        </table>

    </div>
<table class="custom-table">
    <tr>
        <th colspan="6">Bebidas alcohólicas preparadas (2% a 12% Alc. Vol.)</th>
    </tr>
    <tr>
        <td colspan="2" style="width: 30px;">“Bebida alcohólica preparada de ___________________________”</td>
        <td></td>
        <td colspan="2" style="width: 30px;">“Bebida alcohólica preparada de o al ___________________________”</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">“Bebida alcohólica preparada sabor de ___________________________”</td>
        <td></td>
        <td colspan="2">“Bebida alcohólica preparada con ________________________”</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">Rompope</td>
        <td></td>
        <td></td>
        <td></td>
        <td ></td>
    </tr>
</table>

</div>

<div class="footer">
    <p style="text-align: center; margin-top: 15px; font-size: 10.5px;">
    Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
    </p>
    <p style="text-align: right; margin-top: 20px; font-size: 12px;">
    2/3
    </p>
</div>
<br>



{{-- encabezado --}}
<table class="header-table">
    <tr>
        <td class="img" style="border: none;">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM">
        </td>
        <td class="text-titulo"  style="border: none;">
            <div class="centro">
                <p>Solicitud de Información al Cliente NOM-199-SCFI-2017 F7.1-03-02</p>
                <p>Edición 4 Entrada en vigor. 20/06/2024</p>  
                <div class="line"></div>      
            </div>
        </td>
    </tr>
</table> <br>

    <div class="container" style="border-bottom: solid black 2px; border-top: solid black 2px;">
            <table class="certification-table" style="font-size: 12px;">
            <tr>
                <th colspan="6" style="margin: 0; border-bottom: none;" >Documentos normativos para los cuales busca la certificación:</th>
            </tr>
            <tr>
                <td colspan="2" style="border-right: none; border-top: none; border-bottom: none;  text-align: right">NOM-199-SCFI-2017</td>
                <td  style="border: none;"><div class="checkbox-cell-small"></div></td>
                <td colspan="2" style="border: none; text-align: right">NOM-251-SSA1-2009</td>
                <td  style="border-left: none; border-top: none; border-bottom: none; " colsnap="2"><div class="checkbox-cell-small"></div></td>
            </tr>
            <tr>
                <th colspan="6" style="font-size: 12px; border-top: none; border-bottom: none;" >¿Cuenta con una Certificación de Sistema de Gestión de Calidad?</th>
            </tr>
            <tr>
                <td style="border-top: none; border-bottom: none; border-right: none;">SI: <div class="checkbox-cell-small"></div></td>
                <td style="border: none;">NO: <div class="checkbox-cell-small"></div></td>
                <td style="border-top: none; border-bottom: none; border-left: none;" colspan="4">¿Cuál? <div class="underline-cell"></div></td>
            </tr>
            <tr>
                <td style="border-top: none;" colspan="6">¿Quién emite Certificación? <div class="underline-cell full-width-cell"></div></td>
            </tr>
          {{-- tabla 2 --}}
          <tr>
            <th colspan="6" style="border-bottom: none;">Actividad del cliente:</th>
        </tr>
        <tr>
            <td rowspan="2" style="border-top: none; border-right: none; border-bottom: none;">Productor</td>
            <td rowspan="2" style="border: none;">
                <div class="checkbox-cell-smallss"></div>
            </td>
            <td style="border: none;">Envasador</td>
            <td style="border: none;">
                <div class="checkbox-cell-smallss"></div>
            </td>
            <td style="border: none;">Importador</td>
            <td style="border-top: none; border-left: none; border-bottom: none;">
                <div class="checkbox-cell-small"></div>
            </td>
        </tr>
        <tr>
            <td style="border: none;">Comercializador</td>
            <td style="border: none;">
                <div class="checkbox-cell-smallss"></div>
            </td>
            <td colspan="2" style="border-top: none; border-left: none; border-bottom: none;"></td>
        </tr>

            

        <tr>
            <th colspan="6" style="height: 48px; text-align: end; vertical-align: top; border-top: solid black 2px;">NOMBRE Y FIRMA DEL SOLICITANTE:</th>
        </tr>
        <tr>
            <td colspan="6" style="font-size: 10px;">Para consulta del proceso de certificación, consultar la página <a href="http://www.cidam.org">www.cidam.org</a> que cuenta con el manual de certificación F7.1-03-01.</td>
        </tr>

        </table>
    </div>
<br>

<div class="contene">
    <table class="info-table">
        <tr>
            <td colspan="3" style="color: white; background-color: #4d93c8; text-align: center;"><strong>INFORMACIÓN DEL ORGANISMO CERTIFICADOR (Exclusivo ORGANISMO CERTIFICADOR CIDAM) Viabilidad del servicio</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 11px;" ><strong>DESCRIPCIÓN:</strong></td>
            <td style="width: 25px;"><strong>SI</strong></td>
            <td style="width: 25px;"><strong>NO</strong></td>

        </tr>
        <tr>
            <td>Se cuenta con todos los medios para realizar todas las actividades de evaluación para la
                Certificación</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>El organismo de Certificación tiene la competencia para realizar la Certificación</td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>El organismo de Certificación tiene la capacidad para llevar a cabo las actividades de certificación.</td>
            <td></td>
            <td></td>
            
        </tr>
        <tr>
            <td colspan="3">No. De cliente CIDAM:</td>
        </tr>
        <tr>
            <td colspan="3">Comentarios:</td>
        </tr>
    </table>
{{--  --}}
    
    {{--  --}}

        <table class="info-table">
        <tr>
            <td style="width: 145px; height: 60px; color: white; background-color: #4d93c8; text-align: center;"><strong>Nombre y Puesto de quien realiza la revisión</strong>
            </td>
            <td style=" height: 60px;">

            </td>
            <td style="width: 145px; height: 60x; color: white; background-color: #4d93c8; text-align: center;"> <strong>Firma de quien realiza la revisión</strong>
            </td>
            <td style=" height: 60px;"></td>
        </tr>

    </table>
    </div>
    
    <div class="footer">
        <p style="text-align: center; margin-top: 15px; font-size: 10.5px;">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
        </p>
        <p style="text-align: right; margin-top: 20px; font-size: 12px;">
        3/3
        </p>
    </div>


</body>
</html>
