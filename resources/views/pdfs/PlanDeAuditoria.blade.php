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
            margin-left: 70px;
            margin-right: 70px;
            margin-top: 40px;
            margin-bottom: 10px;

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

        .negrita {

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

        .footer {
            position: absolute;
            transform: translate(0px, 180px);
            /* Mueve el elemento 50px en X y 50px en Y */
            text-align: center;
            font-size: 11px;
        }

        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 3px solid black;
            padding: 4px;
            font-size: 11px;
            text-align: center;
            font-family: 'Century Gothic';



        }

        th {
            background-color: black;
            color: white;
            text-align: center;

        }

        .td-border {
            border-bottom: 3px solid black;
            border-top: none;
            border-right: 3px solid black;
            border-left: 3px solid black;

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
            text-align: right;
        }

        .header img {
            float: left;
            max-width: 165px;
            padding: 0;
            margin-top: -30px;
            margin-left: -30px;


        }

        .img-background {
            position: absolute;
            top: 400px;
            left: -385px;
            width: 780px;
            height: 650px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/logo_fondo.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.2;
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
    </style>
</head>

<body>
    <div class="img-background"></div>

    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div style="padding-right: 20px">Plan de auditoría de esquema de certificación NOM-070-SCFI-2016
            F7.1-01-13<br>Edición 2 Entrada en Vigor: 08/03/2023
            <br>_______________________________________________________________________________________
        </div>
    </div>

    <body>
        <div style="text-align: right; font-size: 12px; padding-bottom: 10px">
            <span class="negrita">Plan de Auditoria.</span> No: SOL-12306 <br>
            <span class="negrita">Fecha de liberación del plan: </span>02 de Septiembre del 2024
        </div>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="4">1. DATOS GENERALES DEL CLIENTE</td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 150px">Nombre / Razón Social:</td>
                <td class="leftLetter" style="width: 240px">RMH ENSAMBLES, S.A. DE C.V.</td>
                <td class="letra-fondo" style="width: 110px">No. De <br>
                    Cliente:</td>
                <td class="leftLetter">RMH ENSAMBLES, S.A. <br>
                    DE C.V</td>
            </tr>
            <tr>
                <td class="letra-fondo">Dirección:</td>
                <td colspan="3" class="no-padding-up-down" style="font-size: 11px">Boulevard Fray Antonio de San
                    Miguel No. 519, Int. Lote
                    13, Col. Fray Antonio de San
                    Miguel, <br>
                    Morelia, Michoacán, C.P. 58277.</td>
            </tr>
            <tr>
                <td class="letra-fondo" rowspan="2">Persona de contacto:</td>
                <td class="leftLetter" rowspan="2">PRISCILIANO MARTÍNEZ</td>
                <td class="letra-fondo no-padding-up-down">Correo: </td>
                <td class="leftLetter no-padding-up-down">prisciliano_mtz@hotmail <br>.com
                </td>
            </tr>
            <tr>
                <td class="letra-fondo">Teléfono:</td>
                <td class="leftLetter">4432732647</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="4">2. DATOS DE LA AUDITORÍA
                </td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 150px">Servicio:</td>
                <td class="leftLetter" style="width: 240px">Dictamen de instalaciones</td>
                <td class="letra-fondo">Tipo de auditoría:</td>
                <td class="leftLetter">Certificación</td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 150px">Información adicional:</td>
                <td  style="width: 220px; color: red">- -</td>
                <td class="letra-fondo">Fecha de la <br>
                    auditoría:</td>
                <td class="leftLetter">02 de Septiembre del <br>
                    2024
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="letra-fondo td-border" style="font-size: 14px" colspan="2">3. DATOS DEL PRODUCTO</td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 250px">Producto(s): </td>
                <td class="leftLetter">No aplica</td>
            </tr>
            <tr>
                <td class="letra-fondo">País destino del producto:</td>
                <td style="color: red">- -</td>
            </tr>

        </table>
        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="2">4. CARACTERÍSTICAS DE LA AUDITORÍA
                </td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 200px">Objetivo:</td>
                <td class="leftLetter">Evaluar el cumplimiento de infraestructura y requisitos documentales de la Norma
                    NOM-070-SCFI-2016 y aplicación de las buenas prácticas de higiene y manufactura bajo</td>
            </tr>
            <tr>
                <td class="letra-fondo">Alcance:</td>
                <td class="leftLetter">Revisión documental in situ e inspección de instalaciones.</td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding-up-down">Criterios de evaluación:</td>
                <td class="leftLetter no-padding-up-down">NORMA OFICIAL MEXICANA NOM-070-SCFI-2016 <br>
                    NORMA OFICIAL MEXICANA NOM-251-SSA1-2009</td>
            </tr>
            <tr>
                <td class="letra-fondo">Otros (indique):</td>
                <td style="color: red">&nbsp;</td>
            </tr>
        </table>
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" class="background-img" >
        <footer style="text-align: center; font-size: 7px; margin-top: 175px; color: #71777c; margin-right: 50px">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
            puede <br>            
            ser distribuido externamente sin la autorización escrita del Director Ejecutivo

        </footer>
        <div class="page-break"></div>
        <div class="img-background"></div>

        <div class="header">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
            <div style="padding-right: 20px">Plan de auditoría de esquema de certificación NOM-070-SCFI-2016
                F7.1-01-13<br>Edición 2 Entrada en Vigor: 08/03/2023
                <br>_______________________________________________________________________________________
            </div>
        </div>
        <div style="height: 40px"></div>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="3">5. DATOS DEL GRUPO EVALUADOR
                </td>
            </tr>
            <tr>
                <td class="letra-fondo">Designación:</td>
                <td class="letra-fondo">Nombre: </td>
                <td class="letra-fondo">Teléfono y correo electrónico:</td>
            </tr>
            <tr>
                <td >Inspector</td>
                <td >Erik Antonio Mejía Vaca</td>
                <td>4521971634, emejia@erpcidam.com</td>
            </tr>
            <tr>
                <td>Auditor</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="5">6. DESCRIPCIÓN DE ACTIVIDADES DE
                    AUDITORÍA
                </td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding">Fecha:</td>
                <td class="letra-fondo no-padding">Inspector/ <br>
                    Auditor:</td>
                <td class="letra-fondo" style="width: 370px">Actividad:</td>
                <td class="letra-fondo no-padding">Horario:</td>
                <td class="letra-fondo no-padding">Aplica <br>
                    (Auditados)</td>
            </tr>
            <tr>
                <td class="no-padding">2024-09-02</td>
                <td class="no-padding">Erik Antonio <br>
                    Mejía Vaca</td>
                <td class="no-padding">Reunión de apertura</td>
                <td class="no-padding"></td>
                <td class="no-padding">Aplica</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="4">6. DESCRIPCIÓN DE ACTIVIDADES DE
                    AUDITORÍA
                </td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding-up-down">Nombre del Inspector:</td>
                <td class="no-padding-up-down" colspan="3">Erik Antonio Mejía Vaca
                </td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding-r-l">Acepta o rechaza el plan de <br>
                    auditoría:</td>
                <td style="width: 140px">Aprobado</td>
                <td class="letra-fondo no-padding-r-l">Nombre del cliente o persona <br>
                    autorizada que acepta o rechaza <br>
                    el plan
                </td>
                <td style="width: 140px">PRISCILIANO <br>
                    MARTÍNEZ</td>
            </tr>
            <tr>
                <td class="letra-fondo">Políticas:</td>
                <td class="leftLetter" style="font-size: 8px" colspan="3">1. Aceptar o rechazar el presente plan
                    de auditoria antes de 48 horas, de lo contrario se considera <br>
                    aceptado.<br>
                    2. Comunicarse previamente, mínimo 3 días previos a la auditoria, con el auditor asignado por el<br>
                    Organismo<br>
                    Certificador con la finalidad de coordinar la actividad en sitio.<br>
                    3. En caso de conflicto de interés, se debe notificar al Organismo de Certificación previamente.<br>
                    4. Para realizarel servicio de certificación se contratará una Unidad de Verificación y Laboratorios
                    de<br>
                    pruebas.</td>
            </tr>
        </table>
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" class="background-img" style="position: absolute">
        <footer style="text-align: center; font-size: 7px; margin-top: 315px; color: #71777c; margin-right: 50px">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
            puede <br>            
            ser distribuido externamente sin la autorización escrita del Director Ejecutivo

        </footer>
    </body>


</html>
