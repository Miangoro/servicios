<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta de ingreso a barricas</title>
    <style>
        @page {
          size: 297mm 210mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: -10px;
            padding: -10px;
            margin-top: -10px;
        }

        .etiqueta-table {
          margin-bottom: -10px;
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            table-layout: fixed;
        }

        .etiqueta-table th,
        .etiqueta-table td {
            padding: 2px;
            border: 2px solid #3C8A69;
            text-align: center;
            vertical-align: middle;
            font-size: 13px;
            overflow: hidden;
        }

        .custom {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .customd {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-right: 2px solid white !important;
        }

        .customx {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
        }

        .custom-title {
            font-size: 18px !important;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .custom-titlex {
            font-size: 15px !important;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .footer-bar {
            position: fixed;
            bottom: -55px;
            right: 10px;
            width: calc(100% - 40px);
            height: 45px;
            font-size: 13px;
            text-align: right;
            padding: 30px 0px;
        }

        .offset-text {
            display: inline-block;
            margin-left: 150px;
        }

        .image-cell {
/*             width: 20px;
            height: 50px; */
            position: relative;
            text-align: center;
            vertical-align: middle;
        }


        .image-cellx {
/*             width: 20px;
            height: 50px; */
            text-align: center;
            vertical-align: middle;
        }

        .logo-small {
            max-width: 90%;
            max-height: 90%;
            height: auto;
            width: auto;
        }

        .logo-smallx {
            max-width:95%;
            max-height: 100%;
            height: auto;
            width: auto;
        }

        .bold {
            font-weight: bold;
            vertical-align: middle;
            text-align: center;
            padding: 5px;
        }

        .firma-container {
            text-align: center;
            vertical-align: middle;
        }

        .firma {
            width: 100px;
            height: auto;
            opacity: 0.7;
            margin-bottom: -5px;
           }

        .firma-text {
            font-size: 12px;
            text-align: center;
        }

    </style>
</head>
<body>

<table class="etiqueta-table">
    <tbody>
        <tr>
            <td colspan="2" rowspan="5" class="image-cell">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
            </td>
            <td colspan="5" class="custom-title">Etiqueta de ingreso a barricas</td>
            <td colspan="2" rowspan="5" class="image-cellx">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="custom-titlex">Nombre o Razón social: </td>
        </tr>
        <tr>
            <td colspan="5">{{ $datos->solicitud->empresa->razon_social }}</td>
        </tr>
        <tr>
            <td class="customd">No. de servicio:</td>
            <td class="customd">Fecha:</td>
            <td class="customd">Lote:</td>
            <td class="customd">Categoría:</td>
            <td class="customd">Clase:</td>
        </tr>
        <tr>
            <td>{{ $datos->solicitud->inspeccion->num_servicio }}</td>
            <td>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</td>
            <td>{{ $datos->solicitud->lote_granel->nombre_lote }}</td>
            <td>{{ $datos->solicitud->lote_granel->categoria->categoria }}</td>
            <td>{{ $datos->solicitud->lote_granel->clase->clase }}</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" class="custom">Fisicoquímico:</td>
            <td rowspan="2">{{ $datos->solicitud->lote_granel->folio_fq }}</td>
            <td colspan="2" rowspan="2" class="customx">Grado Alcohólico: </td>
            <td rowspan="2">{{ $datos->solicitud->lote_granel->cont_alc }}</td>
            <td class="custom">Barrica: </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="customx">De:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2" class="customx">Nombre y firma del inspector: </td>
            <td colspan="3" class="bold firma-container">
              <div class="firma-text">{{ $datos->inspector->name }}</div>

{{--               @php
              $firma = !empty($datos->inspector->firma)
                  ? 'storage/firmas/' . $datos->inspector->firma
                  : 'img_pdf/firma_Erik_Antonio_Mejía_Vaca_1744914296.png'; // esta imagen debe estar en /public/img_pdf/
          @endphp

          <img src="{{ asset($firma) }}" alt="Firma de {{ $datos->inspector->name }}" class="firma">
 --}}
          </td>
            <td class="customx">Nombre y firma del responsable:</td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">{{ $datos->solicitud->instalaciones->responsable }}</div>
                <!-- Lugar si hay firma -->
                <!-- <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma"> -->
            </td>
        </tr>
    </tbody>
</table>

<br>

<table class="etiqueta-table">
    <tbody>
        <tr>
            <td colspan="2" rowspan="5" class="image-cell">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
            </td>
            <td colspan="5" class="custom-title">Etiqueta de ingreso a barricas</td>
            <td colspan="2" rowspan="5" class="image-cellx">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="custom-titlex">Nombre o Razón social: </td>
        </tr>
        <tr>
            <td colspan="5">{{ $datos->solicitud->empresa->razon_social }}</td>
        </tr>
        <tr>
            <td class="customd">No. de servicio:</td>
            <td class="customd">Fecha:</td>
            <td class="customd">Lote:</td>
            <td class="customd">Categoría:</td>
            <td class="customd">Clase:</td>
        </tr>
        <tr>
          <td>{{ $datos->solicitud->inspeccion->num_servicio }}</td>
          <td>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</td>
          <td>{{ $datos->solicitud->lote_granel->nombre_lote }}</td>
          <td>{{ $datos->solicitud->lote_granel->categoria->categoria }}</td>
          <td>{{ $datos->solicitud->lote_granel->clase->clase }}</td>
      </tr>
        <tr>
          <td colspan="2" rowspan="2" class="custom">Fisicoquímico:</td>
          <td rowspan="2">{{ $datos->solicitud->lote_granel->folio_fq }}</td>
          <td colspan="2" rowspan="2" class="customx">Grado Alcohólico: </td>
          <td rowspan="2">{{ $datos->solicitud->lote_granel->cont_alc }}</td>
            <td class="custom">Barrica: </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="customx">De:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2" class="customx">Nombre y firma del inspector: </td>
{{--             <td colspan="3" class="bold firma-container">
                <div class="firma-text">{{ $datos->inspector->name }}</div>

            </td> --}}

            <td colspan="3" class="bold firma-container">
              <div class="firma-text">{{ $datos->inspector->name }}</div>
{{--               @php
              $firmaPath = public_path('storage/firmas/' . $datos->inspector->firma);
            @endphp

            @if (!empty($datos->inspector->firma) && file_exists($firmaPath))
                <img src="{{ asset('storage/firmas/' . $datos->inspector->firma) }}" alt="Firma {{ $datos->inspector->name }}" class="firma">
            @endif --}}
          </td>


            <td class="customx">Nombre y firma del responsable:</td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">{{ $datos->solicitud->instalaciones->responsable }}</div>
                <!-- Lugar si hay firma -->
                <!-- <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma"> -->
            </td>
        </tr>
    </tbody>
</table>

<br>

<table class="etiqueta-table">
    <tbody>
        <tr>
            <td colspan="2" rowspan="5" class="image-cell">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
            </td>
            <td colspan="5" class="custom-title">Etiqueta de ingreso a barricas</td>
            <td colspan="2" rowspan="5" class="image-cellx">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="custom-titlex">Nombre o Razón social: </td>
        </tr>
        <tr>
            <td colspan="5">{{ $datos->solicitud->empresa->razon_social }}</td>
        </tr>
        <tr>
            <td class="customd">No. de servicio:</td>
            <td class="customd">Fecha:</td>
            <td class="customd">Lote:</td>
            <td class="customd">Categoría:</td>
            <td class="customd">Clase:</td>
        </tr>
        <tr>
          <td>{{ $datos->solicitud->inspeccion->num_servicio }}</td>
          <td>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</td>
          <td>{{ $datos->solicitud->lote_granel->nombre_lote }}</td>
          <td>{{ $datos->solicitud->lote_granel->categoria->categoria }}</td>
          <td>{{ $datos->solicitud->lote_granel->clase->clase }}</td>
      </tr>
        <tr>
          <td colspan="2" rowspan="2" class="custom">Fisicoquímico:</td>
          <td rowspan="2">{{ $datos->solicitud->lote_granel->folio_fq }}</td>
          <td colspan="2" rowspan="2" class="customx">Grado Alcohólico: </td>
          <td rowspan="2">{{ $datos->solicitud->lote_granel->cont_alc }}</td>
            <td class="custom">Barrica: </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="customx">De:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2" class="customx">Nombre y firma del inspector: </td>
            <td colspan="3" class="bold firma-container">
              <div class="firma-text">{{ $datos->inspector->name }}</div>
{{--               @php
              $firmaPath = public_path('storage/firmas/' . $datos->inspector->firma);
            @endphp

            @if (!empty($datos->inspector->firma) && file_exists($firmaPath))
                <img src="{{ asset('storage/firmas/' . $datos->inspector->firma) }}" alt="Firma {{ $datos->inspector->name }}" class="firma">
            @endif --}}
          </td>
            <td class="customx">Nombre y firma del responsable:</td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">{{ $datos->solicitud->instalaciones->responsable }}</div>
                <!-- Lugar si hay firma -->
                <!-- <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma"> -->
            </td>
        </tr>
    </tbody>
</table>

<div class="footer-bar">
    <p>Entrada en vigor el 15 de julio del 2024<br>Página 1 /1 F-UV-04-04 Versión 16</p>
</div>
</body>
</html>
