<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de Emisión del Certificado NOM para Exportación</title>
    <style>
        @page {
            size: 227mm 292mm;/*tamaño carta*/
            margin-left: 52px;
            margin-right: 56px;
            /*margin-left: 80px;
            margin-right: 25px;*/
            margin-bottom: 1px;
        }
        body {
            font-family: Helvetica;
            font-size: 12px;
            padding-top: 12%;
        }
        .encabezado {
            position: fixed;
            top: 0;
            width: 100%; 
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed; /* Esto asegura que las columnas tengan un ancho fijo */
        }
        td {
            border: 1.5px solid #000000;
            text-align: center;
            font-size: 11px;
        }
        .amarillo{
            background-color: rgb(255, 209, 3);
            font-weight: bold;
            padding: 2px;
            text-align: left;
            border-bottom: none;
        }


    
        .footer {
            position: fixed;
            bottom: 15;
            right: 5;
            width: 100%;
            z-index: 9999; /* Para que el pie de página se mantenga encima de otros elementos */
            font-family: Arial, sans-serif;
            /*padding-bottom: 2px; /*espacio al fondo si es necesario */
        }
        .img-footer {
            background-size: cover; /* ajusta img al contenedor */
            background-position: center; /* Centra la imagen en el contenedor */
            height: 45px; 
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
        .titulo, .subtitulo {
            display: inline-block;
            margin-right: 30px; /* Espacio entre los textos */
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

<!--ENCABEZADO-->
<div class="encabezado">
    {{-- <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" style="width: 160px; margin-right: 30px;" alt="logo de CIDAM">
    <b style="font-size: 16px; display: inline-block; margin-right: 30px;">CENTRO DE INNOVACION Y DESARROLLO<br>AGROALIMENTARIO DE MICHOACÁN A.C.</b>
    <p style="font-size: 8px; display: inline-block;">ORGANISMO DE CERTIFICACION No. de<br>acreditación 144/18 ante la ema A.C.</p> --}}
    <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" style="width: 160px; margin-right: 30px;" alt="logo de CIDAM">
    <div style="display: inline-block; margin-bottom: 5px;">
        <b style="font-size: 16px; display: inline-block; margin-right: 30px;">CENTRO DE INNOVACION Y DESARROLLO<br>AGROALIMENTARIO DE MICHOACÁN A.C.</b>
        <p style="font-size: 8px; display: inline-block;">ORGANISMO DE CERTIFICACION No. de<br>acreditación 144/18 ante la ema A.C.</p>
    </div>
</div>

<!--PIE DE PAGINAS-->
<div class="footer">
    <p style="text-align: right; font-size: 8px; margin-bottom: 1px;">
        @if ($id_sustituye)<!-- Aparece solo si tiene valor -->
            Cancela y sustituye al certificado con clave: {{ $id_sustituye }}
        @endif
        <br>Solicitud de emisión de Certificado {{ $lotes->count() > 1 ? 'Combinado para Exportación NOM-070-SCFI-2016 F7.1-01-55' : 'para Exportación NOM-070-SCFI-2016 F7.1-01-21' }}<br>
        Edición {{ $lotes->count() > 1 ? '1' : '10' }} Entrada en vigor: 26/08/2024
    </p>
    <div class="img-footer">
            <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="pie de pagina" width="705">
    </div>
</div>



    <div style="text-align: center; font-weight: bold; font-size: 13px; padding: 9px;" >
        SOLICITUD DE EMISIÓN DEL CERTIFICADO NOM PARA EXPORTACIÓN
    </div>
    <!--PUNTO 1-->
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>I: </td>
            <td class="amarillo"><b>&nbsp;&nbsp; INFORMACIÓN DEL SOLICITANTE</b></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="padding:8px;">Fecha de solicitud:</td>
            <td style="font-weight: bold;">{{ $fecha_solicitud}}</td>
            <td>N° de cliente:</td>
            <td><b>{{ $n_cliente}}</b></td>
        </tr>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px">Domicilio donde se<br>encuentra el producto:</td>
            <td style="font-weight: bold; width: 500px" colspan="3"> {{ mb_strtoupper($domicilio_inspeccion) }}</td>
        </tr>
    </table>

    <!--PUNTO 2-->
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center; border-top:none"><b>II: </td>
            <td class="amarillo" style="border-top:none"><b>&nbsp;&nbsp;SERVICIO SOLICITADO</b></td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="5" style="padding:6px; border-bottom:none; color: red">Seleccione el servicio solicitado colocando una X en la casilla correspondiente.</td>
        </tr>
        <tr>
            <td style="text-align: right; padding:5px; width: 25%; border-top:none; border-bottom:none">Verificación en producto ENVASADO:</td>
            <td style="width: 14%;"> </td>
            <td style="width: 13%; border:none"></td>
            <td style="text-align: left; width: 16%; border:none">Fecha de visita propuesta:</td>
            <td style="width: 30%;">{{ $fecha_propuesta}}</td>
        </tr>
        <tr><td colspan="5" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
        <tr>
            <td style="text-align: right; padding:5px; width: 25%; border-top:none; border-bottom:none">Entrega de HOLOGRAMAS:</td>
            <td style="width: 14%;"> </td>
            <td style="width: 13%; border:none"></td>
            <td colspan="2" style="text-align: left; width: 16%; border-top:none; border-bottom:none; border-left:none;">
                Los hologramas se entregaran después de 48 horas de aceptación
                de la solicitud, a partir de recibir la documentación que evidencie
                el cumplimiento del producto con el apartado 4.3 de la
                NOM-070-SCFI-2016 o de la NOM-199-SCFI-2017. En caso de que el
                producto ya cuente con los hologramas no seleccionar este
                recuadro.
            </td>
        </tr>
        <tr><td colspan="5" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
        <tr>
            <td style="text-align: right; padding:5px; width: 25%; border-top:none; border-bottom:none">Emisión del CERTIFICADO NOM de EXPORTACIÓN:</td>
            <td style="width: 14%;">X</td>
            <td style="width: 13%; border:none"></td>
            <td colspan="2" style="text-align: left; width: 16%; border-top:none; border-bottom:none; border-left:none;">
                El certificado se emitirá una vez verificado el producto, que
                cuente con hologramas y la UV emita el dictamen
                correspondiente de acuerdo a la NOM que aplique.
            </td>
        </tr>
        <tr><td colspan="5" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
        <tr>
            <td style="text-align: right; padding:5px; width: 25%; border-top:none; border-bottom:none">Emisión de Certificado de PROMOCIÓN:</td>
            <td style="width: 14%;"> </td>
            <td style="width: 13%; border:none"></td>
            <td colspan="2" style="text-align: left; width: 16%; border-top:none; border-bottom:none; border-left:none;">
                El certificado se emitirá una vez verificado el producto y que cuente con hologramas
            </td>
        </tr>
        <tr><td colspan="5" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
    </table>



<!--INICIO DE TABLAS LOTES-->
@if ($lotes->count() <= 1)<!--si es 1 lote-->


<!--PUNTO 3 CERTIFICADO NORMAL-->
@foreach($lotes as $lote) 
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>III: </td>
            <td class="amarillo"><b>&nbsp;&nbsp; CARACTERISTICAS DEL PRODUCTO</b></td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">&nbsp;&nbsp;1) Marca:</td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->marca->marca ?? "No encontrado"}}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">&nbsp;&nbsp;8) Categoría y Clase:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->categoria->categoria ?? "No encontrado"}}, 
                {{ $lote->lotesGranel->first()->clase->clase ?? "No encontrado"}} 
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;2) Certificado NOM a &nbsp;&nbsp;Granel:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->folio_certificado ?? "No encontrado" }}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;9) Edad:
            </td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->edad ?? "NA"}}  
            </td>
        </tr>
    @php
        $folios = explode(',', $lote->lotesGranel->first()->folio_fq ?? 'No encontrado');
        $folio1 = trim($folios[0] ?? '');
        $folio2 = trim($folios[1] ?? 'NA');
    @endphp
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;3) No. de análisis:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $folio1 }} 
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;10) Contenido Alcohólico:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->cont_alc ?? "No encontrado" }}% 
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;4) No. de análisis de ajuste:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               {{ $folio2 }}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;11) No. de lote a granel:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->nombre_lote ?? "N" }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;5) Tipo de Maguey: 
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               {!! $lote->lotesGranel->first()->tiposRelacionados->map(function ($tipo) {
                    return $tipo->nombre . ' (<i>' . $tipo->cientifico . '</i>)';
                })->implode(', ') !!}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;12) No. de lote envasado:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->nombre ?? "No encontrado" }}
            </td>
        </tr>

        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;6) No. de cajas: 
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{$cajas}}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;13) No. de botellas: </td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{$botellas}}
            </td>
        </tr>

        <tr>
            <td style="text-align: left; padding-top:8px; padding-bottom:8px; width: 20%;">
                &nbsp;&nbsp;7) Contenido neto por
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               {{ $lote->presentacion ?? 'No encontrado'}}
            </td>
            <td>mL</td>
            <td><b>{{ $lote->unidad === 'mL' ? 'X' : '' }}</b></td>
            <td>cL</td>
            <td><b>{{ $lote->unidad === 'cL' ? 'X' : '' }}</b></td>
            <td>L</td>
            <td><b>{{ $lote->unidad === 'L' ? 'X' : '' }}</b></td>
        </tr>
    </table>

    <div style="page-break-before: always;"></div><!--SALTO-->

@endforeach


@else<!--si hay mas de 1 lote (multiple)-->


<!--PUNTO 3 CERTIFICADO COMBINADO-->
@foreach($lotes as $lote) 
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>III: </td>
            <td class="amarillo"><b>&nbsp;&nbsp; CARACTERISTICAS DEL PRODUCTO COMBINADO</b></td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">&nbsp;&nbsp;1) Marca:</td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->marca->marca ?? "No encontrado"}}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">&nbsp;&nbsp;7) Categoría y Clase:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->categoria->categoria ?? "No encontrado"}}, 
                {{ $lote->lotesGranel->first()->clase->clase ?? "No encontrado"}} 
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;2) Certificado NOM a &nbsp;&nbsp;Granel:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->folio_certificado ?? "No encontrado" }}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;8) Edad:
            </td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->edad ?? "NA"}}  
            </td>
        </tr>
    @php
        $folios = explode(',', $lote->lotesGranel->first()->folio_fq ?? 'No encontrado');
        $folio1 = trim($folios[0] ?? '');
        $folio2 = trim($folios[1] ?? 'NA');
    @endphp
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;3) No. de análisis:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $folio1 }} 
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;9) Contenido Alcohólico:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->cont_alc ?? "No encontrado" }}% 
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;4) No. de análisis de ajuste:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               {{ $folio2 }}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;10) No. de lote a granel:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->lotesGranel->first()->nombre_lote ?? "N" }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;5) Tipo de Maguey: 
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               {!! $lote->lotesGranel->first()->tiposRelacionados->map(function ($tipo) {
                    return $tipo->nombre . ' (<i>' . $tipo->cientifico . '</i>)';
                })->implode(', ') !!}
            </td>
            <td style="text-align: left;  width: 20%;" colspan="3">
                &nbsp;&nbsp;11) No. de lote envasado:</td>
            <td style="font-weight: bold; width: 30%;" colspan="3"> 
                {{ $lote->nombre ?? "No encontrado" }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;6) Contenido neto por
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               {{ $lote->presentacion ?? 'No encontrado'}}
            </td>
            <td>mL</td>
            <td><b>{{ $lote->unidad === 'mL' ? 'X' : '' }}</b></td>
            <td>cL</td>
            <td><b>{{ $lote->unidad === 'cL' ? 'X' : '' }}</b></td>
            <td>L</td>
            <td><b>{{ $lote->unidad === 'L' ? 'X' : '' }}</b></td>
        </tr>

        @if($loop->iteration == 1)
            <tr>
                <td style="padding-top:12px; padding-bottom:12px;">Cantidad total del<br>producto combinado: </td>
                <td colspan="7">
                    <b>{{ $cajas }} Cajas y {{ $botellas }} Botellas</b>
                </td>
            </tr>
        @endif
    </table>


@if($loop->iteration == 1 OR $loop->iteration == 3)<!--Salto de pag después de tabla 2-->
    <div style="page-break-before: always;"></div> 
@endif

    <!--si hay más de un lote, agregar al final una nueva-->
    {{-- @if($loop->iteration > 1 && $loop->last)
        <br>
        <table>
            <tr>
                <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                    &nbsp;&nbsp;No. de cajas: 
                </td>
                <td style="font-weight: bold; width: 30%;"> 
                    {{$cajas}}
                </td>
                <td style="text-align: left;  width: 20%;">
                    &nbsp;&nbsp;No. de botellas: </td>
                <td style="font-weight: bold; width: 30%;"> 
                    {{$botellas}}
                </td>
            </tr>
        </table>
    @endif --}}
@endforeach <!-- FIN DE TABLAS LOTES -->

@endif<!--FIN del IF si es uno o multiple-->



    <!--PUNTO 4-->
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>IV: </td>
            <td class="amarillo" style=""><b>&nbsp;&nbsp;INFORMACIÓN DEL PAÍS DESTINO (los datos deben aparecer tal cual se indican en la factura y orden de compra)</b></td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px; width: 20%;">
                Nombre:   
            </td>
            <td style="font-weight: bold; width: 80%" colspan="3">{{$nombre_destinatario}}</td>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px; width: 20%;">
                Domicilio:</td>
            <td style="font-weight: bold; width: 80%" colspan="3">{{$dom_destino}}</td>
        </tr>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px; width: 20%;" rowspan="2">
                País:</td>
            <td style="font-weight: bold; width: 20%" rowspan="2">
                {{$pais}} 
            </td>
            <td style="width: 20%">
                Aduana de salida:  
            </td>
            <td style="font-weight: bold; width: 40%">
                {{$aduana}} 
            </td>
        </tr>
        <tr>
            <td style="width: 20%">
                Fracción arancelaria
            </td>
            <td style="font-weight: bold; width: 40%" >
                2208.90.05.00
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="font-weight: bold; padding-top:16px; padding-bottom:16px; width: 50%; border-top: none; border-bottom: none">
                {{$resp_instalacion}}
                <br><br>
                Nombre del responsable de instalaciones
            </td>
            <td style="font-weight: bold; width: 50%; border-top: none; border-bottom: none">
                 {{$empresa}}
                <br><br>
                Nombre del solicitante de exportación
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="font-weight: bold; padding-top:16px; padding-bottom:16px; width: 30%;">
                INFORMACIÓN ADICIONAL SOBRE LA ACTIVIDAD:
            </td>
            <td>{{$info_adicional}}</td>
        </tr>
    </table>


@if (in_array($lotes->count(), [2, 4]))<!--Salto de pag después de tabla 2 o tabla 4-->
    <div style="page-break-before: always;"></div> 
@endif
    <!--PUNTO 5-->
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>V: </td>
            <td class="amarillo" style=""><b>&nbsp;&nbsp;ANEXOS</b></td>
        </tr>
    </table>
{{-- <div style="page-break-before: always;"></div> 
<br><br><br><br> --}}

    <table>
        <tr>
            <td colspan="3" style="padding:6px; border-bottom:none; color: red">Adjuntar a la solicitud los documentos que a continuación se enlistan:</td>
        </tr>
        <tr>
            <td style="width: 13%; border-top:none; border-bottom:none; border-right:none;"></td>
            <td style="width: 13%;">X</td>
            <td style="text-align: left; border-top:none; border-bottom:none; border-left:none;">
                Copia del análisis de laboratorio de cada uno de los lotes en cumplimiento con el apartado 4.3 de
                la NOM-070-SCFI-2016 o de la NOM-199-SCFI-2017. En caso de producto cuente con ajuste de
                grado alcohólico, reposado o añejo adjuntar copia de los analisis de laboratorio posteriores al
                proceso en cumplimiento con el numeral 5 de la NOM-070-SCFI-2016.
            </td>
        </tr>
        <tr><td colspan="3" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
        <tr>
            <td style="width: 13%; border-top:none; border-bottom:none; border-right:none;"></td>
            <td style="width: 13%; padding:14px;">X</td>
            <td style="text-align: left; border-top:none; border-bottom:none; border-left:none;">
                Constancia de cumplimiento de la etiqueta emitida por UV acreditada en información comercial
            </td>
        </tr>
        <tr><td colspan="3" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
        <tr>
            <td style="width: 13%; border-top:none; border-bottom:none; border-right:none;"></td>
            <td style="width: 13%; padding:14px;"> </td>
            <td style="text-align: left; border-top:none; border-bottom:none; border-left:none;">
                En caso de vigilancia en producto envasado, adjuntar certificado NOM a granel y certificado de envasado
            </td>
        </tr>
        <tr><td colspan="3" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
        <tr>
            <td style="width: 13%; border-top:none; border-bottom:none; border-right:none;"></td>
            <td style="width: 13%; padding:14px;"> </td>
            <td style="text-align: left; border-top:none; border-bottom:none; border-left:none;">
                Copia de la orden de compra del importador o invitación a la feria o exposición en el extranjero
            </td>
        </tr>
        <tr><td colspan="3" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
        <tr>
            <td style="width: 13%; border-top:none; border-bottom:none; border-right:none;"></td>
            <td style="width: 13%;">X</td>
            <td style="text-align: left; border-top:none; border-bottom:none; border-left:none;">
                Copia de la factura o proforma. En caso de que el producto se exporte con fines de promoción,
                entregar factura sin valor comercial.
            </td>
        </tr>
        <tr><td colspan="3" style="height: 5px; border-top:none; border-bottom:none"></td></tr><!--SALTO-->
    </table>

    <table>
        <tr>
            <td style="padding:3px; text-align: justify; border-bottom: none" colspan="3">
                La empresa se da por enterada que: la Unidad de Verificación establecerá una vigilancia de cumplimiento con la NOM
                permanente a sus instalaciones una vez que el Certificado NOM sea emitido. Para validar la información el OC podrá solicitar
                los documentos originales para su cotejo respectivo.
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: right; border-top:none; border-right:none; color:#999999"  >
                Campo para uso exclusivo del personal del<br>OC-CIDAM
            </td>
            <td style="width: 15%; background:#dddddd; border-top:none; border-right:none; border-left:none">
                N° DE SOLICITUD: 
            </td>
            <td style="width: 35%">
                {{$folio}}
            </td>
        </tr>
    </table>




</body>
</html>
