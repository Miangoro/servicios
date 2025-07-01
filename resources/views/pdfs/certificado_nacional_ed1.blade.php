<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de venta nacional</title>
    <style>
        @page {
            size: 227mm 292mm;
            margin-top: 30;
            margin-left: 80px;
            margin-right: 25px;
            margin-bottom: 1px;
        }

        body {
            font-family: Helvetica;
            font-size: 11.6px;
            padding-top: 23%;
            padding-right: 4px;
            padding-left: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed; /* Esto asegura que las columnas tengan un ancho fijo */
        }

        td {
            border: 1px solid #366091;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
        }

        .td-margins {
            border-right: none;
            border-left: none;
        }

        .titulos {
            font-size: 15px;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .titulo2 {
            text-align: center;
            padding: 10px;
        }

        .img-fondo {
            position: fixed;
            top: 250px;
            left: 100px;
            width: 530px;
            height: 444px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/logo_fondo.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.1;
        }

        .img-nacional {
            position: fixed;
            top: 130px;
            left: -80px;
            width: 100px;
            height: 740px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/nacional.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .encabezado {
            position: fixed;
            width: 100%;
            top: -2%;
            left: 0;
        }

        .cidam {
            color: #161c4a;
            text-align: center;
            display: inline-block;
            margin-top: 7.5%;
            margin-left: -9px;
        }

        .footer {
            position: fixed;
            bottom: 11;
            right: 5;
            width: 100%;
            z-index: 9999;
            /* Para que el pie de página se mantenga encima de otros elementos */
            font-family: Arial, sans-serif;
            /*padding-bottom: 2px; /*espacio al fondo si es necesario */
        }

        .img-footer {
            /*background-image: url("{{ public_path('img_pdf/pie_certificado.png') }}");*/
            background-size: cover;
            /* ajusta img al contenedor */
            background-position: center;
            width: 705px;
            height: 50px;
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
            z-index: -1;
        }
    </style>
</head>

<body>
<!-- Aparece la marca de agua solo si la variable 'watermarkText' tiene valor -->
@if ($watermarkText)
    <div class="watermark-cancelado">
        Cancelado
    </div>
@endif

<div class="img-fondo"></div>
<div class="img-nacional"></div>

<!--ENCABEZADO-->
<div class="encabezado">
    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" style="width: 340px; vertical-align: top; margin-left: -13px" alt="logo de CIDAM 3D">

    <div class="cidam">
        <b style="font-size: 17.5px;">CENTRO DE INNOVACIÓN Y DESARROLLO<br>AGROALIMENTARIO DE MICHOACÁN A.C.</b>
        <p style="font-size: 11px; margin-top: 0px;">Organismo de Certificación de producto acreditado ante la
            <br>entidad mexicana de acreditación ema A.C. con <b>No. 144/18</b>
        </p>
    </div>

    <div class="titulos" style="margin-top: -2%;">CERTIFICADO DE VENTA NACIONAL</div>
    <table>
      <tr>
        <td style="font-weight: bold; text-align: center; border:none">
            Número de Certificado:</td>
        <td style="font-weight:bold; font-size: 11px; text-align: left;border:none">
            {{ $data->num_certificado ?? 'No encontrado' }}
        </td>
        <td style="font-weight: bold; text-align: right;padding-right: 20px; border:none">
            Fecha de<br>expedición:</td>
        <td style="font-weight: bold; text-align: right; border:none">
            {{ $expedicion }}
        </td>
        <td style="font-weight: bold;  text-align: right; padding-right: 20px; border:none">
            Vigencia de 90 días<br>naturales:</td>
        <td style="font-weight: bold; text-align: right;padding-right: 20px; border:none">
            {{ $vigencia }}
        </td>
      </tr>
    </table>
</div>

<!--PIE DE PAGINAS-->
<div class="footer">
    <p style="text-align: right; font-size: 8px; margin-bottom: 1px; line-height: 1.3;">
        @if ($id_sustituye)
            <!-- Aparece solo si tiene valor -->
            Cancela y sustituye al certificado con clave: {{ $id_sustituye }}
        @endif
        <br>Certificado de venta nacional F7.1-01-39 Ed 1
        <br>Entrada en vigor: 19-08-2021
    </p>
    
    <img class="img-footer" src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="pie de pagina">
</div>



    <div class="titulos">DATOS GENERALES</div>
    <table>
    <tr>
        <td class="td-margins" style="width: 25%; font-weight: bold; font-size: 12px; padding-top: 10px;padding-bottom: 10px;">
            Nombre o razón social:</td>
        <td colspan="3" class="td-margins">
            {{ mb_strtoupper($empresa) }}
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px; padding-top: 8px;padding-bottom: 8px;">
            Domicilio:</td>
        <td class="td-margins" style="width: 45%; font-size: 10.6px; padding-top: 8px; padding-bottom: 8px;">
            {{ mb_strtoupper($domicilio) }}
        </td>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;">
            código Postal:</td>
        <td class="td-margins">
            {{ $cp }}
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px; padding-top: 8px;padding-bottom: 8px;">
            País</td>
        <td colspan="3" class="td-margins" style="padding-right: 8%;">
            MÉXICO&nbsp;
        </td>
    </tr>
    </table>
    <table>
    <tr>
        <td class="td-margins" style="width: 25%; font-weight: bold; font-size: 12px; padding-top: 6px;padding-bottom: 6px;">
            Registro Federal de Contribuyentes:</td>
        <td class="td-margins">
            {{ $rfc }}
        </td>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;">
            Registro de productor Autorizado:</td>
        <td class="td-margins">
            {{ $DOM }}
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px; padding-top: 6px;padding-bottom: 6px;">
            Certificado de cumplimiento con la norma:</td>
        <td class="td-margins">
            {{ $certificado_granel }}
        </td>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;">
            Número de Convenio de corresponsabilidad:</td>
        <td class="td-margins">
            {{ $convenio }}
        </td>
    </tr>
    </table>


<!--INICIO DE TABLAS LOTES-->
    <div class="titulos">DESCRIPCIÓN DEL PRODUCTO QUE AMPARA EL CERTIFICADO</div>
    <table>
        
    <tr>
        <td
            style="font-weight: bold; font-size: 12px; height: 30px; width: 12%;">
            Categoría:</td>
        <td style="width: 22%;">
            {{ $categoria }}
        </td>
        <td style="font-weight: bold; font-size: 12px; width: 12%;">
             Clase:</td>
        <td style="width: 22%;">
            {{ $clase }}
        </td>
        <td style="font-weight: bold; font-size: 12px; width: 12%;">
            % Alc. Vol. en etiqueta: </td>
        <td>
            {{ $cont_alc }}
        </td>
    </tr>
    <tr>
        <td rowspan="2" style="font-weight: bold; font-size: 12px; height: 30px;">
            Marca:</td>
        <td rowspan="2">
            &nbsp;{{ $marca }}
        </td>
        <td rowspan="2" style="font-weight: bold; font-size: 12px;">
            Presentación:</td>
        <td rowspan="2">
            {{ $presentacion }} {{ $unidad }}
        </td>
        <td style="font-weight: bold; font-size: 12px; padding: 6px">
            Botellas:</td>
        <td>
            {{ $botellas }}
        </td>
    </tr>

    <tr>
        <td style="font-weight: bold; font-size: 12px; padding: 6px">
            Cajas:</td>
        <td>
            {{ $cajas }}
        </td>
    </tr>

    <tr>
        <td style="font-weight: bold; font-size: 12px; padding: 6px;">
            Folios de holograma:</td>
        <td colspan="5">
            {{ $hologramas }}
        </td>
    </tr>

    <tr>
        <td style="font-weight: bold; font-size: 12px; height: 30px">
            Dictamen envasado:</td>
        <td>
            &nbsp;{{ $dictamen_envasado }}</td>
        <td style="font-weight: bold; font-size: 12px;">
            No Lote envasado</td>
        <td>
            {{ $lote_envasado }}
        </td>
        <td style="font-weight: bold; font-size: 12px;">
            Número de análisis:</td>
        <td>
            {{ $analisis_fq }}
        </td>
    </tr>

    <tr>
        <td style="font-weight: bold; font-size: 12px; height: 45px; width: 12%;">
            Envasado en:</td>
        <td style="text-align: justify; font-size: 10.6px;">
            {{ $envasado_en }}
        </td>
        <td style="font-weight: bold; font-size: 12px; width: 12%;">
            No. Lote granel:</td>
        <td style="font-size: 12px; width: 22%;">
            {{ $lote_granel }}
        </td>
        <td style="font-weight: bold; font-size: 12px; width: 12%;">
            Número de SKU:
        </td>
        <td>
            {{ $sku }}
        </td>
    </tr>
    
    </table>
<!-- FIN DE TABLAS LOTES -->


<br>
    <div class="titulos" style="padding:14px">DESTINATARIO</div>
    <table>
    <tr>
        <td class="td-margins" style="text-align: right; font-weight: bold; font-size: 12px; border-top: none; width: 12%;">
            Nombre:</td>
        <td class="td-margins" style="text-align: left; border-top: none; padding-left: 6px;">
            VENTA NACIONAL
        </td>
    </tr>
    <tr>
        <td class=" td-margins" style="text-align: right; font-weight: bold; font-size: 12px; padding-top: 8px; padding-bottom: 8px;">
            Domicilio:</td>
        <td class="td-margins" style="text-align: left; padding-left: 6px;">
           VENTA EN TERRITORIO NACIONAL
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="text-align: right; font-weight: bold; font-size: 12px;">
            Estado:</td>
        <td class="td-margins" style="text-align: left; padding-left: 6px;">
            REPUBLICA MEXICANA
        </td>
    </tr>
    </table>

    <p style="font-size: 8px">
        El presente certificado se emite para fines de venta nacional conforme a la norma oficial Mexicana
        de mezcal NOM-070-SCFI-2016. Bebidas Alcohólicas-MezcalEspecificaciones, en cumplimiento con lo 
        dispuesto en la Ley Federal de Infraestructura de la Calidad.
        Este documento no debe ser reproducido en forma parcial.
    </p>
    

    <div class="titulo2"><b>AUTORIZÓ</b></div>
    <div class="titulo2" style="margin-top: 0;">
        <b>{{ $data->firmante->name }}<br>{{ $data->firmante->puesto }}</b>
    </div>




</body>
</html>
