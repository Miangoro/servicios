<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>R-UNIIC-004 Orden de trabajo de inspección de etiquetas, tq CAFE</title>
    <style>
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 14px;
        }

        .header {
            position: fixed;
            top: 0px;
            left: 40px;
            width: 84%;
            padding: 10px;
            text-align: right;
            z-index: 1;
            margin-bottom: 30px;

        }


        .header img {
            width: 150px;
            height: 80px;
            margin-right: 450px;
        }

        .line {
            position: absolute;
            top: 90px;
            right: 10px;
            width: 68%;
            border-bottom: 1.5px solid black;
        }

        .header-text {
            font-size: 13px;
            margin-top: -45;
        }

        .img img {
            width: 100px;
            height: auto;
            display: block;
            margin-left: 20px;
            /* Centra la imagen horizontalmente */
        }

        p {
            margin: 0;
        }

        p+p {
            margin-top: 3px;
            /* Ajusta este valor según sea necesario */
        }

        .container {
            padding-left: 45px;
            padding-right: 45px;
            padding-top: 100px;
            margin-left: 35px;
            margin-right: 35px;
            border: 3px solid black;
        }

        /* tabla1 */
        .mi-tabla {
            border-collapse: collapse;
            width: 100%;
        }

        .mi-tabla,
        .mi-tabla th,
        .mi-tabla td {
            border: 3px solid #2F5496;
        }

        .mi-tabla td {
            padding: 1px;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        /* tabla 2 */
        .mi-tabla2 {
            border-collapse: collapse;
            width: 100%;
        }

        .mi-tabla2,
        .mi-tabla2 th,
        .mi-tabla2 td {
            border: 3px solid #2F5496;
        }

        .mi-tabla2 td {
            padding: 1px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
        }

        .tex-center {
            text-align: center;
        }

        /* Estilos generales para la tabla de firmas */
        .firma-section {
            width: 100%;
            margin-top: 25px;
            text-align: center;
        }

        .firma-section td {
            width: 50%;
            /* Cada celda ocupa la mitad de la tabla */
            padding: 20px;
        }

        .firma-linea {
            border-top: 3px solid #2F5496;
            margin-bottom: 10px;
            width: 80%;
        }

        .firma-texto {
            font-weight: bold;
            font-size: 13px;

        }
    </style>
</head>

<body>
    <div class="container">
        {{-- cabecera --}}
        <div class="header">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
            <div class="header-text">
                <p style=" margin: 0;">Orden de trabajo de inspección de etiquetas R-UNIIC-004</p>
                <p style=" margin: 0;">Edición 1, 19/08/2024</p>
            </div>
            <div class="line"></div>
        </div>
        <p class="text">
            Mediante el presente designo a Brenda Ameyalli Penagos Morales para realizar el
            servicio de revisión respecto a la información comercial de acuerdo a las especificaciones
            indicadas en la solicitud No. <b style="font-size: 13px;">SD-001/2024</b>
        </p>
        <p style="text-align: right;">No. Orden de Trabajo: <b style="font-size: 13px;">ORT-001-2024</b></p>
        <br>
        <table class="mi-tabla">
            <tr>
                <td style="width: 35%">No. de Servicio</td>
                <td style="width: 35%">PRODUCTO</td>
                <td>MARCA</td>
            </tr>
            <tr>
                <td>OSC-XXX-XXXX pendiente</td>
                <td style="text-align: left;">Café instantaneo, sabor cappuccino original, mokaccino, cappuccino crema
                    irlandesa, cappuccino a la
                    cajeta y cappuccino a la vainilla, charola con 20 vasos de 8 oz surtida de 5 sabores (4 vasos c/u)
                </td>
                <td>TQ Café</td>
            </tr>
            <tr>
                <td>FECHA DE ASIGNACIÓN</td>
                <td>FECHA DE INSPECCIÓN 1:</td>
                <td>9/18/2024</td>
            </tr>
            <tr>
                <td rowspan="2"></td>
                <td>FECHA DE INSPECCIÓN 2:</td>
                <td></td>
            </tr>
            <tr>
                <td>FECHA DE INSPECCIÓN 3:</td>
                <td></td>
            </tr>
        </table>
        <br>
        <b style="font-size: 13px;">Campo exclusivo para visitas de inspección.</b>
        <br>
        <p>Para esta deligencia debe presentarse en las intalaciones referidas acontinuación y llenar el Acta de
            Verificación y los registros correspondientes a la actividad a realizar:</p>

        <table class="mi-tabla2">
            <tr>
                <td>FECHA DE VISITA</td>
                <td>RESPONSABLE DE ATENDER LA VISITA</td>
            </tr>
            <tr>
                <td>LOREM</td>
                <td></td>
            </tr>
            <tr>
                <td>DOMICILIO DE INSPECCIÓN</td>
                <td></td>
            </tr>
        </table>
        <br>
        <p class="tex-center">
            Al final de su revisión deberá enviar los registros correspondientes a su diligencia para dar
            continuidad al proceso solicitado por el cliente.
        </p>

        <table class="firma-section">
            <tr>
                <td>
                    <div class="firma-arriba">Brenda Ameyalli Penagos Morales</div>
                    <div class="firma-linea"></div>
                    <div class="firma-texto">Inspector <br><br></div>
                </td>
                <td>
                    <div class="firma-arriba">Zaida Selenia Coronado Sánchez</div>
                    <div class="firma-linea"></div>
                    <div class="firma-texto">Gerente Técnico de la Unidad De Inspección de Información Comercial del
                        CIDAM A.C.</div>
                </td>
            </tr>
        </table>
        <br>
        <p class="tex-center">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
            puede ser distribuido externamente sin la autorización escrita del Ejecutivo.
        </p>


    </div>



</body>

</html>
