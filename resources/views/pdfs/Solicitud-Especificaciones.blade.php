<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-UNIIC-001 Solicitud y especificaciones del Servicio para emisión de Constancias de Conformidad JUAN RAMÓN</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        @page {
            margin: 100px 30px;
        }

        .header {
            position: fixed;
            top: -65px; 
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
            top: -50px;
            font-size: 14px;
        }

        .description2 {
            margin-right: 30px;
            top: -30px;
            font-size: 14px;
        }

        .description3 {
            margin-right: 30px;
            top: -10px;
            font-size: 14px;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            width: 63%;
            display: inline-block;
        }

        .footer {
            position: absolute;
            bottom: -50px; 
            left: 60px;
            right: 60px;
            width: calc(100% - 60px);
            font-size: 11px;
            text-align: center;
        }

        .footer .page-number {
            position: absolute;
            right: -10px;
            font-size: 10px;
            top: -15px;
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
            text-align: center; 
            color: #F79646; 
            text-decoration: underline; 
            margin-top: -50px; 
            font-weight: bold; 
        }
        
        .title2 {
            margin-left: 30px; 
            text-align: center; 
            color: #1F497D; 
            margin-top: 20px; 
            font-weight: bold; 
            font-size: 18px;
            line-height: 2;
        }

        .title3 {
            text-align: center; 
            color: #1F497D; 
            margin-top: 90px; 
            font-weight: bold; 
            font-size: 16px;
            line-height: 2;
        }

        .subtitle {
            margin-left: 5px; 
            font-size: 14px;
            margin-bottom: -10px;
        }

        .subtitle2 {
            margin-left: 25px; 
            font-size: 14px;
            font-weight: bold; 
        }

        .subtitle3 {
            margin-top: -20px;
            margin-left: 25px; 
            font-size: 14px;
            font-weight: bold; 
            margin-bottom: 60px;
        }

        .subtitlex {
            margin-top: 30px;
            margin-left: 25px; 
            font-size: 14px;
            font-weight: bold; 
        }

        .subtitle-nn {
            margin-top: 2px;
            margin-left: 25px; 
            font-size: 13px;
            font-weight: bold; 
            margin-bottom: -2px; 
        }

        .subtitle4 {
            margin-top: -25px;
            margin-left: 25px; 
            font-size: 14px;
            font-weight: bold; 
        }



        table {
            width: 90%;
            border: 2px solid #1E4678;
            border-collapse: collapse;
            margin: auto;
            margin-top: -50px;
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

        .colum-n {
            vertical-align: middle;
            text-align: center;
            font-weight: bold; 
        }

        .colum-p {
            vertical-align: middle;
            text-align: center;
        }

        .colum-x {
            vertical-align: middle;
            text-align: center;
            text-align: justify;
        }

        .colum-s {
            vertical-align: middle;
            text-align: justify;
            font-weight: bold;
        }
        
        .bullet {
            margin-top: -10px;
            margin-left: 20px;
            margin-bottom: 20px; 
            line-height: 1.5; 
            font-size: 13px;
        }

        .table-container {
            display: inline-block; 
            vertical-align: top;
            margin-left: 350px;
            margin-top: -70px;
        }

        .my-table {
            border: 1px solid #E36C09; 
            border-collapse: collapse;
            width: 100%; 
        }

        .my-table td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .table-x {
            width: 40%;
            margin-top: 60px;
            margin-left: 20px;
        }

        .nota {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 450px;
            color: #243F60;
            font-weight: bold; 
            margin-top: -2px;
        }

        .nota2 {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 35px;
            color: #243F60;
            margin-top: 40px;
            font-weight: bold; 
        }

        .nota3 {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 35px;
            color: #243F60;
            margin-top: 1px;
            font-weight: bold; 
        }
        
        .img-botellas-right {
            float: right;
            margin-right: 100px;
            margin-top: -150px;
            width: 250px;
        }

        .final {
            margin-top:70px;
        }

        .t-final {
            margin-top: 40px;
            margin-left: 40px;
            color: #E36C09;
            font-size: 14px;
        }

        .cuadro {
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">
    </div>

    <div class="description1">R-UNIIC-001 Solicitud y especificaciones del Servicio para emisión de </div>
    <div class="description2">Constancias de Conformidad</div>
    <div class="description3">Edición 1 Entrada en Vigor: 19-08-2024</div>

    <div class="content">
        <p class="title">Datos generales del solicitante</p>
        <p class="subtitle"><strong>Fecha de solicitud del servicio:</strong></p>
    </div>

    <table>
	<tbody>
		<tr>
			<td class="colum-n">Nombre del cliente</td>
			<td class="colum-n">Nombre del Representante</td>
			<td colspan="2" class="colum-n">Domicilio fiscal</td>
		</tr>
		<tr>
			<td class="colum-n">Juan Ramón Rugarcía</td>
			<td class="colum-p">Juan Ramón Rugarcía</td>
			<td colspan="2" class="colum-n">Melchor Ocampo Interior 1, exterior 206 Santiago Momoxpan, San Pedro Cholula, Puebla C.P. 72775</td>
		</tr>
		<tr>
			<td class="colum-n">Número de teléfono</td>
			<td class="colum-n">Correo Electrónico</td>
			<td class="colum-n">RFC</td>
			<td class="colum-n">País Destino</td>
		</tr>
		<tr>
			<td class="colum-p">222 661 6883</td>
			<td class="colum-p">juanra.rugba97@gmail.com</td>
			<td class="colum-p">RUBJ971109GI3</td>
			<td class="colum-n">No aplica</td>
		</tr>
		<tr>
			<td colspan="2" class="colum-n">DOMICILIO DEL/LOS RESPONSABLES DEL PRODUCTO: (Indicando nombre, calle, número, código postal y entidad federativa)</td>
			<td colspan="2" class="colum-n">Melchor Ocampo Interior 1, exterior 206 Santiago Momoxpan, San Pedro Cholula, Puebla C.P. 72775</td>
		</tr>
	</tbody>
</table>

<p class="title2">
    <strong><u>Apartado para etiquetas de bebidas alcohólicas</u> <br> (NOM-142-SSA1/SCFI-2014 / NOM-199-SCFI-2017)</strong>
</p>


<p class="subtitle2">Marque con una X</p>

<ul>
    <li class="bullet">NOM-142-SSA1/SCFI-2014 Bebidas Alcohólicas</li>
    <li class="bullet">NOM-199-SCFI-2017 Producto Nacional</li>
    <li class="bullet">NOM-142-SSA1/SCFI-2014 y/o NOM-199-<br>SCFI-2017 Producto Importado</li>
</ul>
<div>

    <div class="table-container">
        <table class="my-table">
            <tr>
                <td style="width:30px; height: 15px">---</td>
            </tr>
            <tr>
                <td style="height: 15px">---</td>
            </tr>
            <tr>
                <td style="height: 40px">---</td>
            </tr>
        </table>
    </div>

    <div>
    <p class="subtitle3">I. Información de la Bebida Alcohólica</p> 
    </div>

    <table>
	<tbody>
		<tr>
			<td class="colum-n">Nombre / Denominación de la bebida alcohólica</td>
			<td class="colum-n">Categoría y/o Clasificación</td>
			<td class="colum-n">Presentación y Grado alcohólico</td>
			<td class="colum-n">Abocado o destilado con</td>
		</tr>
		<tr>
			<td style="height: 25px;" class="colum-p">---</td>
			<td class="colum-p">---</td>
			<td class="colum-p">---</td>
			<td class="colum-p">---</td>
		</tr>
		<tr>
			<td class="colum-n">Tipo de marca</td>
			<td class="colum-n">Nombre de la marca comercial del producto</td>
			<td class="colum-n">No. de Registro y No. Expediente de la marca</td>
			<td class="colum-n">País de Origen (Bebidas importadas)</td>
		</tr>
        <tr>
			<td style="height: 25px;" class="colum-p">---</td>
			<td class="colum-p">---</td>
			<td class="colum-p">---</td>
			<td class="colum-p">---</td>
		</tr>
		<tr>
			<td colspan="2" class="colum-x"><strong>&nbsp;&nbsp;&nbsp;INGREDIENTES DEL PRODUCTO (Bebidas alcohólicas preparadas, licores o cremas y todas las bebidas alcohólicas, que después de destiladas y/o antes de embotellar utilicen ingredientes opcionales y/o aditivos):</strong> 
            Enlistar todos los ingredientes sin excepción en orden decreciente:</td>
			<td colspan="2">
                1.<br>
                2.<br>
                3.<br>
                4.<br>
                5.<br>
            </td>
		</tr>
		<tr>
			<td colspan="2" style="height: 25px; vertical-align: middle;"><strong>&nbsp;&nbsp;&nbsp;Observaciones</strong></td>
			<td colspan="2" class="colum-p">---</td>
		</tr>
	</tbody>
</table>

    <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido
        externamente sin la autorización escrita del Director Ejecutivo
        </div>
        <div class="page-number">Página <strong>1</strong> de <strong>4</strong></div>
    </div>
    <div class="page-break"></div>

    <p class="subtitlex">II. Información de la Botella</p>

    <div class="table-x">
    <table>
	<tbody>
		<tr>
			<td style="width:40px;" class="colum-n">Altura</td>
			<td style="width:40px;" class="colum-n">Diámetro</td>
		</tr>
		<tr>
			<td   class="colum-p" style="height: 25px;"></td>
			<td  class="colum-p"></td>
		</tr>
	</tbody>
</table>
</div>

<p class="nota">Nota: Adjuntar imágenes y dimensiones de la botella o ficha técnica proporcionada por el proveedor.</p>

<img class="img-botellas-right" src="{{ public_path('img_pdf/Botellas.jpg') }}">

<p class="title3"><strong><u>Apartado para alimentos y bebidas no alcohólicas </u><br> NOM-051- SCFI/SSA1-2010 Mod. 27.03.2020</strong></p>

<p class="subtitle2">Marque con una X</p>

<ul>
    <li class="bullet">NOM-051- SCFI/SSA1-2010 Mod. 27.03.2020</li>
    <li class="bullet">NOM-051- SCFI/SSA1-2010 Mod. 27.03.2020 <br> Producto Importado</li>
    <li class="bullet">Etiquetado FDA</li>
</ul>

<div class="table-container">
        <table class="my-table">
            <tr>
            <td style="width:30px; height:10px; color: #E36C09;"><b>X</b></td>
            </tr>
            <tr>
                <td style="height: 25px">---</td>
            </tr>
            <tr>
                <td style="height: 25px">---</td>
            </tr>
        </table>
    </div>

    <p class="subtitle4">I. Información del Producto</p>

    <table>
	<tbody>
		<tr>
			<td class="colum-n">Nombre / Denominación del producto a verificar</td>
			<td class="colum-n">Presentación o contenido neto</td>
			<td colspan="2" class="colum-n">La caducidad del producto es menor o mayor a tres meses</td>
		</tr>
		<tr>
			<td class="colum-n">Café instantáneo TQ Café</td>
			<td class="colum-p">Charola con 20 vasos de 8oz surtida de 5 sabores (4 vasos de cada uno) </td>
			<td colspan="2" class="colum-p">Mayor a 3 meses </td>
		</tr>
		<tr>
			<td class="colum-n">Tipo de marca y clase de registro</td>
			<td class="colum-n">Nombre de la marca comercial del producto</td>
			<td class="colum-n">No. de Registro y No. Expediente de la marca</td>
			<td class="colum-n">País de Origen (Productos importados)</td>
		</tr>
		<tr>
			<td class="colum-n">Pendiente, en trámite por IMPI </td>
			<td class="colum-p">TQ café </td>
			<td>Pendiente</td>
			<td>No aplica </td>
		</tr>
		<tr>
        <td class="colum-s" colspan="2">&nbsp;&nbsp;&nbsp;<span style="background-color: yellow;">INGREDIENTES DEL PRODUCTO: Enlistar todos los ingredientes sin excepción en orden decreciente (de mayor a menor) según la formulación del producto, no es necesario mencionar las cantidades.</span></td>
        <td colspan="2">
            1.<br>
            2.<br>
            3.<br>
            4.<br>
            5.<br>
            6.<br>
            7.<br>
            8.<br>
            9.<br>
            10.<br>
        </td>
		</tr>
	</tbody>
</table>

<div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido
        externamente sin la autorización escrita del Director Ejecutivo
        </div>
        <div class="page-number">Página <strong>2</strong> de <strong>4</strong></div>
</div>


<div class="absolute">

<p class="nota2">Nota: Se debe indicar el agua añadida por orden de predominio, excepto cuando ésta forme parte de un ingrediente compuesto y la que se utilice en los procesos de cocción y reconstitución. No es necesario declarar el agua u otros ingredientes volátiles que se evaporan durante la fabricación.
</p><br>

<p class="subtitle3">I. Información del Producto</p>

<table>
    <tbody>
        <tr>
            <td colspan="3">Breve descripción del producto: </td>
        </tr>
        <tr>
            <td style="width: 250px; vertical-align: middle; position: relative;">
                ¿Se adicionan azúcares? 
                <div style="position: absolute; right: 10px; top: 8.5px;">
                    <div style="display: inline-block; border: 1px solid #1E4678; padding: 5px; margin-left: 10px;">
                        NO
                    </div>
                    <div style="display: inline-block; border: 1px solid #1E4678; padding: 5px;">
                        SI
                    </div>
                </div>
            </td>
            <td style="width:250px; vertical-align: middle;">En caso afirmativo, indique la cantidad que se añade en 100 g: </td>
            <td class="colum-p">---</td>
        </tr>
        <tr>
            <td style="vertical-align: middle; position: relative;">
                ¿Se adicionan aditivos? 
                <div style="position: absolute;  right: 10px; top: 8.5px;">
                    <div style="display: inline-block; border: 1px solid #1E4678; padding: 5px; margin-left: 10px;">
                        NO
                    </div>
                    <div style="display: inline-block; border: 1px solid #1E4678; padding: 5px;">
                        SI
                    </div>
                </div>
            </td>
            <td style="vertical-align: middle;">En caso afirmativo, indique la cantidad y tipo/s de aditivo que se añade en 100 g: </td>
            <td class="colum-p">---</td>
        </tr>
        <tr>
            <td style="vertical-align: middle; position: relative;">
                ¿Se adiciona cafeína? 
                <div style="position: absolute;  right: 10px; top: 8.5px;">
                    <div style="display: inline-block; border: 1px solid #1E4678; padding: 5px; margin-left: 10px;">
                        NO
                    </div>
                    <div style="display: inline-block; border: 1px solid #1E4678; padding: 5px;">
                        SI
                    </div>
                </div>
            </td>
            <td style="vertical-align: middle;">En caso afirmativo, indique la cantidad que se añade en 100 g:</td>
            <td class="colum-p">---</td>
        </tr>
        <tr>
            <td>
                Los valores de la tabla nutrimental fueron obtenidos por medio de:<br><br>
                &nbsp;&nbsp;&nbsp; <div style="display: inline-block; width: 20px; height: 20px; border: 1px solid #1E4678; vertical-align: middle; margin-right: 10px;"></div> 
                <strong>Análisis bromatológicos.</strong><br><br>
                &nbsp;&nbsp;&nbsp; <div style="display: inline-block; width: 20px; height: 20px; border: 1px solid #1E4678; vertical-align: middle; margin-right: 10px;"></div> 
                <strong>Tablas reconocidas.</strong><br><br>
                &nbsp;&nbsp;&nbsp; <div style="display: inline-block; width: 20px; height: 20px; border: 1px solid #1E4678; vertical-align: middle; margin-right: 10px;"></div> 
                <strong>Otro.</strong>
            </td>
            <td style="vertical-align: middle; text-align: left;">Observaciones:</td>
            <td class="colum-p">---</td>
        </tr>
    </tbody>
</table>



<p class="nota3">Nota: Adjuntar imágenes y dimensiones del empaque o contenedor del alimento o bebida no alcohólicas, así como el análisis bromatológico o documentación utilizada para la declaración nutrimental. En caso de que la declaración no haya sido obtenida por las opciones antes mencionadas; especificar en el apartado de observaciones como fue obtenida.
</div>

<div class="cuadrado" style="font-size: 11px; border: 1px solid #1F497D; margin-left: 20px;  margin-right: 20px;">
    <p class="subtitle-nn">III. TÉRMINOS Y CONDICIONES DEL SERVICIO</p>

    <ol class="cuadro">
        <li>
            Para iniciar la revisión de la Información Comercial es necesario enviar la <strong>etiqueta en imagen vectorial en formato electrónico (.pdf), en tamaño real, indicando las medidas de la etiqueta;</strong> así como una imagen del empaque o envase original en el que es comercializado.
        </li>
        <li>
            El cliente es acreedor de <strong>3 revisiones</strong> por etiqueta; el primer informe de revisión de etiqueta se entregará en un lapso de 8 a 10 días hábiles posteriores a la recepción de la etiqueta y documentación requerida para iniciar con el servicio.
        </li>
        <li>
            Una vez enviado el primer informe de revisión, el cliente cuenta con un plazo de <strong>5 días naturales</strong> para enviar las correcciones estipuladas en el mismo. Si la etiqueta sigue presentando incumplimientos, se emite un segundo informe en donde se especifican los no cumplimientos. El cliente cuenta con un plazo de <strong>3 días naturales</strong> para realizarlos y enviar la etiqueta corregida. En caso de no realizarlos en el tiempo establecido, el cliente deberá pagar nuevamente el servicio para ser retomado.
        </li>
        <li>
            Si la etiqueta no cumple en la tercera revisión, el cliente deberá pagar nuevamente el servicio para continuar con 3 nuevas revisiones.
        </li>
        <li>
            Los requisitos ya aprobados en una primera y segunda revisión no se incluyen en subsecuentes revisiones, por lo que se solicita no realizar modificaciones a los requisitos ya aceptados con anterioridad.
        </li>
        <li>
            Para el caso del uso de marcas no registradas ante el IMPI, es responsabilidad del interesado realizar los trámites correspondientes; lo anterior sin perjuicio en contra de cualquiera que tenga derecho legítimo sobre dicha marca.
        </li>
        <li>
            Se emitirá una Constancia de Conformidad únicamente a los productos importados que se presentarán ya etiquetados en el despacho aduanero correspondiente para su importación. Las etiquetas de productos importados deben ser revisadas previo a la importación del producto.
        </li>
        <p>Por este medio acepto los términos y condiciones de la revisión de etiquetado antes mencionados.</p>
    </ol>

    <div style="text-align: center; margin-top: 5px; line-height: 0.5;">
        <p><strong>NOMBRE Y FIRMA DE LA PERSONA QUE AUTORIZA</strong></p>
        <p style="font-size: 13px;"><strong><u>Juan Ramón Rugarcía</u></strong></p>
    </div>
</div>

<div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido
        externamente sin la autorización escrita del Director Ejecutivo
        </div>
        <div class="page-number">Página <strong>3</strong> de <strong>4</strong></div>
    </div>

    <div class="page-break"></div>

    <p class="t-final">(Campo exclusivo para personal de la Unidad de Inspección de Información Comercial)</p>

    <div class="final">
    <table>
	<tbody>
		<tr>
			<td colspan="2" rowspan="2"><strong>La unidad de Inspección tiene la experiencia técnica y los recursos adecuados para llevar a cabo el servicio.</strong></td>
			<td  class="colum-n"  style="background-color: #F79646; width: 100px;">si</td>
			<td  class="colum-n"  style="background-color: #F79646; width: 100px;">no</td>
		</tr>
		<tr>
			<td class="colum-p">x</td>
			<td class="colum-p"></td>
		</tr>
		<tr>
        <td class="colum-n" style="background-color: #F79646; width: 150px;">Nombre y firma del personal que revisa y valida la solicitud:</td>
			<td style="text-align: justify">Ing. Zaida Selenia Coronado Sánchez </td>
			<td  class="colum-n"  style="background-color: #F79646;">Fecha de revisión y validación</td>
			<td  class="colum-p" style="text-align: left">18/09/2024</td>
		</tr>
		<tr>
			<td  class="colum-n"  style="background-color: #F79646;">No. de solicitud:</td>
			<td> <strong>001-2024</strong></td>
			<td  class="colum-n"  style="background-color: #F79646;">Equipo a utilizar:</td>
			<td  class="colum-p" style="text-align: left">Pendiente</td>
		</tr>
	</tbody>
</table>
</div>

<div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido
        externamente sin la autorización escrita del Director Ejecutivo
        </div>
        <div class="page-number">Página <strong>4</strong> de <strong>4</strong></div>
</div>
</body>
</html>