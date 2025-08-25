<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta y orden de servicio</title>

    <style>
        @page {
            margin: 130px
                /* este margen debe coincidir con el del header*/
                50px 20px 50px;
            
        }

        #header {
            width: 100%;
            position: fixed;
            top: -130px;
            /* se le debe de dejar la misma cantidad de pixeles del margen superior pero en negativo para que se vea bien el contenido del pdf */
            left: 0;
            height: 100px;
            z-index: 1000;
            background-color: white;
            text-align: right;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: white;
            height: 10px;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
        }

        body {
            font-family: Arial, sans-serif;
            padding-bottom: 10px;
        }


        .logo {
            float: left;
            width: 200px;
            height: 100px;
        }

        .texto_tablas{
            font-size: smaller;
        }


        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
            font-size: smaller;
        }

        .tabla1{
            border: 1px solid black;
            border-collapse: collapse;

        }

        .tabla1 th, .tabla1 td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: smaller;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: smaller;
        }

        .styled-table th, .styled-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: smaller;
        }

        /* Clases para manejar celdas sin borde */
        .styled-table .no-border {
            border-top: none;
            border-right: none;
            border-bottom: none;
            border-left: none;
        }

        .dvmargen{
            margin-top: 10px;
        }

        .jstTable {
            width: 100%;
            border-collapse: collapse;
            font-size: smaller;
        }

        .jstTable th, .jstTable td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: smaller;
        }

        .firmas{
             width: 100%;
            border-collapse: collapse;
        }

        .firmas td{
            font-size: smaller;
            text-align: center;
        }

        .lineaFirma{
            padding-top: 30px
        }

    </style>
</head>

<body>
    <div id="header" class="Head">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">

        <h4>Formato de solicitud de adquisición R-ADMI-004</h4>
        <h4>Edición 15 07/06/2024</h4>
        <hr>
    </div>

    <div id="footer">
        <p>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
    </div>

    <div class="container">
        <table class="info-table texto_tablas">
            <tr>
                <td>Unidad de: Calidad e Inocuidad Agroalimentaria</td>
                <td></td>
            </tr>
            <tr>
                <td>Área o Laboratorio: Suelos</td>
                <td  style="text-align: right;">Folio de solicitud: BS25-0019</td>
            </tr>
            <tr>
                <td>Fuente del recurso: Cuenta principal del CIDAM</td>
                <td  style="text-align: right;">Fecha de solicitud: 2025-08-14</td>
            </tr>
        </table>

        <div>
            <table class="tabla1 texto_tablas">
                <thead>
                    <tr>
                        <th colspan="8" style="text-align: center;">Datos del proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Razón Social</th>
                        <td>INCISIE</td>
                        <th>Contacto</th>
                        <td>Stephania Cortes</td>
                        <th>RFC</th>
                        <td>CIN140721KI8</td>
                        <th>Número de Cotización/Factura</th>
                        <td>1408-25CCC-1</td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>Cerro Azul #86, Santiagoquilco, 58110 Morelia, Mich.</td>
                        <th>E-mail</th>
                        <td>incisie@outlook.com</td>
                        <th>Teléfono</th>
                        <td>4432747158</td>
                        <th>Fecha de vigencia de cotización</th>
                        <td>14 de Agosto del 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="dvmargen">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Material o Servicio solicitado</th>
                        <th>Especificaciones técnicas</th>
                        <th>Cantidad</th>
                        <th>Precio unitario (sin iva)</th>
                        <th>Precio total (sin iva)</th>
                        <th>I.V.A</th>
                        <th>Precio total (con iva)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dietanolamina</td>
                        <td>Marca: Fermont<br>Volumen: 450 mL</td>
                        <td>1</td>
                        <td>$855.00</td>
                        <td>$855.00</td>
                        <td>$136.80</td>
                        <td>$991.80</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Acetato de amonio</td>
                        <td>Marca: Fermont<br>Cantidad: 500 gr</td>
                        <td>1</td>
                        <td>$711.00</td>
                        <td>$711.00</td>
                        <td>$113.76</td>
                        <td>$824.76</td>
                    </tr>
                    <tr>
                        <td colspan="4" rowspan="4" class="no-border"></td>
                        <td colspan="2" style="text-align: center;">Peso Mexicano</td>
                        <td colspan="2" class="no-border"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">Subtotal (sin iva)</td>
                        <td colspan="2" class="">$1,566.00</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">IVA Total</td>
                        <td class="">$250.56</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">Total</td>
                        <td colspan="2" class="">$1,816.56</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="dvmargen">
            <table class="jstTable">
                <tr>
                    <td><strong>Justificación de compra</strong></td>
                    <td>Los reactivos se requieren para los servicios que oferta el laboratorio</td>
                </tr>
            </table>
        </div>

        <div class="dvmargen">
            <table class="firmas">

                    <tr>
                        <td>Solicita y aprueba técnicamente</td>
                        <td>Revisión
                            Responsable de administración</td>
                        <td>Autoriza
                            Director Ejecutivo</td>
                    </tr>

                    <tr>
                        <td class="lineaFirma">
                            ____________________
                        </td>
                        <td class="lineaFirma">
                            ____________________
                        </td>
                        <td class="lineaFirma">
                            ____________________
                        </td>
                    </tr>
                    <tr>
                        <td>Dra. Citlali Colin Chavez</td>
                        <td>Julio Antonio Luna Villalón</td>
                        <td>Mtra. Sylvana Figueroa Silva</td>
                    </tr>
            </table>
        </div>

    </div>

</body>

</html>