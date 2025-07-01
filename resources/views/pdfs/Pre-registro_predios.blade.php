<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F-UV-21-01 Pre-registro de predios de maguey o agave Ed.1 Vigente</title>

    <style>
  /*  @font-face {
        font-family: 'calibri';
        src: url('fonts/calibri-regular.ttf') format('truetype');
    }

    @font-face {
        font-family: 'calibri-bold';
        src: url('fonts/calibri-bold.ttf') format('truetype');
    }

    @font-face {
        font-family: 'century';
        src: url('fonts/Century Schoolbook Bold.otf') format('truetype');
    }*/

    body {
        margin: 0;
        padding: 0;
        position: relative;
        padding-bottom: 30px; /* Espacio para el footer */
    }

    .header img {
        display: block;
        width: 275px; 
        margin-top: -20px;
    }

    .description1-container {
        position: absolute;
        top: 10px; 
        right: 0;  
        text-align: right; 
    }

    .description1 {
        font-family: 'calibri';
        font-size: 15px;
        line-height: 1;
        display: inline-block;
        width: auto; 
        white-space: nowrap; 
        border-bottom: 1px solid black;
        padding-bottom: 5px;
        padding-left: 40px; 
    }

    .title {
        font-family: 'calibri-bold';
        font-size: 23px;
        text-align: center;
        margin-top: 0px;
    }

    .sub-title {
        font-weight: bold;
        font-size: 13px;
        color: #008080;
    }

    .first-letter {
        font-weight: bold;
        font-size: 13px;
        margin-right: 40px;
        margin-left: 90px;
        color: #008080;
    }

    table , td, th {
        margin-left:25px;
        font-size: 13px;
        width: 93.5%;
        height: auto;
	    border: 2px solid #006666;
	    border-collapse: collapse;
        text-align: center; 
        vertical-align: middle; 
    }

    td, th {
	    padding: 3px;
	    width: 30px;
	    height: 25px;
    }

    th {
	    background: #f0e6cc;
    }

    .even {
	    background: #fbf8f0;    
    }

    .odd {
	    background: #fefcf9;
    }

    .no-border-right {
        border-right: 2px solid #ffffff; 
    }

    .text {
        font-family: 'calibri';
        font-size: 12px;
        text-align: center;
        margin-top:50px;
        margin-left: 70px; 
        margin-right: 70px; 
    }

    .footer {
        position: absolute;
        bottom: 0;
        right: 0;
        text-align: right;
        width: 100%;
        font-size: 12px;
    }

    .colorx {
        font-weight: bold;
        color: #1F497D;
    }

    .left{
        text-align: left;
    }
    </style>

</head>
<body>

<div class="header">
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo UVEM" width="275px">
</div>

<div class="description1-container">
    <div class="description1">
        Pre-registro de predios de maguey o agave F-UV-21-01<br>Edición 1, 15/07/2024

     
    </div>
</div>

<p class="title">Pre-registro de predios de maguey o agave</p>

<p class="sub-title"><span class="first-letter">I.</span>Datos del productor de agave o maguey</p>
<table>
	<tbody>
		<tr>
			<td><strong>Nombre del productor</strong><br>(Name of producer)</td>
			<td colspan="3">{{ $datos->empresa->razon_social }}</td>
		</tr>
		<tr>
			<td style="width: 87px"><strong>Número de cliente</strong><br>(client number)</td>
			<td>{{ $datos->empresa->empresaNumClientes[0]->numero_cliente }}</td>
			<td style="width: 90px"><strong>Número de teléfono</strong><br>(phone number)</td>
			<td>{{ $datos->empresa->telefono }}</td>
		</tr>
		<tr>
			<td><strong>Dirección fiscal</strong><br>(Fiscal address)</td>
			<td style="width: 150px">{{ $datos->empresa->domicilio_fiscal }}</td>
			<td><strong>Correo electrónico</strong><br>(email)</td>
			<td>{{ $datos->empresa->correo }}</td>
		</tr>
		<tr>
			<td><strong>Fecha de servicio</strong></td>
			<td>{{ $datos->solicitudes[0]->inspeccion->fecha_servicio ?? '----' }}</td>
			<td><strong>Dirección del punto de reunión</strong></td>
			<td>----</td>
		</tr>
	</tbody>
</table><br>

<p class="sub-title"><span class="first-letter">II.</span>Datos del predio de agave o maguey</p>
<table>
	<tbody>
		<tr>
			<td  class="left"><strong>Nombre del predio</strong><br>(Property name)</td>
			<td colspan="3">{{ $datos->nombre_predio }}</td>
		</tr>
		<tr>
			<td  class="left"><strong>Ubicación del predio</strong><br>(Location of the property)</td>
			<td>{{ $datos->ubicacion_predio }}</td>
			<td><strong>Tipo de predio</strong><br>(Type of property)</td>
			<td  class="left"><strong>Comunal <u> {{ $comunal }} </u> </strong><br>
            <strong>Ejidal <u> {{ $ejidal }} </u></strong><br>
            <strong>Propiedad Privada  {{ $propiedad }} </strong><br>
            <strong>Otro:  {{ $otro }} </strong>        
        </td>
		</tr>
		<tr>
        <td class="no-border-right left"><strong>Puntos de referencia:</strong><br>(Points of reference)</td>
            <td colspan="3">{{ $datos->puntos_referencia }}</td>
		</tr>
	</tbody>
</table><br>

<p class="sub-title"><span class="first-letter">III.</span>Datos de geo-referenciación del predio</p>
<table>
	<tbody>
		<tr>
			<td style="width: 20px; max-width: 20px; overflow: hidden; white-space: nowrap; text-align: center; vertical-align: middle; padding: 0; border: 1px solid #000;"><strong>Superficie</strong> (area)</td>
			<td>{{ $datos->superficie }} Ha</td>
		</tr>
	</tbody>
</table><br>

<p class="sub-title"><span class="first-letter">IV.</span>Datos del predio de agave o maguey</p>
<table>
	<tbody>
		<tr>
			<td><strong>Nombre del maguey</strong><br>(Type of maguey)</td>
			<td><strong>Especie de agave</strong><br>(Species of agave)</td>
			<td><strong>No. De plantas</strong><br>(Number of plants)</td>
			<td><strong>Edad (años)</strong><br>(Age (years)</td>
			<td><strong>Tipo de plantación</strong><br>(Type of plantation)</td>
		</tr>

    
        @foreach ($datos->predio_plantaciones as $plantacion) 
            <tr style="height: 5px">
                <td>{{ $plantacion->tipo->nombre }}</td>
                <td>{{ $plantacion->tipo->cientifico }}</td>
                <td>{{ $plantacion->num_plantas }}</td>
                <td>{{ $plantacion->anio_plantacion }}</td>
                <td>{{ $plantacion->tipo_plantacion }}</td>
		    </tr>
        @endforeach
     

	</tbody>
</table>

<p class="text">Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser
distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>


<div class="footer">
        Página 1 de 1
        <p class="colorx">No. de acreditación UVNOM129 Aprobación por DGN 312.01.2017.1017</p>
    </div>
</body>
</html>
