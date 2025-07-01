<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificado como Envasador de Mezcal NOM-070-SCFI-2016 F7.1-01-36</title>
  <style>
    @page {
      size: 227mm 292mm;
      margin: 15mm;
    }

    body {
      font-family: 'Calibri', sans-serif;
      font-size: 13px;
      margin-top: 90px;
    }

    .watermark {
      position: absolute;
      top: 43%;
      left: 55%;
      width: 50%;
      height: auto;
      transform: translate(-50%, -50%);
      opacity: 0.3;
      z-index: -1;
    }

    .watermark-cancelado {
      font-family: Arial;
      color: red;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
      opacity: 0.5;
      letter-spacing: 3px;
      font-size: 150px;
      white-space: nowrap;
      z-index: -1;
    }

    .header img {
      float: left;
      margin-left: -10px;
      margin-top: -30px;
    }

    .description1 {
      font-size: 25px;
      font-weight: bold;
      text-align: right;
    }

    .description2 {
      font-weight: bold;
      font-size: 15px;
      color: #5A5768;
      white-space: nowrap;
      position: relative;
      top: -64px;
      left: 295px;
    }

    .description3 {
      font-weight: bold;
      margin-right: 30px;
      text-align: right;
      font-size: 15px;
      position: relative;
      top: -20px;
    }

    .text {
      font-size: 14.5px;
      line-height: 0.9;
      text-align: justify;
      position: relative;
      top: -5px;
    }

    .text1 {
      font-size: 15px;
      line-height: 1;
      text-align: justify;
      position: relative;
      top: -20px;
    }

    .title {
      font-size: 33px;
      padding: 0px;
      text-align: center;
      line-height: 0.5;
      margin-bottom: -10px;
      margin-top: -15px;

    }

    .title2 {
      margin-bottom: 5px;
      font-size: 32px;
      padding: 0px;
      text-align: center;
      line-height: 0.5;


    }

    .title3 {
      font-size: 19px;
      text-align: center;
      font-weight: bold;
      color: #0C1444;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      /*table-layout: fixed; /* Esto asegura que las columnas tengan un ancho fijo */
    }

    td {
      border: 0.5px solid black;
      text-align: center;
      font-size: 13.5px;
    }

    th {
      background-color: #608390;
      color: white;
      text-align: center;
      font-size: 13px;
    }

    .cidam {
      color: rgb(76, 80, 109);
      text-align: left;
      margin-left: 0;
      margin-right: 5;
      margin-bottom: 10px;
      font-family: 'Arial', sans-serif;
    }

    .td-margins {
      border-right: none;
      border-left: none;
      font-size: 13.5px;
    }

    .even {
      background: #fbf8f0;
    }

    .odd {
      background: #fefcf9;
    }

    .cell {
      border-right: 1px solid transparent;
      white-space: nowrap;
    }

    .cell1 {
      white-space: nowrap;
    }

    .cent {
      white-space: normal;
    }

    .signature {
      margin: 20px 10px;
      text-align: center;
      margin-top: 20px;
    }

    .signature-line {
      line-height: 10;
      border-top: 1px solid #000;
      width: 240px;
      margin: 0 auto;
      padding-top: 5px;
    }

    .signature-name {
      font-family: Arial;
      margin: 10px 0 0;
      font-size: 13px;
      font-weight: bold;
      line-height: 0.5;
    }

    .img-fondo {
      position: fixed;
      top: 50%;
      left: 50%;
      width: 450px;
      height: 350px;
      z-index: -1;
      background-image: url('{{ public_path('img_pdf/logo_fondo.png') }}');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
      opacity: 0.1;
      transform: translate(-50%, -50%);
    }

    .encabezado {
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
    }

    .footer {
    position: fixed;
    bottom: -45px;
    width: 100%;
    text-align: center;
}

    #tabla-principal td {
      line-height: 9px;
      overflow: hidden;
      border: solid 2.5px;
    }
  </style>
</head>

<body>

  @if ($watermarkText)
    <div class="watermark-cancelado">
    Cancelado
    </div>
  @endif
{{--   <div class="img-fondo"> <img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Fondo CIDAM" class="watermark">
  </div>
  <div class="encabezado"> <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
      style="width: 325px; float: left; margin-left: -15px; margin-top: -20px;" alt="logo de CIDAM 3D">

    <div class="cidam" style="margin-bottom: 10px"> <b style="font-size: 24px;">Centro de Innovación y Desarrollo
        <br>Agroalimentario de Michoacán, A.C</b> </div>
    <br> --}}

    <div class="description3" style="margin-right: 30px; text-align: right; font-size: 13px; margin-top: 20px;">
      <b>No. de Certificado: {{ $num_certificado }}</b>
    </div>


    <p class="text1">
      Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C. — Acreditado como organismo de certificación
      de producto con número de acreditación 144/18 ante la Entidad Mexicana de Acreditación, A.C. — otorga el
      siguiente:
    </p>

    <p class="title">CERTIFICADO</p>
    <p class="title2">COMO <strong>ENVASADOR DE MEZCAL</strong> A</p>

    <table>
      <tbody>
        <tr>
          <td class="td-margins"
            style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 7px;padding-bottom: 7px;">
            <strong>Razón social:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">
            {{ $razon_social }}
          </td>
          <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
            <strong>No. de
              cliente:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">
            {{ $numero_cliente }}
          </td>
        </tr>
        <tr>
          <td class="td-margins"
            style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 5px;padding-bottom: 5px;">
            <strong>Representante legal:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">
            {{ $representante_legal }}
          </td>
          <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
            <strong>RFC:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">{{ $rfc }}</td>
        </tr>
        <tr>
          <td class="td-margins"
            style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 4px;padding-bottom: 4px;">
            <strong>Domicilio Fiscal:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;" colspan="3">
            {{ $domicilio_fiscal }}
          </td>
        </tr>
        <tr>
          <td class="td-margins"
            style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 5px;padding-bottom: 5px;">
            <strong>Correo electrónico:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">{{ $correo }}
          </td>
          <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
            <strong>Teléfono:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">{{ $telefono }}
          </td>
        </tr>
        <tr>
          <td class="td-margins"
            style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 5px;padding-bottom: 5px;">
            <strong>Fecha de inicio de vigencia:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">
            {{ $fecha_emision }}
          </td>
          <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
            <strong> Fecha
              de vencimiento:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 5px;">
            {{ $fecha_vigencia }}
          </td>
        </tr>
      </tbody>
    </table>

    <p class="text">
      El presente certificado es emitido de acuerdo con la Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas
      Alcohólicas-Mezcal-Especificaciones, mediante el esquema de certificación para los siguientes productos con
      Denominación de Origen.
    </p>
    <table>
      <tbody>
        <tr>
          <td class="td-margins"
            style="text-align: right; font-weight: bold; font-size: 12px;  width: 12%; padding: 7px;">
            <strong>Categorías:</strong>
          </td>
          <td class="td-margins" style="text-align: left;  padding-left: 6px; padding: 7px;">
            {{ $categorias }}
          </td>
        </tr>
        <tr>
          <td class="td-margins"
            style="text-align: right; font-weight: bold; font-size: 12px;  width: 12%; padding: 7px;">
            <strong>Clases:</strong>
          </td>
          <td class="td-margins" style="text-align: left; padding-left: 6px; padding: 7px;">
            {{ $clases }}
          </td>
        </tr>
      </tbody>
    </table>
    <p class="text">
      Esta empresa ha demostrado que cuenta con la infraestructura, conocimientos y la práctica necesaria para ejecutar
      las etapas de envasado de la Bebida Alcohólica Destilada Denominada Mezcal, de conformidad con lo establecido en
      el apartado 5 de la NOM-070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones en las instalaciones descritas
      a continuación:
    </p>

    <table>
      <tbody>

        <tr>
          <td class="td-margins"
            style="width: 243px; font-weight: bold; font-size: 12px; padding-right: 4px; padding-left: 1px; padding-top: 7px; padding-bottom: 7px;">
            <strong>Domicilio de la unidad de envasado:</strong>
          </td>
          <td class="td-margins"
            style="text-align: left; padding-left: 12px; margin-left: 5px; padding-top: 7px; padding-bottom: 7px;">
            {{ $direccion_completa }}
          </td>
        </tr>
        <tr>
          <td class="td-margins"
            style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 7px;padding-bottom: 7px;">
            <strong>No. de dictamen de cumplimiento con la NOM:</strong>
          </td>
          <td class="td-margins"
            style="text-align: left; padding-left: 12px; margin-left: 5px; padding-top: 7px; padding-bottom: 7px;">
            {{ $num_dictamen }}
          </td>
        </tr>
      </tbody>
    </table>
    <p class="text">
      Dichas instalaciones cuentan con el equipo requerido para el envasado del producto Mezcal y se encuentran dentro
      de los estados y municipios que contempla la Resolución mediante la cual se otorga la protección prevista a la
      Denominación de Origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28 de
      Noviembre de 1994, así como sus subsecuentes modificaciones.
    </p>

    <div class="signature">
      <!--<img src="{{ public_path('img_pdf/firmapdf.jpg') }}" alt="Firma"
        style="display: block; margin: 0 auto; height: 50px; width: auto; position: relative; top: -20px;">-->
        <br>
        <br>
      <div class="signature-line"></div>
      <div class="signature-name">{{ $nombre_firmante }}</div>
      <div class="signature-name">{{ $puesto_firmante }}</div>
    </div>

    <br>
    <div class="footer">
      <p style="text-align: right; font-size: 9px; line-height: 1; margin-bottom: 1px;">
        @if ($id_sustituye)
      Cancela y sustituye al certificado con clave: {{ $id_sustituye }}
    @endif
        <br>Certificado como Envasador de Mezcal NOM-070-SCFI-2016 F7.1-01-36<br>
        Edicion 5 Entrada en vigor: 01/04/25
      </p>
            <div style="height: 52px;">
        <br><br><br>
      </div>
    {{--   <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="pie de pagina" width="705px"> --}}
    </div>

</body>

</html>
