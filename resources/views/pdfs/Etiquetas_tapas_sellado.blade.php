<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiquetas Para Muestras</title>
    <style>
        @page {
            size: 292mm 227mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #3C8A69;
            margin: 60px 0;
            table-layout: fixed;
        }

        th,
        td {
            border: 2px solid #3C8A69;
            padding: 6px;
            text-align: center;
            word-wrap: break-word;
            height: 30px;
        }

        .header-cell {
            background-color: #3C8A69;
            color: white;
            font-weight: bold;
        }

        .section-title-cell {
            background-color: #3C8A69;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .highlight-white-cell {
            font-size: 12px;
        }

        .logo1 {
            width: 250px;
            height: auto;
        }

        .logo2 {
            width: 280px;
            height: auto;
        }

        .border-bottom-white {
            border-bottom: 2px solid #FFFFFF;
        }

        .border-right-white {
            border-right: 2px solid #FFFFFF;
        }

        .border-left-white {
            border-left: 2px solid #FFFFFF;
        }

        .border-green {
            border-color: #3C8A69 !important;
        }

        .title {
            background-color: #3C8A69;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border-bottom: 2px solid #FFFFFF;
        }

        .footer {
            width: 100%;
            margin-top: 20px;
            font-size: 12px;
            display: flex;
            /* justify-content: space-between; */
            /*  align-items: center; */
        }

        .footer-left {
            width: 65%;
            text-align: left;
            padding-right: 20px;
            /* box-sizing: border-box; */
            text-align: center;
        }

        .footer-right {
            text-align: right;
            width: 35%;
            margin-top: -60px;
            white-space: nowrap;
            font-size: 10px;
            padding-left: 650px;
        }
    </style>
</head>

<body>

    <!-- #1 tabla -->
    <br>
    <table class="top">
        <tr>
            <td rowspan="5"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección"
                    class="logo1"></td>
            <td colspan="2" class="title">Etiqueta para tapa de la <br> muestra</td>
            <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador"
                    class="logo2"></td>
        </tr>
        <tr>
            <td class="section-title-cell border-right-white">Fecha:</td>
            <td class="section-title-cell border-left-white">Producto:</td>
        </tr>
        <tr>
            <td class="highlight-white-cell border-right-white">
                {{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</td>
            <td class="highlight-white-cell border-left-white">
                {{ $datos->solicitud->lote_granel->categoria->categoria }} -
                {{ $datos->solicitud->lote_granel->clase->clase }}</td>
        </tr>
        <tr>
            <td class="section-title-cell border-right-white">No. de lote:</td>
            <td class="section-title-cell border-left-white">Folio o No.</td>
        </tr>
        <tr>
            <td class="highlight-white-cell border-right-white border-green">
                {{ $datos->solicitud->lote_granel->nombre_lote }}</td>
            <td class="highlight-white-cell border-left-white border-green">
                {{ $datos->solicitud->inspeccion->num_servicio }}</td>
        </tr>
    </table>
    <!-- #2 tabla -->
    <table class="top">
        <tr>
            <td rowspan="5"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección"
                    class="logo1"></td>
            <td colspan="2" class="title">Etiqueta para tapa de la <br> muestra</td>
            <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador"
                    class="logo2"></td>
        </tr>
        <tr>
            <td class="section-title-cell border-right-white">Fecha:</td>
            <td class="section-title-cell border-left-white">Producto:</td>
        </tr>
        <tr>
            <td class="highlight-white-cell border-right-white">
                {{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</td>
            <td class="highlight-white-cell border-left-white">
                {{ $datos->solicitud->lote_granel->categoria->categoria }} -
                {{ $datos->solicitud->lote_granel->clase->clase }}</td>
        </tr>
        <tr>
            <td class="section-title-cell border-right-white">No. de lote:</td>
            <td class="section-title-cell border-left-white">Folio o No.</td>
        </tr>
        <tr>
            <td class="highlight-white-cell border-right-white border-green">
                {{ $datos->solicitud->lote_granel->nombre_lote }}</td>
            <td class="highlight-white-cell border-left-white border-green">
                {{ $datos->solicitud->inspeccion->num_servicio }}</td>
        </tr>
    </table>
    <!-- #3 tabla -->
    <table class="top">
        <tr>
            <td rowspan="5"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección"
                    class="logo1"></td>
            <td colspan="2" class="title">Etiqueta para tapa de la <br> muestra</td>
            <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador"
                    class="logo2"></td>
        </tr>
        <tr>
            <td class="section-title-cell border-right-white">Fecha:</td>
            <td class="section-title-cell border-left-white">Producto:</td>
        </tr>
        <tr>
            <td class="highlight-white-cell border-right-white">
                {{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</td>
            <td class="highlight-white-cell border-left-white">
                {{ $datos->solicitud->lote_granel->categoria->categoria }} -
                {{ $datos->solicitud->lote_granel->clase->clase }}</td>
        </tr>
        <tr>
            <td class="section-title-cell border-right-white">No. de lote:</td>
            <td class="section-title-cell border-left-white">Folio o No.</td>
        </tr>
        <tr>
            <td class="highlight-white-cell border-right-white border-green">
                {{ $datos->solicitud->lote_granel->nombre_lote }}</td>
            <td class="highlight-white-cell border-left-white border-green">
                {{ $datos->solicitud->inspeccion->num_servicio }}</td>
        </tr>
    </table>
    <!-- Footer sin tablas -->
    <div class="footer">
        <div class="footer-left">
            <p>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michpacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
        </div>
        <div class="footer-right">
            <p>F-UV-04-04 <br> Edición 16, 15/07/2024</p>
        </div>
    </div>
</body>

</html>





<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            margin-top: -20;
        }

        .etiqueta-table {
            width: 100%;
            margin: 10px 0;
        }

        .etiqueta-table td,
        .etiqueta-table th {
            padding: 2px;
            font-size: 8px;
            border: 0.5px solid #595959;
            height: 17px;
        }

        .etiqueta-table .custom-title {
            font-size: 10px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border: 0.5px solid white;
        }

        .etiqueta-table .custom {
            font-size: 16px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border: 0.5px solid white;
        }

        .etiqueta-table .logo-small {
            max-width: 120px;
            height: auto;
        }

        .etiqueta-table .header-cell-custom {
            background: #3C8A69;
            color: white;
            text-align: center;
            border: 0.5px solid white;
        }

        .etiqueta-table .white-background-custom {
            background-color: white;
            color: black;
            border: 0.5px solid #3C8A69;
        }

        .etiqueta-table .border-green-custom {
            border: 1px solid #3C8A69;
        }

        .etiqueta-table .narrow-margin-custom {
            margin-top: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #3C8A69;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
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

        .top {
            margin-top: -20px;
        }
    </style>
</head>

<body>

    <!-- Primera tabla -->
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}"
                        alt="Unidad de Inspección" class="logo-small"></td>
                <td colspan="6" class="custom">Etiqueta para muestra</td>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
                        alt="Organismo Certificador" class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title">Fecha:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</strong>
                </td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="custom-title">No. de lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="custom-title">Volumen del lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->volumen }} L</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Maguey Empleado:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong>
                </td>
                {{--                 <td colspan="3" class="white-background-custom"><strong>{{$datos->solicitud->lote_granel->tipos->nombre}} Maguey Espadín, Maguey Tobalá (A. angustifolia), (A. potatorum)</strong></td> --}}
                <td colspan="2" class="custom-title">Categoría y clase de mezcal:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->categoria->categoria }},
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Edad:</td>
                <td class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong></td>
                <td class="custom-title">Ingredientes:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</strong></td>
                <td class="custom-title">Estado del productor</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->estados->nombre }}</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="custom-title" style="text-align: left;">Marca:</td>
                <td colspan="3" class="white-background-custom"><strong>Por definir</strong></td>
                <td colspan="2" class="custom-title">Destino de la muestra:</td>
                <td colspan="2" class="white-background-custom"><strong>Laboratorio</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Lote de procedencia:</td>
                <td class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->lote_original_id ?? 'N/A' }}</strong></td>
                <td class="custom-title">No. de Fisicoquímico:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td colspan="3" class="custom-title">Tipo de análisis:</td>
            </tr>
            <tr>
                <td rowspan="2" class="custom-title" style="text-align: left;">Razón Social/ Productor:</td>
                <td rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td rowspan="2" class="custom-title">Domicilio:</td>
                <td colspan="2" rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->direccion_completa }}</strong></td>
                <td class="custom-title">Análisis Completo:</td>
                <td class="custom-title">Ajuste de Grado:</td>
                <td class="custom-title">Otros (indique):</td>
            </tr>
            @php
            $tipo = $datos->solicitud->tipo_analisis;
            @endphp
            <tr>
              <td class="white-background-custom"><strong>{{ $tipo == 1 ? 'x' : '' }}</strong></td>
              <td class="white-background-custom"><strong>{{ $tipo == 2 ? 'x' : '' }}</strong></td>
              <td class="white-background-custom"><strong>{{ !in_array($tipo, [1, 2]) ? 'x' : '' }}</strong></td>
          </tr>
            <tr>
                <td colspan="2" class="custom-title">Nombre y firma del inspector:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->inspector->name }}</strong>
                </td>
                <td colspan="2" class="custom-title">Nombre y firma del responsable:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Segunda tabla -->
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}"
                        alt="Unidad de Inspección" class="logo-small"></td>
                <td colspan="6" class="custom">Etiqueta para muestra</td>
                <td rowspan="3" class="border-green-custom"><img
                        src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador"
                        class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title">Fecha:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</strong>
                </td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="custom-title">No. de lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="custom-title">Volumen del lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->volumen }} L</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Maguey Empleado:</td>
                <td colspan="3" class="white-background-custom"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
                <td colspan="2" class="custom-title">Categoría y clase de mezcal:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->categoria->categoria }},
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Edad:</td>
                <td class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong></td>
                <td class="custom-title">Ingredientes:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</strong></td>
                <td class="custom-title">Estado del productor</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->estados->nombre }}</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="custom-title" style="text-align: left;">Marca:</td>
                <td colspan="3" class="white-background-custom"><strong>Por definir</strong></td>
                <td colspan="2" class="custom-title">Destino de la muestra:</td>
                <td colspan="2" class="white-background-custom"><strong>Laboratorio</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Lote de procedencia:</td>
                <td class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->lote_original_id ?? 'N/A' }}</strong></td>
                <td class="custom-title">No. de Fisicoquímico:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td colspan="3" class="custom-title">Tipo de análisis:</td>
            </tr>
            <tr>
                <td rowspan="2" class="custom-title" style="text-align: left;">Razón Social/ Productor:</td>
                <td rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td rowspan="2" class="custom-title">Domicilio:</td>
                <td colspan="2" rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->direccion_completa }}</strong></td>
                <td class="custom-title">Análisis Completo:</td>
                <td class="custom-title">Ajuste de Grado:</td>
                <td class="custom-title">Otros (indique):</td>
            </tr>
            @php
            $tipo = $datos->solicitud->tipo_analisis;
            @endphp
            <tr>
              <td class="white-background-custom"><strong>{{ $tipo == 1 ? 'x' : '' }}</strong></td>
              <td class="white-background-custom"><strong>{{ $tipo == 2 ? 'x' : '' }}</strong></td>
              <td class="white-background-custom"><strong>{{ !in_array($tipo, [1, 2]) ? 'x' : '' }}</strong></td>
          </tr>
            <tr>
                <td colspan="2" class="custom-title">Nombre y firma del inspector:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->inspector->name }}</strong>
                </td>
                <td colspan="2" class="custom-title">Nombre y firma del responsable:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Tercera tabla -->
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}"
                        alt="Unidad de Inspección" class="logo-small"></td>
                <td colspan="6" class="custom">Etiqueta para muestra</td>
                <td rowspan="3" class="border-green-custom"><img
                        src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador"
                        class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title">Fecha:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</strong>
                </td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="custom-title">No. de lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="custom-title">Volumen del lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->volumen }} L</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Maguey Empleado:</td>
                <td colspan="3" class="white-background-custom"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
                <td colspan="2" class="custom-title">Categoría y clase de mezcal:</td>
                <td colspan="2" class="white-background-custom"><strong>Mezcal Artesanal, Blanco o Joven</strong>
                </td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Edad:</td>
                <td class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong></td>
                <td class="custom-title">Ingredientes:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</strong></td>
                <td class="custom-title">Estado del productor</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->estados->nombre }}</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="custom-title" style="text-align: left;">Marca:</td>
                <td colspan="3" class="white-background-custom"><strong>Por definir</strong></td>
                <td colspan="2" class="custom-title">Destino de la muestra:</td>
                <td colspan="2" class="white-background-custom"><strong>Laboratorio</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Lote de procedencia:</td>
                <td class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->lote_original_id ?? 'N/A' }}</strong></td>
                <td class="custom-title">No. de Fisicoquímico:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td colspan="3" class="custom-title">Tipo de análisis:</td>
            </tr>
            <tr>
                <td rowspan="2" class="custom-title" style="text-align: left;">Razón Social/ Productor:</td>
                <td rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td rowspan="2" class="custom-title">Domicilio:</td>
                <td colspan="2" rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->direccion_completa }}</strong></td>
                <td class="custom-title">Análisis Completo:</td>
                <td class="custom-title">Ajuste de Grado:</td>
                <td class="custom-title">Otros (indique):</td>
            </tr>
            @php
            $tipo = $datos->solicitud->tipo_analisis;
            @endphp
            <tr>
                <td class="white-background-custom"><strong>{{ $tipo == 1 ? 'x' : '' }}</strong></td>
                <td class="white-background-custom"><strong>{{ $tipo == 2 ? 'x' : '' }}</strong></td>
                <td class="white-background-custom"><strong>{{ !in_array($tipo, [1, 2]) ? 'x' : '' }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="custom-title">Nombre y firma del inspector:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->inspector->name }}</strong>
                </td>
                <td colspan="2" class="custom-title">Nombre y firma del responsable:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>
    <!-- Footer sin tablas -->
    <div class="footer">
        <div class="footer-left">
            <p>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michpacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
        </div>
        <div class="footer-right">
            <p>F-UV-04-04 <br> Edición 16, 15/07/2024</p>
        </div>
    </div>
</body>

</html>





<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        table.unique-final-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        table.unique-final-table td,
        table.unique-final-table th {
            border: 1px solid #3C8A69;
            padding: 1px;
            text-align: center;
            vertical-align: middle;
            min-height: 10px;
            line-height: 1;
        }

        table.unique-final-table th {
            background: #f0e6cc;
        }

        table.unique-final-table .even {
            background: #fbf8f0;
        }

        table.unique-final-table .odd {
            background: #fefcf9;
        }

        table.unique-final-table .header-cell {
            background-color: #3C8A69;
            color: white;
            font-weight: bold;
            border: 1px solid white;
        }

        table.unique-final-table .logo-cell {
            background-color: white;
            border: 1px solid #3C8A69;
        }

        table.unique-final-table .logo-cell img {
            max-width: 140px;
            height: auto;
        }

        table.unique-final-table td.title-white-border {
            border-bottom: 1px solid #FFFFFF;
        }

        .custom-logo {
            max-width: 120px !important;
            height: auto;
        }
    </style>
</head>

<body>

    <!-- Tabla 7 -->
    <table class="unique-final-table top">
        <tbody>
            <tr>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo" class="custom-logo">
                </td>
                <td colspan="6" class="title title-white-border">Etiqueta para sellado de tanques</td>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo">
                </td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">Fecha:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</strong>
                </td>
                <td class="header-cell" style="font-size: 10px;">Folio / No. de servicio:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">No. de lote:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Volumen del lote:</td>
                <td colspan="2" style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->volumen }}
                        L</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px;">Razón Social / Productor:</td>
                <td colspan="3" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre de la marca:</td>
                <td colspan="2" style="font-size: 10px;"><strong>Por definir</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">Categoría y clase:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->categoria->categoria }},
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Especie de agave:</td>
                <td style="font-size: 10px;"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
                <td class="header-cell" style="font-size: 10px;">Edad:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Ingredientes:</td>
                <td style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">No. de Análisis Fisicoquímicos:
                </td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">ID del tanque:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->id_tanque ?? 'N/A' }}</strong>
                </td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">No. de certificado NOM:</td>
                <td colspan="2" style="font-size: 10px;"><strong>{{$datos->solicitud->lote_granel->certificadoGranel->num_certificado}}</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px; text-align: left;">Nombre y firma del
                    inspector:</td>
                <td colspan="3" style="font-size: 10px;"><strong>{{ $datos->inspector->name }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre y firma del responsable:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Tabla 8 -->
    <table class="unique-final-table top">
        <tbody>
            <tr>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo" class="custom-logo">
                </td>
                <td colspan="6" class="title title-white-border">Etiqueta para sellado de tanques</td>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo">
                </td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">Fecha:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</strong>
                </td>
                <td class="header-cell" style="font-size: 10px;">Folio / No. de servicio:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">No. de lote:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Volumen del lote:</td>
                <td colspan="2" style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->volumen }}
                        L</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px;">Razón Social / Productor:</td>
                <td colspan="3" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre de la marca:</td>
                <td colspan="2" style="font-size: 10px;"><strong>Por definir</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">Categoría y clase:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->categoria->categoria }},
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Especie de agave:</td>
                <td style="font-size: 10px;"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
                <td class="header-cell" style="font-size: 10px;">Edad:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong>
                </td>
                <td class="header-cell" style="font-size: 10px;">
                    {{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</td>
                <td style="font-size: 10px;"><strong>NA</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">No. de Análisis Fisicoquímicos:
                </td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">ID del tanque:</td>
                <td style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->id_tanque ?? 'N/A' }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">No. de certificado NOM:</td>
                <td colspan="2" style="font-size: 10px;"><strong>{{$datos->solicitud->lote_granel->certificadoGranel->num_certificado}}</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px; text-align: left;">Nombre y firma del
                    inspector:</td>
                <td colspan="3" style="font-size: 10px;"><strong>{{ $datos->inspector->name }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre y firma del responsable:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>


    <!-- Tabla 7 -->
    <table class="unique-final-table top">
        <tbody>
            <tr>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo" class="custom-logo">
                </td>
                <td colspan="6" class="title title-white-border">Etiqueta para sellado de tanques</td>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo">
                </td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">Fecha:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</strong>
                </td>
                <td class="header-cell" style="font-size: 10px;">Folio / No. de servicio:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">No. de lote:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Volumen del lote:</td>
                <td colspan="2" style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->volumen }}
                        L</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px;">Razón Social / Productor:</td>
                <td colspan="3" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre de la marca:</td>
                <td colspan="2" style="font-size: 10px;"><strong>Por definir</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">Categoría y clase:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->categoria->categoria }},
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Especie de agave:</td>
                <td style="font-size: 10px;"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
                <td class="header-cell" style="font-size: 10px;">Edad:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong>
                </td>
                <td class="header-cell" style="font-size: 10px;">Ingredientes:</td>
                <td style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">No. de Análisis Fisicoquímicos:
                </td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">ID del tanque:</td>
                <td style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->id_tanque ?? 'N/A' }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">No. de certificado NOM:</td>
                <td colspan="2" style="font-size: 10px;"><strong>{{$datos->solicitud->lote_granel->certificadoGranel->num_certificado}}</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px; text-align: left;">Nombre y firma del
                    inspector:</td>
                <td colspan="3" style="font-size: 10px;"><strong>{{ $datos->inspector->name }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre y firma del responsable:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Footer sin tablas -->
    <div class="footer">
        <div class="footer-left">
            <p>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michpacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
        </div>
        <div class="footer-right">
            <p>F-UV-04-04 <br> Edición 16, 15/07/2024</p>
        </div>
    </div>
</body>

</html>
