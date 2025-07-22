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
                50px 80px 50px;
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
            height: 15px;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
        }

        body {
            font-family: Arial, sans-serif;
            padding-bottom: 40px;
        }


        .logo {
            float: left;
            width: 200px;
            height: 100px;
        }

        .m_1 {
            line-height: 1.2;
        }

        .tablas {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            margin: 10px auto;
        }

        .no_table {
            width: 100%;
            border: none;
        }

        .mi-tabla td {
            height: 10px;
        }

        .no_borde {
            border: none;
        }

        td,
        th {
            border: 1px solid black;
        }

        .tablas .head_azul {
            background-color: #024873;
            color: white;
        }

        #span_Agro {
            width: 100%;
            text-align: center;
        }

        .justificado {
            text-align: justify;
        }

        .smallText {
            font-size: small;
        }

        .mediumText {
            font-size: medium;
        }
    </style>
</head>

<body>
    <div id="header" class="Head">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">

        <h4>Venta y orden de servicio R-UGII-006</h4>
        <h4>Edición 13 01-06-23</h4>
        <hr>
    </div>

    <div id="footer">
        <p>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
            puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
        <script type="text/php">
                if(isset($pdf)) {
                    $pdf->page_script('
                            $font = $fontMetrics->get_font("Arial, sans-serif", "normal");
                            $pdf->text(550, 750, $PAGE_NUM . "/" . $PAGE_COUNT, $font, 10);
                    ');
                }
        </script>
    </div>

    <div class="container">
        <div class="titulo">
            <table class="no_table">
                <tr>
                    <th COLSPAN=3 class="no_borde m_1"><strong style="font-size: large">Venta y orden de
                            servicio</strong></th>
                </tr>
                <tr>
                    <td class="no_borde m_1 smallText">Fecha de venta: 2025-07-17 10:19:10</td>
                    <td class="no_borde m_1"></td>
                    <td class="no_borde m_1">
                        <h2 style="font-size: large">OSC25-0843</h2>
                    </td>
                </tr>
                <tr>
                    <td class="no_borde m_1 smallText">Fecha de edición: 17-07-2025 11:07:10</td>
                    <td class="no_borde m_1 smallText">Cotización OCC25-1375</td>
                    <td class="no_borde m_1"></td>
                </tr>
            </table>
        </div>
        <table class="tablas">
            <tr>
                <th COLSPAN=2 class="head_azul borde">Datos del contacto</th>
            </tr>
            <tr>
                <td class="no_borde smallText">Nombre del contacto: ANA LUIS BANQUEDANO</td>
                <td class="no_borde"></td>
            </tr>
            <tr>
                <td class="no_borde smallText">E-mail: abaquedano@sabormex.com.mx</td>
                <td class="no_borde smallText">Teléfono: 2224261606</td>
            </tr>

            <tr>
                <th COLSPAN=2 class="head_azul borde">Datos de Facturación</th>
            </tr>
            <tr>
                <td class="no_borde smallText">Razón Social: SABORMEX</td>
                <td class="no_borde"></td>
            </tr>
            <tr>
                <td class="no_borde smallText">Régimen fiscal: 0</td>
                <td class="no_borde"></td>
            </tr>
            <tr>
                <td class="no_borde smallText">RFC: SAB9407014V3</td>
                <td class="no_borde"></td>
            </tr>
            <tr>
                <td class="no_borde smallText">E-mail: wlanglet@sabormex.com.mx</td>
                <td class="no_borde smallText">Teléfono: 222 426 1606</td>
            </tr>
            <tr>
                <td class="no_borde smallText  ">Domicilio: CALZADA DE LA VIGA, No.1214 Col: APATLACO, CP: 09430,
                    IZTAPALAPA, CIUDAD DE MEXICO</td>
                <td class="no_borde"></td>
            </tr>
            <tr>
                <td class="no_borde smallText">Método de pago: Pago en Una sola Exhibición</td>
                <td class="no_borde smallText">Tipo de pago: Transferencia electrónica de fondos</td>
            </tr>
            <tr>
                <td class="no_borde smallText">Usos del CFDI 3.3: Gastos en general</td>
                <td class="no_borde"></td>
            </tr>


        </table>

        <table class="tablas">
            <tr>
                <th COLSPAN=6 class="head_azul borde">Tabla de servicios solicitados</th>
            </tr>
            <tr>
                <th class="head_azul borde smallText">Solicitud</th>
                <th class="head_azul borde smallText">Clave</th>
                <th class="head_azul borde smallText">Nombre del servicio</th>
                <th class="head_azul borde smallText">Cantidad</th>
                <th class="head_azul borde smallText">Precio Unitario</th>
                <th class="head_azul borde smallText">Sub-total</th>
            </tr>
            <tr>
                <td class="smallText">I.</td>
                <td class="smallText">LANIQ16-ESP</td>
                <td class="smallText">Cuantificación de bisfenol A en alimentos y envases</td>
                <td class="smallText">1</td>
                <td class="smallText">$1,725.00 </td>
                <td class="smallText">$2,587.71</td>
            </tr>
            <tr>
                <td class="smallText">II.</td>
                <td class="smallText">LANIQ18</td>
                <td class="smallText">Determinación de cafeína en alimentos y bebidas por HPLC</td>
                <td class="smallText">2</td>
                <td class="smallText">$862.07</td>
                <td class="smallText">$2,587.28</td>
            </tr>
            <tr>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td COLSPAN=2 class="smallText">Subtotal</td>
                <td class="smallText">$3,449.14</td>
            </tr>
            <tr>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td COLSPAN=2 class="smallText">Descuento 50.0374%</td>
                <td class="smallText">1,725.86</td>
            </tr>
            <tr>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td COLSPAN=2 class="smallText">Subtotal con descuento</td>
                <td class="smallText">1,723.28</td>
            </tr>
            <tr>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td COLSPAN=2 class="smallText">IVA</td>
                <td class="smallText">275.72</td>
            </tr>
            <tr>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td COLSPAN=2 class="smallText">Total</td>
                <td class="smallText">$1,999.00</td>
            </tr>
            <tr>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td COLSPAN=2 class="smallText">Anticipo</td>
                <td class="smallText">$0.00</td>
            </tr>
            <tr>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td class="no_borde"></td>
                <td COLSPAN=2 class="smallText">Por pagar</td>
                <td class="smallText">$1,999.00</td>
            </tr>
        </table>

        <table class="tablas no_borde">
            <tr>
                <th class="head_azul borde">Condiciones de entrega de la muestra al laboratorio</th>
            </tr>
            <tr>
                <td class="no_borde"><strong class="smallText">I. Nombre del Servicio: LANIQ16-ESP - Cuantificación de
                        bisfenol A en alimentos y envases</strong>
                    <p class="smallText">Método:<br>
                        El tiempo de entrega en días hábiles: 10 dias<br>
                        Listado o se anexa documento con las especificaciones para poder recibir las muestras.<br>
                        1) 250 gr de muestra
                    </p>
                </td>
            </tr>
            <tr>
                <td class="no_borde"><strong class="smallText">II. Nombre del Servicio: LANIQ18 - Determinación de
                        cafeína en alimentos y bebidas por HPLC</strong>
                    <p class="smallText">Método: Método interno por HPLC - DAD basado en: 1) Jeon, J.-S., Kim, H.-T.,
                        Jeong, I.-H., Hong, S.-R., Oh, M.-S., Yoon, M.-H., . . .
                        Abd El-Aty, A. M. (2019). Contents of chlorogenic acids and caffeine in various coffee-related
                        products. Journal of Advanced
                        El tiempo de entrega en días hábiles: 10 dias<br>
                        Listado o se anexa documento con las especificaciones para poder recibir las muestras.
                    </p>
                </td>
            </tr>
        </table>

        <table class="tablas">
            <tr>
                <th COLSPAN=4 class="head_azul borde">Identificación de muestras</th>
            </tr>
            <tr>
                <th class="head_azul borde smallText">Identificación</th>
                <th class="head_azul borde smallText">Descripción</th>
                <th class="head_azul borde smallText">Servicio</th>
                <th class="head_azul borde smallText">Laboratorio</th>
            </tr>
            <tr>
                <td class="smallText">LANIQ25-0843-1</td>
                <td class="smallText">GARAT. ESPRESSO. CAFÉ PURO TOSTADO Y MOLIDO 454g CLAVE:</td>
                <td class="smallText">LANIQ18</td>
                <td class="smallText">LANIQ</td>
            </tr>
            <tr>
                <td class="smallText">LANIQ25-0843-2</td>
                <td class="smallText">MEXICANO. CAFÉ PURO TOSTADO Y MOLIDO DESCAFEINADO 400g CLAVE: 260626 L2 16:25</td>
                <td class="smallText">LANIQ18</td>
                <td class="smallText">LANIQ</td>
            </tr>
            <tr>
                <td class="smallText">LANIQ25-0843-3</td>
                <td class="smallText">LA SIERRA. FRIJOLES BAYOS REFRITOS 440g (LATA) CONS PREF 23JUN2027 L1 19:48 RB
                </td>
                <td class="smallText">LANIQ16-ESP</td>
                <td class="smallText">LANIQ</td>
            </tr>
        </table>

        <table class="tablas">
            <tr>
                <th class="head_azul borde">Observaciones del cliente: </th>
            </tr>
            <tr>
                <td style="height: 50px;"> </td>
            </tr>
        </table>

        <table class="tablas">
            <tr>
                <th class="head_azul borde">Cliente</th>
                <th class="head_azul borde">Atendió</th>
            </tr>
            <tr>
                <td>ANA LUIS BANQUEDANO</td>
                <td>L.A.E. Alejandro Lenin Ayala</td>
            </tr>
        </table>

        <h3 class="smallText">Facturación</h3>
        <p class="justificado smallText">Favor de solicitar su factura al correo de Facturacion CIDAM: ventas@cidam.org,
            dentro de los 5 días hábiles de la emisión de
            la OSC u OCC, o depósito en su caso, de lo contrario será facturada como lo indique la misma OCC u OSC, y no
            habrá
            cambios posteriores. Favor de especificar Uso CFDI, forma de pago, método de pago y correo electrónico).
            Adjuntar la OSC,
            OCC o hacer referencia en el mismo correo. Cualquier cambio solicitado por el cliente en la modificación de
            algún dato
            erróneo ya sea de contacto u otro solicitado por escrito en un informe de resultados emitido tendrá un costo
            de $150 por cada
            informe.</p>

        <h2 class="smallText">Datos Fiscales del CIDAM</h2>
        <p class="smallText">
            CID120111HB1<br>
            CENTRO DE INNOVACIÓN Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN A.C. <br>
            KILOMETRO 8 ANTIGUA CARRETERA A PÁTZCUARO, S/N. C.P. 58341 <br>
            MORELIA, MICHOACÁN <br>
            E-mail: direccion@cidam.org <br>
            Teléfonos: (443) 591-5558 y 2990264Extensiones:507, 512, 543 y 505
        </p>

        <p class="smallText">
            <strong>BANCO: BANORTE</strong> <br>
            SUCURSAL: CATEDRAL <br>
            NÚMERO DE CLIENTE: 68190588 <br>
            NÚMERO DE CUENTA: 1190246090 <br>
            CLABE INTERBANCARIA: 072470011902460900
        </p>

        <p class="smallText">
            <strong>Contacto Ventas</strong> <br>
            Correos: ventas@cidam.org <br>
            Celular/WhatsApp: +52 (443) 591 5558 <br>
            facebook: /CIDAM.Agroinnovacion <br>
            Instagram: cidam.agroinnovacion
        </p>

        <h3>Buzón de quejas y sigerencias</h3>
        <p>
            Conoce nuestro buzón y proceso de atención a quejas y apelaciones visitando nuestra página
            https://www.cidam.org/inicio/contacto.php
        </p>

        <div id="span_Agro">
            <span>"Agroinnovación, transformando ideas..."</span>
        </div>

    </div>

</body>

</html>