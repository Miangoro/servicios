<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta para lotes de mezcal a granel</title>
    <style>
        @page {
            size: 292mm 227mm;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            margin-top: -20;
        }

        .etiqueta-table {
            width: 100%;
            margin-top: 0;
        }

        .etiqueta-table td,
        .etiqueta-table th {
            padding: 3px;
            font-size: 8px;
            border: 0.5px solid #595959;
            height: 22px;
        }

        .etiqueta-table .custom-title {
            font-size: 12px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-top: 1px solid white;
        }

        .etiqueta-table .custom {
            font-size: 23px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 1px solid white;
            height: 40px;
        }

        .etiqueta-table .logo-small {
            max-width: 180px;
            height: 75px;
        }

        .etiqueta-table .header-cell-custom {
            background: #3C8A69;
            color: white;
            text-align: center;
            border: 3px solid white;
        }

        .etiqueta-table .white-background-custom {
            background-color: white;
            color: black;
            font-size: 12px;
            border: 3px solid #3C8A69;
        }

        .etiqueta-table .border-green-custom {
            border: 3px solid #3C8A69;
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
            border: 2px solid #3C8A69;
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

        .footer {
            width: 100%;
            position: fixed;
            bottom: -50px;
            /* Siempre en la parte inferior */
            left: 0;
            /* Asegura que quede alineado con el borde izquierdo */
            font-size: 12px;
            display: flex;
            padding: 10px 10px;
            /* Espaciado interno */
            z-index: 100;
            /* Asegúrate de que esté por encima de otros elementos */
        }

        .footer-right {
            text-align: right;
            width: auto;
            white-space: nowrap;
            font-size: 12px;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>

<body>

    <!-- primera tabla -->
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom" style="width: 100px;"><img
                        src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
                </td>
                <td colspan="6" class="custom">Etiqueta para lotes de mezcal a granel</td>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
                        alt="Organismo Certificador" class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title" style="width: 120px;">Fecha:</td>
                <td colspan="2" class="white-background-custom"><strong> {{ $datos->fecha_servicio }}</strong></td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->num_servicio }}</strong></td>
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
                <td class="custom-title" style="text-align: left;">Razón Social / Productor:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td colspan="2" class="custom-title">Nombre de la marca:</td>
                <td colspan="2" class="white-background-custom"><strong>---</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Categoría y clase:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->categoria->categoria }} -
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong>
                </td>
                <td colspan="2" class="custom-title">Especie de agave: </td>
                <td colspan="2" class="white-background-custom" style="font-size: 8px;"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left; height: 34px; ">No. de Análisis Fisicoquímicos:</td>
                <td class="white-background-custom" style="font-size: 9px;">
                    <strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td colspan="2" class="custom-title" style="text-align: left;">ID del tanque: </td>
                <td class="white-background-custom" style="font-size: 9px;">
                    <strong>{{ $datos->solicitud->lote_granel->id_tanque ?? 'N/A' }}</strong>
                </td>
                <td colspan="2"class="custom-title">No. de certificado NOM:</td>
                <td class="white-background-custom" style="font-size: 9px;"><strong>{{$datos->solicitud->lote_granel->certificadoGranel->num_certificado ?? 'sin certificado'}}</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="font-size:11px; text-align: left;">Nombre y firma del inspector:</td>
                <td colspan="3" class="white-background-custom" style="font-size:11px;">
                    <strong>{{ $datos->inspector->name }}</strong></td>
                <td colspan="2" class="custom-title" style="font-size:11px; text-align: left;">Nombre y firma del
                    responsable:</td>
                <td colspan="2" class="white-background-custom" style="font-size: 11px;"><strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>
    {{-- segunda tabla --}}
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom" style="width: 100px;"><img
                        src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
                </td>
                <td colspan="6" class="custom">Etiqueta para lotes de mezcal a granel</td>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
                        alt="Organismo Certificador" class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title" style="width: 120px;">Fecha:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->fecha_servicio }}</strong></td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->num_servicio }}</strong></td>
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
                <td class="custom-title" style="text-align: left;">Razón Social / Productor:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td colspan="2" class="custom-title">Nombre de la marca:</td>
                <td colspan="2" class="white-background-custom"><strong>---</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Categoría y clase:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->categoria->categoria }} -
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong>
                </td>
                <td colspan="2" class="custom-title">Especie de agave: </td>
                <td colspan="2" class="white-background-custom" style="font-size: 8px;"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left; height: 34px; ">No. de Análisis Fisicoquímicos:</td>
                <td class="white-background-custom" style="font-size: 9px;">
                    <strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td colspan="2" class="custom-title" style="text-align: left;">ID del tanque: </td>
                <td class="white-background-custom" style="font-size: 9px;">
                    <strong>{{ $datos->solicitud->lote_granel->id_tanque ?? 'N/A' }}</strong></td>
                <td colspan="2"class="custom-title">No. de certificado NOM:</td>
                <td class="white-background-custom" style="font-size: 9px;"><strong>{{$datos->solicitud->lote_granel->certificadoGranel->num_certificado ?? 'Sin certificado'}}</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="font-size:11px; text-align: left;">Nombre y firma del inspector:</td>
                <td colspan="3" class="white-background-custom" style="font-size:11px;">
                    <strong>{{ $datos->inspector->name }}</strong></td>
                <td colspan="2" class="custom-title" style="font-size:11px; text-align: left;">Nombre y firma del
                    responsable:</td>
                <td colspan="2" class="white-background-custom" style="font-size: 11px;"><strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>
    {{-- tercera tabla --}}
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom" style="width: 100px;"><img
                        src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección"
                        class="logo-small"></td>
                <td colspan="6" class="custom">Etiqueta para lotes de mezcal a granel</td>
                <td rowspan="3" class="border-green-custom"><img
                        src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador"
                        class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title" style="width: 120px;">Fecha:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->format('Y-m-d') }}</strong>
                </td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->num_servicio }}</strong></td>
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
                <td class="custom-title" style="text-align: left;">Razón Social / Productor:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td colspan="2" class="custom-title">Nombre de la marca:</td>
                <td colspan="2" class="white-background-custom"><strong>---</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Categoría y clase:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->categoria->categoria }} -
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong>
                </td>
                <td colspan="2" class="custom-title">Especie de agave: </td>
                <td colspan="2" class="white-background-custom" style="font-size: 8px;"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left; height: 34px; ">No. de Análisis Fisicoquímicos:</td>
                <td class="white-background-custom" style="font-size: 9px;">
                    <strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td colspan="2" class="custom-title" style="text-align: left;">ID del tanque: </td>
                <td class="white-background-custom" style="font-size: 9px;">
                    <strong>{{ $datos->solicitud->lote_granel->id_tanque ?? 'N/A' }}</strong></td>
                <td colspan="2"class="custom-title">No. de certificado NOM:</td>
                <td class="white-background-custom" style="font-size: 9px;"><strong>{{$datos->solicitud->lote_granel->certificadoGranel->num_certificado ?? 'sin certificado'}}</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="font-size:11px; text-align: left;">Nombre y firma del inspector:</td>
                <td colspan="3" class="white-background-custom" style="font-size:11px;">
                    <strong>{{ $datos->inspector->name }}</strong></td>
                <td colspan="2" class="custom-title" style="font-size:11px; text-align: left;">Nombre y firma del
                    responsable:</td>
                <td colspan="2" class="white-background-custom" style="font-size: 11px;"><strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>
    <!-- Footer sin tablas -->
    <div class="footer">
        <div class="footer-right">
            <p>
                Entrada en vigor el 15 de julio del 2024 <br>
                Página <span class="pagenum"></span> /{{ $totalPaginas ?? 'NA' }} F-UV-04-04 Versión 16
            </p>
        </div>
    </div>

</body>

</html>
