<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F-UV-02-14 Ver 1, Dictamen de cumplimiento de Instalaciones maduracion de mezcal</title>

    <style>
        body {
            margin-left: 20px; 
            margin-right: 20px; 
        }

        .font-lucida-sans-seminegrita {
            font-family: 'Lucida Sans Seminegrita', sans-serif;
        }

        .container {
            margin-top: 0px;
            position: relative;
        }

        .header {
            margin-top: -30px; 
            width: 100%;
        }

        .header img {
            display: block;
            width: 275px; 
        }

        .description1,
        .description2,
        .description3,
        .textimg {
            position: absolute;
            right: 10px;
            text-align: right;
        }

        .description1 {
            font-size: 18px;
            color: #151442;
            font-family: 'Arial Negrita' !important;
            top: 5px; 
        }

        .description2 {
            color: #151442;
            font-family: 'Arial Negrita' !important;
            font-size: 9.5px;
            top: 30px; 
            font-size
        }

        .description3 {
            font-family: 'Lucida Sans Unicode';
            font-size: 10px;
            top: 42px; 
            margin-right: 40px; 
        }

        .textimg {
            font-weight: bold;
            position: absolute; 
            top: 100px;
            left: 10px; 
            text-align: left;
            font-size: 13px;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-family: 'Arial Negrita', Gadget, sans-serif;
            line-height: 20px;
            margin-top: 20px; 
        }

        .text {
            font-family: 'Lucida Sans Unicode';
            text-align: justify;
            font-size: 13px;
            line-height: 0.7;
            margin-right: 10px;
        }

        .textp {
            text-align: justify;
            font-size: 13px;
            line-height: 0.7;
            margin-right: 10px;
            font-family: 'Lucida Sans Seminegrita';
        }

        table {
            width: 100%;
            border: 2px solid #1E4678;
            border-collapse: collapse;
            margin: auto;
            font-size: 13px;
            line-height: 1;
            vertical-align: top;
            font-family: Arial, Helvetica, Verdana;
        }

        td, th {
            border: 2px solid #1E4678;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        td {
            width: 50%;
        }

        .center {
            text-align: center; 
            vertical-align: middle;
        }

        .sello {
            text-align: right;
            font-size: 11px;
            margin: 0;
            padding: 0;
            position: absolute;
            right: 70px;
            top: 710px;
            font-family: 'Arial Negrita' !important;
        }

        .image-right {
            position: absolute; 
            right: 10px; 
            top: -20px; 
            width: 240px;
        }

        .images-container {
            position: relative;
            display: flex;
            margin-top: 40px;
            width: 100%;
        }

        .textx, .textsello {
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }

        .textsello {
            text-align: left;
            font-size: 8px;
            margin: 0;
            padding: 0;
        }

        .footer-bar {
            position: fixed;
            bottom: -55px;
            left: -70px;
            right: -70px;
            width: calc(100% - 40px);
            height: 45px;
            background-color: #158F60;
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 10px 0px;
        }

        .footer-bar p {
            margin: 0; 
            line-height: 1;
        }

        .pie {
            text-align: right;
            font-size: 9px;
            line-height: 1;
            position: fixed;
            bottom: -4;
            left: 0;   
            right: 0;  
            width: calc(100% - 40px); 
            height: 45px;
            margin-right: 30px; 
            padding: 10px 0px;
            font-family: 'Lucida Sans Unicode';
        }
        .watermark-cancelado {
            font-family: Arial;
            color: red;
            position: fixed;
            top: 48%;
            left: 45%;
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            opacity: 0.5;
            /* Opacidad predeterminada */
            letter-spacing: 3px;
            font-size: 150px;
            white-space: nowrap;
            z-index:-1;
        }
    </style>
</head>
<body>

@if ($watermarkText)
    <div class="watermark-cancelado">
        Cancelado
    </div>
@endif

<div class="container">
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo UVEM" width="275px">
    </div>
    <br>
    <div class="description1">Unidad de Inspección No. UVNOM-129</div>
    <div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</div>
    <div class="description3">Acreditados ante la Entidad Mexicana de Acreditación, A.C</div>
    <div class="textimg font-lucida-sans-seminegrita">No.: UMC-00_/20</div>
    <div class="title">Dictamen de cumplimiento de Instalaciones como<br>ÁREA DE MADURACIÓN DE MEZCAL</div>
</div>

<p class="text">De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección No. UVNOM
129 para la revisión de procesos de producción del producto Mezcal, su envasado y comercialización;
y con fundamento en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la
Calidad que establece el funcionamiento de las Unidades de Inspección.</p>
<p class="text">Después de realizar la inspección de las instalaciones en fecha del <span class="font-lucida-sans-seminegrita"><u>{{ $fecha_inspeccion }}</u></span>
partiendo del acta circunstanciada o número de inspección: <u><span  class="font-lucida-sans-seminegrita">{{ $datos->inspeccione->num_servicio }}</u></span> se otorga el dictamen de
Instalaciones a:</p>

<p class="textp">Nombre del productor/empresa: <u>{{ $datos->inspeccione->solicitud->empresa->razon_social }}</u></p>

<table>
	<tbody>
		<tr>
			<td><strong>Domicilio Fiscal:</strong></td>
			<td class="center">{{ $datos->inspeccione->solicitud->empresa->domicilio_fiscal }}</td>
		</tr>
		<tr>
			<td><strong>Domicilio del área de maduración:</strong></td>
			<td class="center">{{ $datos->instalaciones->direccion_completa ?? '' }}</td>
		</tr>
		<tr>
			<td><strong>Categorías del mezcal:</strong></td>
			<td class="center">{{ !empty($categorias) && is_array($categorias) ? implode(', ', $categorias) : '' }}</td>
		</tr>
		<tr>
			<td><strong>Clases de mezcal que producen:</strong></td>
			<td class="center">{{ !empty($clases) && is_array($clases) ? implode(', ', $clases) : '' }}</td>
		</tr>
		<tr>
			<td><strong>Fecha de emisión de dictamen:</strong></td>
			<td class="center">{{ $fecha_emision }}</td>
		</tr>
		<tr>
			<td><strong>Fecha de vigencia del dictamen:</strong></td>
			<td class="center">{{ $fecha_vigencia }}</td>
		</tr>
	</tbody>
</table>

<p class="text">El presente dictamen ampara exclusivamente la maduración del producto mezcal que se elabora en las instalaciones
referidas en el presente documento. Dichas Instalaciones de maduración cuentan con la infraestructura y equipamiento
requerido para la producción de mezcal indicados en la NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal-Especificaciones
y se encuentran dentro de los estados y municipios que contempla la resolución mediante el cual se otorga la protección
prevista a la denominación de origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28
de noviembre de 1994, así como sus modificaciones subsecuente.</p>

<p class="sello">Sello de Unidad de Inspección</p>
    <div class="images-container">
    <img src="{{ public_path('img_pdf/qr_umc-074.png') }}" alt="Logo UVEM" width="90px">
    <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right">
    </div>
    <p class="textx" style="font-size: 10px; margin: 1;">
    <strong>AUTORIZÓ</strong>
    <span style="margin-left: 50px;">
        <strong>Gerente Técnico Sustituto de la Unidad de Inspección | BTG. Erik Antonio Mejía Vaca</strong>
    </span>
    </p>

    <p class="textx" style="font-size: 10px; margin: 1;">
    <strong>Cadena Origina</strong>
    <span style="margin-left: 29px;">
        <strong> UMG-159/2024|2024-06-26|UMS-1094/2024</strong>
    </span>
    </p>

    <p class="textx" style="font-size: 10px; margin: 1;">
    <strong>Sello Digital</strong>
    </p>

    <p class = "textsello">e2N1P+r+E79e0YxKzS/jMssKuASlmYXy2ppP+2PJN8vKUeFRxYTSY99MEWrgiHOnA N3pLUrdUBiD39v25Y648G4TK5qQ0LwZPLofRmjRQ2Ty5rHlDwnPRm37zaOkMjkRD<br>
    xC0ikyHPD+T3EFhEc9sgAFI6bZUd88yevfS+ZFZ7j9f5EA44Sz76jsN3P4e7lyePHmNz Jxg5ZupHICg5xBZu5ygOniMZNbzG6w0ZDPL58yoMQK1JDi8lwwiGJBaCNHN6krn<br>
    No5v5rvZPkbUthYT2r5M0sGP5Y+s97oLa8GA5hqyDAgE9P0d1u0uwU7Q8SF0GYfe lavijxvsWaZg5QA5og==
    </p>


     <p class="pie">
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>Entrada en vigor: 15-07-2024
        <br>F-UV-02-14 Ver 1.
    </p>

    <div class="footer-bar">
        <p class="font-lucida-sans-seminegrita">www.cidam.org . unidadverificacion@cidam.org</p>
        <p>Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
    </div>



</body>
</html>