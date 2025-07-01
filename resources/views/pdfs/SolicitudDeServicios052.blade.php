<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de servicios</title>
    <style>
        @page {
            margin-top: 40px;
            margin-right: 50px;
            margin-left: 50px;
            margin-bottom: 1px;
        }

        @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        body {
            font-family: 'Century Gothic', sans-serif;
            font-size: 10px;

        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1.5px solid black;
            padding: 1px;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            padding-top: 0;
            padding-bottom: 0;
            text-align: center;
            font-size: 11px;
        }

        .td-margins {
            border-bottom: none;
            border-top: none;
            border-right: 0.5px solid black;
            border-left: 0.5px solid black;

        }

        .td-margins-left {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 0.5px solid black;

        }

        .td-no-margins {
            border: none;
        }

        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }

        .letra_right {
            text-align: right;
        }

        .letra_left {
            text-align: left;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .con-negra {
            font-family: 'Century Gothic Negrita';
        }

        .no-borde-top {
            border-top: none;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td rowspan="2" colspan="3" style="padding: 0; ">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" style="width: 170px; margin: 0;height: 75px;"
                    alt="Logo CIDAM">
            </td>
            <td class="con-negra"
                style="font-size: 14px; padding-left: 16px; padding-right: 16px;padding-top: 7px; padding-bottom: 7px">
                CENTRO DE INNOVACION Y DESARROLLO <br>
                AGROALIMENTARIO DE MICHOACAN A.C.</td>
            <td style="text-align: center; font-size: 8px; padding-left: 0; padding-top: 0; width: 160px">ORGANISMO DE
                CERTIFICACION No. de
                acreditación 144/18 ante la ema A.C.
            </td>
        </tr>
        <tr>
            <td class="con-negra" style="font-size: 14px" colspan="2">SOLICITUD DE SERVICIOS NMX-V-052-NORMEX-2016
            </td>
        </tr>

    </table>
    <table>
        <tr>
            <th class="no-borde-top" style="width:60px;">I:</th>
            <th class="no-borde-top" colspan="12" style="padding-top: 2px;padding-bottom: 2px;">INFORMACIÓN DEL
                SOLICITANTE</th>
        </tr>

    </table>

    <table>
        <tr>
            <td class="con-negra no-borde-top " style="width: 90px" rowspan="3" colspan="2">Nombre del cliente/
                o<br> Razon social:</td>
            <td class="no-borde-top" style="width: 100px" rowspan="3" colspan="4">&nbsp;</td>
            <td class="con-negra no-borde-top" style="width: 50px" colspan="3">N° de cliente:</td>
            <td class="no-borde-top" style="width: 120px" colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="3">e-mail:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="3">Teléfono:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Fecha de solicitud:</td>
            <td colspan="7">&nbsp;</td>
            <td class="con-negra" colspan="1">No. de Inventario:</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Responsable de las <br>
                instalaciones:</td>
            <td colspan="7">&nbsp;</td>
            <td class="con-negra" colspan="1">SKU:</td>
            <td colspan="3"></td>
        </tr>


    </table>
    <table>
        <tr>
            <td class="con-negra no-borde-top " style="width: 81px" colspan="2">Domicilio Fiscal:</td>
            <td class="con-negra no-borde-top " style="width: 84px" colspan="4">&nbsp;</td>
            <td class="con-negra no-borde-top " style="width: 70px" colspan="3">Domicilio de Instalaciones</td>
            <td class="con-negra no-borde-top " style="width: 120px" colspan="4"></td>
        </tr>
    </table>
    <table>
        <tr>
            <th class="no-borde-top" style="width:60px;">II:</th>
            <th class="no-borde-top" colspan="12" style="padding-top: 2px;padding-bottom: 2px;">SERVICIO SOLICITADO A
                LA UVEM</th>
        </tr>
    </table>
    <table>
        <tr>
            <td class="td-margins con-negra" colspan="13" style="color: red; padding: 0;">Seleccione el servicio
                solicitado colocando una X en la casilla correspondiente</td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Vigilancia en proceso de producción (familia):</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita
                <br> propuesta:
            </td>
            <td colspan="6" style="width: 230px"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Toma de muestra:</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita
                <br> propuesta:
            </td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Liberación de producto terminado:</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita
                <br> propuesta:
            </td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Emisión de certificado de cumplimiento de la bebida:</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita
                <br> propuesta:
            </td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="td-margins  letra_right" colspan="3"
                style="font-weight:  bold; padding-top: 0;padding-bottom: 0; width: 220px">Dictaminación de
                instalaciones:
            </td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td style="width: 30px" style="font-weight: bold; padding-top: 0;padding-bottom: 0;" colspan="2">
                Productor <br> de bebidas <br> alcohólicas <br> que <br>
                contienen <br> Mezcal
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 80px; padding-top: 0;padding-bottom: 0;font-weight: bold">Envasador de bebidas
                alcohólicas que
                contienen Mezcal</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 20px; padding-top: 0;padding-bottom: 0; font-weight: bold" colspan="2">
                Comercializador <br> de bebidas <br> alcohólicas que
                contienen <br> Mezcal</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;" colspan="1"></td>
        </tr>
        <tr>
            <td class="td-margins-left letra_right"
                colspan="5"style="font-weight:  bold; padding-top: 0;padding-bottom: 0;">
            </td>
            <td class="td-no-margins" style="width: 30px"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left; font-size: 8px"
                colspan="3">Fecha y
                hora de visita <br> propuesta:
            </td>
            <td colspan="5"></td>
        </tr>

        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>

        <tr>
            <td class="td-margins letra_right" colspan="3"
                style="font-weight:  bold; padding-top: 0;padding-bottom: 0; width: 220px">Renovación de dictaminación
                de instalaciones:
            </td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td style="width: 30px" style="font-weight: bold; padding-top: 0;padding-bottom: 0;" colspan="2">
                Productor <br> de bebidas <br> alcohólicas <br> que <br>
                contienen <br> Mezcal
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 80px; padding-top: 0;padding-bottom: 0;font-weight: bold">Envasador de bebidas
                alcohólicas que
                contienen Mezcal</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 20px; padding-top: 0;padding-bottom: 0; font-weight: bold" colspan="2">
                Comercializador <br> de bebidas <br> alcohólicas que
                contienen <br> Mezcal</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;" colspan="1"></td>
        </tr>
        <tr>
            <td class="td-margins-left letra_right"
                colspan="5"style="font-weight:  bold; padding-top: 0;padding-bottom: 0;">
            </td>
            <td class="td-no-margins" style="width: 30px"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left; font-size: 8px"
                colspan="3">Fecha y
                hora de visita <br> propuesta:
            </td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>



        <tr>
            <td class="td-margins letra_right" colspan="3"
                style="font-weight:  bold; padding-top: 0;padding-bottom: 0; width: 220px">Emisión de certificado de
                cumplimiento de
                instalaciones
            </td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td style="width: 30px" style="font-weight: bold; padding-top: 0;padding-bottom: 0;" colspan="2">
                Productor
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 80px; padding-top: 0;padding-bottom: 0;font-weight: bold">Envasador
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 20px; padding-top: 0;padding-bottom: 0; font-weight: bold" colspan="2">
                Comercializador
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;" colspan="1"></td>
        </tr>
        <tr>
            <td class="td-margins-left letra_right"
                colspan="5"style="font-weight:  bold; padding-top: 0;padding-bottom: 0;">
            </td>
            <td class="td-no-margins" style="width: 30px"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left; font-size: 8px"
                colspan="3">Fecha y
                hora de visita <br> propuesta:
            </td>
            <td colspan="5" style="border-bottom: none"></td>
        </tr>
    </table>
    <table>
        <tr>
            <th style="width:60px;">III: </th>
            <th colspan="12" style="padding-top: 2px;padding-bottom: 2px;">CARACTERISTICAS DEL PRODUCTO</th>
        </tr>
    </table>
    <table>
        <tr>
            <td class="no-borde-top letra_left con-negra">1) Categoria:</td>
            <td class="no-borde-top letra_left con-negra" style="width:110px"></td>
            <td class="no-borde-top letra_left con-negra">5) Marca</td>
            <td class="no-borde-top letra_left con-negra" style="width:110px"></td>
            <td class="no-borde-top letra_left con-negra">9) Presentación</td>
            <td class="no-borde-top letra_left con-negra" style="width:110px"></td>
        </tr>
        <tr>
            <td class=" letra_left con-negra">2) No. de lote a granel de mezcal utilizado</td>
            <td class=" letra_left con-negra" style="width:110px"></td>
            <td class=" letra_left con-negra">6) No. de análisis de <br>
                la bebida alcohólica con Mezcal
            </td>
            <td class=" letra_left con-negra" style="width:110px"></td>
            <td class=" letra_left con-negra">10) No. de botellas ó latas</td>
            <td class=" letra_left con-negra" style="width:110px"></td>
        </tr>
        <tr>
            <td class=" letra_left con-negra">3) No. de análisis del lote de mezcal utilizado</td>
            <td class=" letra_left con-negra" style="width:110px"></td>
            <td class=" letra_left con-negra">7) Contenido alcohólico
            </td>
            <td class=" letra_left con-negra" style="width:110px"></td>
            <td class=" letra_left con-negra">11) No. de cajas</td>
            <td class=" letra_left con-negra" style="width:110px"></td>
        </tr>
        <tr>
            <td class=" letra_left con-negra">4) Tipo de maguey </td>
            <td class=" letra_left con-negra" style="width:110px"></td>
            <td class=" letra_left con-negra">8) No. de lote envasado
            </td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class=" con-negra" colspan="2">INFORMACIÓN ADICIONAL SOBRE LA ACTIVIDAD:</td>
            <td colspan="4"></td>
        </tr>
    </table>
    <table>
        <tr>
            <th class="no-borde-top" style="width:60px;">IV: </th>
            <th class="no-borde-top" colspan="12" style="padding-top: 2px;padding-bottom: 2px;">ANEXOS</th>
        </tr>
    </table>
    <table>
        <tr>
            <td class="no-borde-top con-negra" colspan="13" style="color: #C00000; padding: 0;">Adjuntar a la solicitud los documentos que a continuación se enlistan:</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="no-borde-top letra_right" style="width: 100px; font-weight: bold">NA &nbsp;&nbsp;</td>
            <td class="no-borde-top letra_left" style="font-size: 8px">Copia del <span style="font-weight: bold">análisis de laboratorio</span> de la bebida alcoholica con Mezcal en cumplimiento con lo estipulado en la NMX-V-052-NORMEX-2016 y de los lote en <br>
                cumplimiento con el apartado 4.3 de la NOM-070-SCFI-2016 utilizado. </td>
        </tr>
        <tr>
            <td class="no-borde-top" colspan="2" style="font-weight: bold; font-size: 9px">La empresa se da por enterada que: la Unidad de Verificación establecerá una vigilancia de cumplimiento con la NOM permanente a sus instalaciones una vez que el Certificado NOM sea emitido. Para validar la información el OC podrá solicitar los documentos originales para su cotejo respectivo.
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="no-borde-top letra_right" style="width: 430px; padding-top: 0;padding-bottom: 0; font-size: 8px">Campo para uso exclusivo del personal <br> del OC-CIDAM</td>
            <td class="no-borde-top" style="font-weight: bold; background-color: #d8d8d8; width: 110px; padding-top: 0;padding-bottom: 0; font-size: 8px">N° DE SOLICITUD:</td>
            <td class="no-borde-top">&nbsp;</td>
        </tr>
    </table>

    <footer
    style="position: absolute; bottom: 38px; width: 100%; line-height: 0.9; text-align: right">
    <div style="font-size: 7px; text-align: right"> Solicitud de servicios NMX-V-052-NORMEX-2016 F7.1-04-07 Ed. 1 <br>
        Entrada en vigor. 21/11/2022
</footer>

</body>

</html>
