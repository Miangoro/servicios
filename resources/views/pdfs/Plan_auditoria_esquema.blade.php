<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de auditoría de esquema de certificación</title>

    <style>
        body {
            font-family: 'century gothic';
            margin: 0;
            padding: 0;
            height: 100%;
        }

        @page {
            margin: 100px 30px;
        }

        .header {
            position: fixed;
            top: -35px; 
            left: 30px;
            width: calc(100% - 60px);
            height: 100px; 
            overflow: hidden; 
        }

        .logo {
            margin-left: 30px;
            width: 150px;
            display: block;
        }

        .description1,
        .description2,
        .description3 {
            position: fixed;
            right: 30px;
            text-align: right;
        }

        .description1 {
            margin-right: 30px;
            top: -30px;
            font-size: 14px;
        }

        .description2 {
            margin-right: 30px;
            top: -10px;
            font-size: 14px;
        }

        .description3 {
            margin-right: 30px;
            top: 10px;
            font-size: 14px;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            width: 63%;
            display: inline-block;
        }

        .footer {
            position: absolute;
            bottom: 0; 
            left: 0; 
            right: 0; 
            text-align: center;
            font-size: 10px;
            font-family: Arial, sans-serif;
            padding: 10px 0; 
            background-color: white; 
            z-index: 100; 
            margin-left: 80px; 
            margin-right: 80px;
        }

        .footer .page-number {
            position: absolute;
            right: -10px;
            font-size: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        .content {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 80px; 
            margin-bottom: 70px; 
        }

        .content2 {
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 70px; 
        }

        .title {
            margin-left: 30px;
            font-family: 'century gothic negrita';
            text-align: left;
            width: 87.5%;
            margin-top: 35px;
            padding: 0px 10px 5px;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .title2 {
            margin-top: 80px; 
            margin-left: 30px;
            font-family: 'century gothic negrita';
            text-align: left;
            width: 87.5%;
            padding: 0px 10px 5px;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }


        .subtitle {
            margin-left: 30px;
            font-size: 15px;
            font-family: 'century gothic negrita';
            margin-top: 10px; 
        }

        .subtitle2 {
            margin-left: 30px;
            font-size: 15px;
            font-family: 'century gothic negrita';
            margin-top: 20px; 
        }

        .subtitle3 {
            margin-left: 30px;
            font-size: 15px;
            font-family: 'century gothic negrita';
            margin-top: 20px; 
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-left: 30px;
            line-height: 1;
            vertical-align: top;
            font-family: Arial, Helvetica, Verdana;
            font-size: 13px;
            font-family: 'century gothic';
            margin-top: 10px; 
        }

        td, th {
            border: 3px solid #4A86E8;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        td {
            width: auto; 
        }

        .column {
            background-color: #93B0D4;
            vertical-align: middle;
            font-family: 'century gothic negrita';
        }

        
        .column-x {
            text-align: justify;
            background-color: #93B0D4;
            vertical-align: middle; 
            font-family: 'century gothic negrita';
        }

        .column-text {
            text-align: center;
            vertical-align: middle; 
            font-family: 'century gothic negrita';
        }

        .custom-table {
            width: 100%;
            margin-top: 10px; 
        }

        .custom-table td {
            vertical-align: middle;
            text-align: center;
        }

        .custom-table .wide-col {
            width: 140px; 
        }

        .custom-table .narrow-col {
            width: 40px; 
        }

        .custom-table .empty-col {
            width: 60px;
        }

        .century {
            font-family: 'century gothic negrita', sans-serif;
        }

        .column-c {
            vertical-align: middle; 
            text-align: center;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">
    </div>

    <div class="description1">Plan de auditoría de esquema de certificación</div>
    <div class="description2">NMX-V-052-NORMEX-2016 F7.1-04-15</div>
    <div class="description3">Ed. 0 Entrada en vigor: 12/09/2022</div>

    <div class="content">
        <p class="title">Plan de Auditoría. No:</p>
        <p class="subtitle">1.- DATOS GENERALES DEL CLIENTE</p>
        <table>
            <tbody>
                <tr>
                    <td class="column" style="width: 150px;">Nombre / Razón Social del cliente</td>
                    <td style="width: 150px;">Lorem ipsum dolor sit amet consectetur!</td>
                    <td class="column" style="width: 100px;">No. De Cliente:</td>
                    <td>Lorem ipsum dolor sit amet consectetur!</td>
                </tr>
                <tr>
                    <td class="column">Dirección Fiscal:</td>
                    <td colspan="3">Lorem ipsum dolor sit amet consectetur!</td>
                </tr>
                <tr>
                    <td rowspan="2" class="column">Persona de contacto:</td>
                    <td rowspan="2" style="text-align: center; vertical-align: middle;">Lorem ipsum dolor sit amet consectetur!</td>
                    <td class="column">Correo Electrónico:</td>
                    <td>Lorem ipsum dolor sit amet consectetur!</td>
                </tr>
                <tr>
                    <td class="column">Teléfono:</td>
                    <td>Lorem ipsum dolor sit amet consectetur!</td>
                </tr>
            </tbody>
        </table>

        <p class="subtitle2">2.- DATOS DE LA AUDITORÍA</p>
        <table>
            <tbody>
                <tr>
                    <td class="column" style="width: 140px;">Fecha de liberación de plan:</td>
                    <td colspan="2" style="width: 60px;">00/00/0000</td>
                    <td class="column" colspan="2" style="width: 40px; text-align: center;">Fecha de auditoría:</td>
                    <td colspan="2" style="width: 50px;">00/00/0000</td>
                </tr>
                <tr>
                    <td rowspan="3" class="column" style="text-align: center;">Tipo de Auditoría:</td>
                    <td class="column-c">X</td>
                    <td class="column-text">Certificación</td>
                    <td class="column-c">X</td>
                    <td class="column-text">Re-certificación</td>
                    <td class="column-c">X</td>
                    <td class="column-text">Vigilancia no programada</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="column-c">X</td>
                    <td class="column-text">Extraordinaria</td>
                    <td class="column-c">X</td>
                    <td class="column-text">Ampliación de alcance</td>
                    <td class="column-c">X</td>
                    <td class="column-text">Reducción de alcance</td>
                </tr>
            </tbody>
        </table>

        <p class="subtitle3">3.- ESQUEMA DE CERTIFICACIÓN</p>
        <table>
	<tbody>
		<tr>
			<td class="column-c" style="width: 140px; background-color: #93B0D4"> <span class="century">Esquema de certificación <br></span> Bebidas alcohólicas que contienen Mezcal NMX-V-052-NORMEX-2016.</td>
			<td class="column-c" style="width: 40px;">X</td>
			<td class="column-text" style="width: 100px;">Bebidas alcohólicas preparadas</td>
			<td class="column-c" style="width: 40px;">X</td>
			<td class="column-text">Cócteles</td>
			<td class="column-c" style="width: 40px;">X</td>
			<td class="column-text" style="width: 100px;">Licores o cremas</td>
		</tr>
	</tbody>
</table>
</div>

    <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido
        externamente sin la autorización escrita del Director Ejecutivo
        </div>
        <div class="page-number">1/3</div>
    </div>

    <div class="page-break"></div>
    
    <div class="content2">
    <p class="title2">Plan de Auditoría. No:</p>

    <p class="subtitle">4.- DATOS DEL PRODUCTO</p>
    <table>
	<tbody>
		<tr>
			<td class="column" style="width: 150px; text-align: center;">Producto (s):
            </td>
			<td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
		</tr>
		<tr>
			<td class="column" style="width: 150px; text-align: center;">Países destino del producto:</td>
			<td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
		</tr>
	</tbody>
</table>

<p class="subtitle2">5.- CARACTERÍSTICAS DE LA AUDITORÍA</p>
<table>
	<tbody>
		<tr>
			<td class="column" style="width: 150px; text-align: center;">Objetivo:</td>
			<td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
		</tr>
		<tr>
			<td class="column" style="width: 150px; text-align: center;">Alcance:</td>
			<td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
		</tr>
		<tr>
            <td class="column" style="width: 150px; text-align: center; white-space: nowrap;">Criterios de evaluación:</td>
			<td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
		</tr>
		<tr>
			<td class="column" style="width: 150px; text-align: center;">Otros (indique):</td>
			<td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
		</tr>
	</tbody>
</table>

<p class="subtitle3">6.-DATOS DEL GRUPO EVALUADOR</p>
<table>
	<tbody>
		<tr>
			<td class="column" style="text-align: center; width: 100px;">Designación: </td>
			<td class="column" style="text-align: center; width: 200px;">Nombre:</td>
			<td class="column" style="text-align: center; width: 170px;">Teléfono y correo electrónico:</td>
		</tr>
		<tr>
			<td style="height: 10px;">Lorem ipsum.</td>
			<td>Lorem ipsum dolor sit amet</td>
			<td>Lorem ipsum dolor sit amet</td>
		</tr>
		<tr>
			<td style="height: 10px;">Lorem ipsum </td>
			<td>Lorem ipsum dolor sit amet</td>
			<td>Lorem ipsum dolor sit amet</td>
		</tr>
		<tr>
			<td style="height: 10px;">Lorem ipsum </td>
			<td>Lorem ipsum dolor sit amet</td>
			<td>Lorem ipsum dolor sit amet</td>
		</tr>
	</tbody>
</table>

        <p class="subtitle3">7. DESCRIPCIÓN DE ACTIVIDADES DE AUDITORÍA</p>
        <table>
            <tbody>
                <tr>
                    <td class="column" style="text-align: center;">Fecha</td>
                    <td class="column" style="text-align: center;  width: 100px;">Inspector/Auditor</td>
                    <td class="column" style="text-align: center;">Actividad</td>
                    <td class="column" style="text-align: center;">Horario</td>
                    <td class="column" style="text-align: center;">Aplica(auditados)</td>
                </tr>
                <tr>
                    <td style="height: 10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height: 10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height: 10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        </div>

<div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido
        externamente sin la autorización escrita del Director Ejecutivo
        </div>
        <div class="page-number">2/3</div>
    </div>

    <div class="page-break"></div>

    <div class="content2">
    <p class="title2">Plan de Auditoría. No:</p>
    
    <p class="subtitle3">8. ACUERDOS AUDITORÍA</p>
    <table>
        <tbody>
            <tr>
                <td class="column" style="text-align: center; width: 200px;  height: 30px;">Nombre y firma del Auditor:</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td class="column" style="text-align: center; width: 200px;">cepta o rechaza el plan de Auditoría:</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td class="column" style="text-align: center; width: 200px;">Nombre del cliente o persona autorizada que acepta o rechaza el plan:</td>
                <td></td>
                <td class="column" style="text-align: center; width: 100px;">Firma:</td>
                <td></td>
            </tr>
            <tr>
                <td class="column-x" style="text-align: center; width: 200px;">Políticas:</td>
                <td colspan="3">1. Aceptar o rechazar el presente plan de auditoría antes de 48
                horas, de lo contrario se considera aceptado. <br>
                2. Comunicarse previamente, mínimo 3 días previos a la auditoría,
                con el auditor asignado por el Organismo Certificador con la
                finalidad de coordinar la actividad en sitio. <br>
                3. En caso de conflicto de interés, se debe notificar al Organismo
                de Certificación previamente. <br>
                4. Para realizar el servicio de certificación se contratará una Unidad
                de Verificación y Laboratorio de pruebas.</td>
            </tr>
        </tbody>
    </table>
    </div>

    <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido
        externamente sin la autorización escrita del Director Ejecutivo
        </div>
        <div class="page-number">3/3</div>
    </div>
</body>
</html>
