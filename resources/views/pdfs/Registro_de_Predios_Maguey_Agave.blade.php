<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-21-03 Registro de predios de maguey o agave Ed. 4 Vigente.</title>

    <style>
        body {
            font-family: Verdana, 'Geneva', Tahoma, sans-serif;
            margin: 35px;
            padding: 10px;
            margin-top: 60px;
            margin-bottom: 55px;
            font-size: 15px;
        }

        .header {
            position: fixed;
            top: -35px;
            left: 30px;
            /* right: -5px; */
            width: 100%;
            padding: 0px;
            text-align: right;
            z-index: 1;
            margin-bottom: 30px;
        }

        .header img {
            width: 255px;
            height: 88px;
            margin-right: 500px;
        }

        .line {
            position: absolute;
            top: 85px;
            right: -3px;
            width: 60%;
            border-bottom: 1px solid black;
        }

        .header-text {
            line-height: 1.5;
            font-size: 13px;
            margin-top: -45;
            padding: 0;
        }

        .footer {
            position: fixed;
            bottom: -45px;
            left: 20px;
            width: 100%;
            font-size: 10.5px;
        }

        .footer-page {
          font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            left: 660px;
            width: 75px;
            margin-top: 5px;
            font-size: 10.5px;
        }

        .footer-text {
            text-align: center;
            width: 100%;
            position: relative;
            bottom: -20px;
        }
        .footer-text2 {
            width: 100%;
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
            font-family:Arial, Helvetica, sans-serif;
            color: #1C4386;
        }

        .footer .page:after {
            content: counter(page);
        }

        .generales td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            text-align: center;
        }


        .generales {
            border-collapse: collapse;
            width: 100%;
            margin-right: 0;
            /* Opcional: asegura que la tabla esté pegada al borde derecho */
        }
        .coordenadas td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            text-align: left;
        }

        .coordenadas {
            border-collapse: collapse;
            width: 100%;
            margin-right: 0;
            /* Opcional: asegura que la tabla esté pegada al borde derecho */
        }

        .indice {
            color: #006666;
            font-size: 16px;
            font-weight: bold;

        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50%;
            height: auto;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
        }
    </style>
</head>

<body>
    {{-- cabecera --}}
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo CIDAM">
        <div class="header-text">
            Registro de predios de maguey o agave F-UV-21-03 <br> Edición 4, 15/07/2024<br></div>
        <div class="line"></div>
    </div>
    {{-- footer --}}
    <div class="footer">
        <p class="footer-text">
          Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
        </p>
        <p class="footer-page">
            Página <span class="page"></span> de 2
        </p>
        <p class="footer-text2">No. de acreditación UVNOM129 Aprobación por DGN 312.01.2017.1017</p>
    </div>
    {{-- marca de agua --}}
    <img src="{{ public_path('img_pdf/fondo_dictamen.png') }}" alt="Marca de Agua" class="watermark">

    {{-- contenido --}}
    <div class="container">
        <p style="font-size: 20px; font-weight: bold; text-align: center; margin: 0;">Registro de predios de maguey o agave</p>
        <p style="margin: 0;" class="indice">I.&nbsp;&nbsp;&nbsp;&nbsp; Datos del productor</p>
        <br>
        <table class="generales">
            <tr>
                <td style="width: 25%;"><b> Nombre del productor </b><br>(<i>Name of producer</i>)
                </td>
                <td colspan="3"> {{ $predio->nombre_productor }}</td>
                </td>
            </tr>
            <tr>
                <td style="height: 18px;"><b>Número de cliente</b> <br> (<i>client number)</i></td>
                <td>{{ $predio->empresa->empresaNumClientes->first()->numero_cliente ?? 'N/A' }}</td>
                <td ><b>Número de teléfono</b> <br>(<i>phone number)</i></td>
                <td>{{$predio->empresa->telefono ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td><b>Dirección fiscal</b> <br>
                    <i>(Fiscal address)</i></td>
                <td style=" width: 27%;">{{ $predio->empresa->domicilio_fiscal ?? 'N/A' }}</td>
                <td><b>Correo electrónico </b><br>
                    (<i>email)</i></td>
                <td>{{ $predio->empresa->correo ?? 'N/A' }}</td>
            </tr>
        </table>
        <br>
        <p style="margin: 0;" class="indice">II.&nbsp;&nbsp;&nbsp;&nbsp; Datos del servicio</p>
        <br>
        <table class="generales">
            <tr>
                <td style="width: 30%;"><b>Número de servicio</b> <br>
                    <i>(Service number)</i></td>
                <td>{{ $inspeccionData->num_servicio ?? 'N/A' }}</td>
                <td><b>Fecha de servicio</b> <br>
                    <i>(Date of Service)</i></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Vigencia </b><br>
                    <i>(validity)</i></td>
                <td>{{$vigencia}}</td>
                <td><b>Fecha de emisión</b><br>
                    (date of issue)</td>
                <td>{{$emision}}</td>
            </tr>
            <tr>
                <td><b>Nombre del Inspector </b><br>
                    <i>(Inspector name)</i></td>
                <td colspan="3">{{ $inspeccionData->inspector->name ?? 'N/A' }}</td>
            </tr>
        </table>
        <br>
        <p style="margin: 0;" class="indice">III. &nbsp;&nbsp;&nbsp;&nbsp; Datos del predio</p>
        <br>
        <table class="generales">
          <tr>
              <td style="width: 30%;"> <b>Nombre del predio </b><br>
                (<i>Property name</i>)
              </td>
              <td colspan="3"> {{$inspeccion->predio->nombre_predio}}
              </td>
          </tr>
          <tr>
              <td><b>Ubicación del predio </b><br>
                (<i>Name of producer</i>)</td>
              <td>{{$inspeccion->ubicacion_predio}}</td>
              <td><b>Número de predio</b> <br>
                (<i>Building number)</i></td>
              <td><b>UVEM </b>{{$inspeccion->predio->num_predio}}</td>
          </tr>
      </table>
        <br>
        <p  style="margin: 0;"class="indice">III. &nbsp;&nbsp;&nbsp;&nbsp; Datos de geo-referenciación del predio</p>
        <br>
        <table class="coordenadas">
          <tbody>
            <tr>
              <td colspan="4" style="text-align: center; height: 40px;">
                <b>Coordenadas Geográficas</b> <i>(Geographic coordinates)</i>
              </td>
            </tr>

            @foreach ($coordenadas as $coordenada)
              <tr>
                <td><b>Latitud</b> <i>(latitude)</i></td>
                <td style="font-weight: normal;">{{ $coordenada->latitud }}</td>
                <td><b>Longitud</b> <i>(Length) o (measuring length)</i></td>
                <td style="font-weight: normal;">{{ $coordenada->longitud }}</td>
              </tr>
            @endforeach

            <tr>
              <td colspan="2"><b>Superficie</b> <i>(area)</i></td>
              <td colspan="2" style="text-align: center; font-weight: normal;">
                {{ $inspeccion->superficie ?? 'N/A' }}
              </td>
            </tr>
          </tbody>
        </table>

    </div>
<br>
    <div class="container">
        <p style="margin: 0;" class="indice">V. &nbsp;&nbsp;&nbsp;&nbsp; Características del agave</p>
        <br>
        <table class="generales">
            <tr>
                <td><b>Tipo de maguey </b><i>(Type of maguey)</i></td>
                <td><b>Especie de agave</b> <i>(Species of agave)</i></td>
                <td><b>No. De plantas </b><i>(Number of plants)</i></td>
                <td><b>Edad</b> <i>(años) (Age (years)</i></td>
                <td><b>Tipo de plantación </b><i>(Type of plantation)</i></td>
            </tr>
            @foreach ($plantacion as $plantacion)
            <tr>
                <td style="font-weight: normal;">{{ $plantacion->tipo->nombre}}</td>
                <td style="font-weight: normal;">{{ $plantacion->tipo->cientifico }}</td>
                <td style="font-weight: normal;">{{ $plantacion->num_plantas }}</td>
                <td style="font-weight: normal;">{{ $plantacion->anio_plantacion }}</td>
                <td style="font-weight: normal;">{{ $plantacion->tipo_plantacion }}</td>
            </tr>
            @endforeach
        </table>
        <br>
        <p style="margin: 0;" class="indice">VI. &nbsp;&nbsp;&nbsp;&nbsp;  Ubicación y georreferenciación del agave</p>
        <br>
        <table class="generales">
            <tr>
                <td style="height: 55px;">
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
