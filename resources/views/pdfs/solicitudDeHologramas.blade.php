<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de Hologramas {{ $datos->folio }}</title>
    <style>

        body{
            font-weight: 12px;
        }
        @page {
            margin-left: 43px;
            margin-right: 43px;
            margin-top: 43px;
            margin-bottom: 43px;

        }

    /*    @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }*/

        .negrita{
          
            font-family:  'Century Gothic Negrita';
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
            border: 1.5px solid black;
            padding: 4px;
            font-size: 11.5px;
            text-align: center;
            font-family: 'Century Gothic';



        }

        th {
            background-color: black;
            color: white;
            text-align: center;

        }

        .td-border {
            border-bottom: none;
            border-top: none;
            border-right: 1px solid black;
            border-left: 1px solid black;

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
            vertical-align: top;
            padding-bottom: 8px;
            padding-top: 0;
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

        .no-padding{
            padding: 0;
        }

        .letra-fondo{
            color: white;
            font-size: 17px;
            background-color: #006fc0;
            padding-bottom: 18px;
            text-align: center;
            padding-top: 0;

        }

        .letra-up{
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;

        }

    </style>
</head>
<body>
    <table border="1">
        <tr>
          <td rowspan="3" >
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM"
            style="max-width: 125px; padding: 0;">
        </td>
          <td rowspan="3" class="title negrita"> Solicitud de hologramas</td>
          <td colspan="2" class="leftLetter " style="width: 180px"> <span class="negrita" style="margin: 0;">Identificación:</span> P7.1-01-05</td>
        </tr>
        <tr>
          <td colspan="2" class="leftLetter "> <span class="negrita" style="margin: 0;">Edición:</span> 3</td>
        </tr>
        <tr>
            <td colspan="2" class="leftLetter">
              <span class="negrita" style="margin: 0;">Inicio de Vigencia:</span> <br>15/08/2024
            </td>
          </tr>
          

      </table>

    <br>

    <table>
        <tr>
            <td colspan="2" class="td-no-border" style="width: 380px">&nbsp;</td>
            <td class="no-padding"> <p class="negrita" style="margin: 0"> Folio de solicitud:</p> </td>
            <td class="no-padding">{{ $datos->folio }}</td>
        </tr>
    </table>

    <br>
    <table>
        <tr>
            <td colspan="2" class="letra-fondo negrita">Solicita</td>
        </tr>
        <tr>
            <td class="rightLetter negrita" style="width: 250px">Nombre:</td>
            <td class="letra-up">{{ $datos->direcciones->nombre_recibe }}</td>
        </tr>
        <tr>
            <td class="rightLetter negrita">Puesto: </td>
            <td class="letra-up">Responsable de recibir hologramas</td>
        </tr>
        <tr>
            <td class="rightLetter negrita">Email: </td>
            <td class="letra-up">{{ $datos->direcciones->correo_recibe }}</td>
        </tr>
        <tr>
            <td style="border-bottom: 0;" colspan="2" class="letra-fondo negrita"> Dirección de envío</td>
        </tr>
    </table>

    <table>
<tr>
    <td colspan="4"> <br> {{$datos->direcciones->direccion}} <br><br>
    </td>
</tr>
<tr>
    <td colspan="4" class="letra-fondo negrita"> INFORMACIÓN DE QUIEN RECIBE EL PAQUETE DE HOLOGRAMAS
    </td>
</tr>
<tr>
    <td class="rightLetter negrita" style="width: 120px">Nombre Completo: </td>
    <td colspan="3" class="letra-up">{{ $datos->direcciones->nombre_recibe }}</td>
</tr>
<tr>
    <td class="rightLetter negrita">Email./Cel./Tel.: </td>
    <td colspan="3" class="letra-up">Email. {{ $datos->direcciones->correo_recibe }}, /Cel./Tel. {{ $datos->direcciones->celular_recibe }}</td>
</tr>

<tr>
    <td class="rightLetter negrita">Fecha de envío:</td>
    <td class="letra-up">{{$datos->fecha_envio}}</td>
    <td class="rightLetter negrita" style="width: 110px"> Fecha de recibido:</td>
    <td></td>
</tr>
<tr>
    <td class="rightLetter negrita" >Folio inicial:</td>
    <td class="letra-up">{{ $datos->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)?->numero_cliente }}-{{ $datos->tipo }}{{ $datos->marcas->folio }}{{ str_pad($datos->folio_inicial, 7, '0', STR_PAD_LEFT) }}</td>
    <td class="rightLetter negrita">Folio final:</td>
    <td class="letra-up">{{ $datos->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)?->numero_cliente }}-{{ $datos->tipo }}{{ $datos->marcas->folio }}{{ str_pad($datos->folio_final, 7, '0', STR_PAD_LEFT) }}</td>
</tr>
<tr>
    <td class="rightLetter negrita" >Total de hologramas <br>
        enviados:</td>
        <td colspan="3" class="letra-up">{{ number_format($datos->cantidad_hologramas) }} Hologramas</td>

</tr>
<tr >
    <td class="rightLetter negrita" style="height: 60px">Comentarios</td>
    <td colspan="3">{{$datos->comentarios}} <span class="negrita">Marca:</span> {{ $datos->marcas->marca }}</td>
</tr>
<tr>
    <td colspan="4">NOTA: Se solicita reenviar vía electrónica este acuse firmado para confirmar la llegada de hologramas. <div style="height: 50px"></div>
        _____________________________________________ <br>
        <p class="negrita">{{ $datos->direcciones->nombre_recibe }}</p>
        <div style="height: 10px"></div>
    </td>
</tr>
    </table>
    <div style="margin-bottom: 15px">
        <p style="font-size: 12px; margin-top: 60px; text-align: center">Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la
            autorización escrita del Director Ejecutivo.</p>
    </div>

</body>
</html>