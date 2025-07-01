<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden de servicio</title>
    <style>

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        body {
            font-family: 'Century Gothic', sans-serif;
        }

        @page {
            margin-left: 70px;
            margin-right: 70px;
            margin

        }

        .header {
            text-align: right;
            font-size: 12px;
            margin-right: -30px;

        }

        .title {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
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
            border: 2px solid #006666;
            padding: 4px;
            font-size: 11.5px;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;

        }

        .td-margins {
            border-bottom: none;
            border-top: none;
            border-right: 1px solid #006666;
            border-left: 1px solid #006666;
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
        }

        .no-margin-top {
            margin-top: 0;
        }

        .negrita{
            font-family: 'Century Gothic Negrita';
        }
    </style>
</head>

<body>
    <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" style="width: 140px; float: left;margin-left: -30px;"
        class="no-margin-top" alt="Logo CIDAM" class="logo">

    <div class="header">
        <p>
            Orden de servicio F-UV-02-01<br>
            Edición 5, 15/07/2024 <br>
            _______________________________________________________________________________________
        </p>
    </div>
    <div class="title negrita">
        ORDEN DE SERVICIO
    </div>
    <table>
        <tr>
            <td class="leftLetter" style="background-color: #93cddc">Datos del cliente(Nombre, <br> teléfono, correo)
            </td>
            <td class="leftLetter">
                <span class="negrita">{{ $datos->solicitud->empresa->razon_social ?? '' }}</span><br>
                <span class="negrita">{{ $datos->solicitud->empresa->telefono ?? ''}}</span><br>
                <span class="negrita">{{ $datos->solicitud->empresa->correo ?? '' }}</span>
            </td>
            <td class="leftLetter" style="background-color: #93cddc">No. de orden de <br> servicio:</td>
            <td class="leftLetter"><span class="negrita">{{ $datos->num_servicio ?? ''}}</span></td>

        </tr>
        <tr>
            <td class="leftLetter" style="background-color: #93cddc">Número de cliente:</td>
            <td class="leftLetter"> <span class="negrita">{{ $datos->solicitud->empresa->empresaNumClientes[0]->numero_cliente ?? ''}}</span></td>
            <td class="leftLetter" style="background-color: #93cddc">Hora del servicio:</td>
            <td class="leftLetter"></td>
        </tr>
        <tr>
            <td class="leftLetter" style="background-color: #93cddc">Inspector asignado:</td>
            <td class="leftLetter"><span class="negrita">{{ $datos->inspector->name ?? ''}}</span></td>
            <td class="leftLetter" style="background-color: #93cddc">Fecha de servicio:</td>
            <td class="leftLetter"><span class="negrita">{{ $fecha_servicio }}</span></td>
        </tr>
        <tr>
            <td class="leftLetter" style="background-color: #93cddc">Nombre de la persona que <br> atenderá la visita:
            </td>
            <td class="leftLetter"></td>
            <td class="leftLetter" style="background-color: #93cddc">No. de contrato:</td>
            <td class="leftLetter"></td>
        </tr>
        <tr>
            <td class="leftLetter" style="background-color: #93cddc" >Dirección del servicio: <br> &nbsp;</td>
            <td class="leftLetter" colspan="3" ><span class="negrita">{{ $datos->solicitud->instalacion->direccion_completa ?? ''}}</span>.</td>
        </tr>


    </table>
    <br>
    <table>
        <tr>
            <td colspan="6" style="background-color: #93cddc"><b>Tipo de servicio</b></td>
        </tr>
        <tr style="background-color: #d9d9d9">
            <td>1</td>
            <td class="leftLetter">Registro de predio y/o agave</td>
            <td>&nbsp;</td>
            <td>6</td>
            <td class="leftLetter">Traslado de producto <br>
                terminado</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>2</td>
            <td class="leftLetter">Dictamen de cumplimiento de <br>
                instalaciones (unidad de producción)</td>
            <td>&nbsp;</td>
            <td>7</td>
            <td class="leftLetter">Revisión de etiqueta</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="background-color: #d9d9d9">
            <td>3</td>
            <td class="leftLetter">Dictamen de cumplimiento de <br>
                instalaciones (Envasadora)</td>
            <td>&nbsp;</td>
            <td>8</td>
            <td class="leftLetter">Vigilancia en la producción de <br>
                mezcal</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>4</td>
            <td class="leftLetter">Dictamen de cumplimiento de <br>
                instalaciones (Comercializadora)</td>
            <td>&nbsp;</td>
            <td>9</td>
            <td class="leftLetter">Vigilancia durante el envasado</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="background-color: #d9d9d9">
            <td>&nbsp;&nbsp;5&nbsp;&nbsp;</td>
            <td class="leftLetter">Ajuste, homogenización o muestreo</td>
            <td></td>
            <td>&nbsp;&nbsp;10&nbsp;&nbsp;</td>
            <td class="leftLetter">Vigilancia de producto <br>
                terminado</td>
            <td></td>
        </tr>
        <tr style="background-color: #93cddc">
            <td colspan="4"><b>Observaciones</b></td>
            <td colspan="2"><b>Aceptación de servicio</b></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="2">  
                
                @php
            use Illuminate\Support\Facades\Storage;
            $firma = $datos->inspector->firma ?? null;
            $firmaPath = $firma ? 'firmas/' . $firma : null;
        @endphp

        @if ($firma && Storage::disk('public')->exists($firmaPath))
            <img style="position: absolute; margin-top: 0; left: 60%;" height="50px"
            src="{{ public_path('storage/' . $firmaPath) }}">
        @endif

         {{ $datos->inspector->name ?? '' }} <br> {{ $datos->inspector->puesto ?? '' }}<br>
        ______________________________ <br>
                Nombre, fecha y firma <br> &nbsp;</td>
        </tr>


    </table>
    <div class="footer">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede
        ser
        <br>
        distribuido externamente sin la autorización escrita del Director Ejecutivo
    </div>

</body>

</html>
