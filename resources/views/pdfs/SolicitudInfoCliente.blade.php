<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Información del Cliente</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 30px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4f81bd;
            color: white;
            text-align: center;
            font-size: 11px;
            font-family: Arial, sans-serif;

        }

        .no-border {
            border: none;
        }

        .header {
            padding: 10px;
            text-align: right;
        }

        .header img {
            width: 240px;
            float: left;

        }

        .td_text {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .spaced-text span {
            margin-right: 10px;
            /* Márgen derecho entre los spans */
        }

        .cenetered-text {
            text-align: center;
        }

        .no-bottom-border td {
            border-bottom: none;
        }

        .no-top-border td {
            border-top: none;

        }

        .checkbox-cell {
            width: 50px;
        }
    </style>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
        <h3>Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V- <br> 052-NORMEX-2016 F7.1-01-02 <br> Edición
            12 Entrada en Vigor: 01-02-2024 <br>__________________________________________________________</h3>
    </div>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <table class="no-bottom-border">
                        <tr>
                            <th colspan="3">INFORMACIÓN DEL CLIENTE</th>
                        </tr>
                    </table>
                </div>
                <table class="table, no-top-border">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">Nombre del cliente: {{$datos[0]->razon_social}}</td>
                        <td style="font-weight: bold">Fecha de solicitud: {{$datos[0]->fecha_registro}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight: bold">Correo Electrónico: {{$datos[0]->correo}}</td>
                        <td style="font-weight: bold">Teléfono: {{$datos[0]->telefono}}</td>
                    </tr>

                    <tr>
                        <td rowspan="2" class="custom-table-cell"
                            style="vertical-align: top; border-right: 1px solid black;">
                            <!-- Contenido del lado izquierdo -->
                            <br>
                            <p style="text-align: center; font-weight: bold; ">Domicilio Fiscal:</p>
                        </td>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, primer elemento -->
                            <span style="margin-right: 90px;">Calle: </span>
                            <span style="margin-right: 20px;">Número:</span>
                            <span style="margin-right: 90px;">Colonia: </span>

                        </td>
                    </tr>
                    <tr>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, segundo elemento -->
                            <span style="margin-right: 200px">Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="custom-table-cell"
                            style="vertical-align: top; border-right: 1px solid black;">
                            <!-- Contenido del lado izquierdo -->
                            <p style="text-align: center; font-weight: bold">Domicilio de: <br><br><br>
                                __________________ </p>
                        </td>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, primer elemento -->
                            <span style="margin-right: 200px;">Calle:</span>
                            <span style="margin-right: 30px;">Número:</span>
                            <span style="margin-right: 20px;">Colonia:</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, segundo elemento -->
                            <span style="margin-right: 200px">Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2" class="custom-table-cell"
                            style="vertical-align: top; border-right: 1px solid black;">
                            <!-- Contenido del lado izquierdo -->
                            <p style="text-align: center; font-weight: bold">Domicilio de: <br><br><br>
                                __________________ </p>
                        </td>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, primer elemento -->
                            <span style="margin-right: 200px;">Calle:</span>
                            <span style="margin-right: 30px;">Número:</span>
                            <span style="margin-right: 20px;">Colonia:</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, segundo elemento -->
                            <span style="margin-right: 200px;">Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>
                </table>
            </div>

            <table class="no-top-border">
                <tr>
                    <td>En caso de contar con más instalaciones en domicilios diferentes donde lleve a cabo su
                        actividad (planta de producción, envasado, bodega de maduración u otro) agregar las
                        tablas necesarias y especificar domicilios*</td>
                </tr>
            </table>

            <table class="no-top-border">
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Producto (s) que se va a
                        certificar <br> Alcance del Organismo Certificador
                    </td>
                </tr>

            </table>
            @php
                
            

                $primera = "-----";
                $segunda = "-----";
                $tercera = "-----";
                $cuarta = "-----";
                $norma070 = "-----";
                $norma251 = "-----";
                $norma052 = "-----";
                $actividad1 = "-----";
                $actividad2 = "-----";
                $actividad3 = "-----";
                $actividad4 = "-----";
                $actividad5 = "-----";
                $actividad6 = "-----";
                $actividad7 = "-----";
                $producto = [];
                $norma = [];
                $actividad = [];
                @endphp

            @foreach ($datos as $dato)
                
            @php array_push($producto,$dato->id_producto); 
                array_push($norma,$dato->id_norma);
                array_push($actividad,$dato->id_actividad); @endphp
                
            @endforeach

            @php
                if(in_array("1",$producto)){
                    $primera = "X";
                }
                if(in_array("2",$producto)){
                    $segunda = "X";
                }
                if(in_array("3",$producto)){
                    $tercera = "X";
                }
                if(in_array("4",$producto)){
                    $cuarta = "X";
                }

                if(in_array("1",$norma)){
                    $norma070 = "X";
                }
                if(in_array("2",$norma)){
                    $norma251 = "X";
                }

                if(in_array("3",$norma)){
                    $norma052 = "X";
                }

                if(in_array("1",$actividad)){
                    $actividad1 = "X";
                }
                if(in_array("2",$actividad)){
                    $actividad2 = "X";
                }   
                if(in_array("3",$actividad)){
                    $actividad3 = "X";
                }
                if(in_array("4",$actividad)){
                    $actividad4 = "X";
                }
                if(in_array("5",$actividad)){
                    $actividad5 = "X";
                }
                if(in_array("6",$actividad)){
                    $actividad6 = "X";
                }
                if(in_array("7",$actividad)){
                    $actividad7 = "X";
                }

                if($dato->medios == "Si"){
                    $medios = "X";
                    $medios2 = "";
                }else{
                    $medios = "";
                    $medios2 = "X";
                }
                if($dato->competencia == "Si"){
                    $competencia = "X";
                    $competencia2 = "";
                }else{
                    $competencia = "";
                    $competencia2 = "X";
                }
                if($dato->capacidad == "Si"){
                    $capacidad = "X";
                    $capacidad2 = "";
                }else{
                    $capacidad = "";
                    $capacidad2 = "X";
                }
             @endphp

            <table class="no-top-border">
                <tr>
                    <td>Mezcal</td>
                    <td style="width: 20px;">&nbsp;{{$primera}}</td>
                    <td>Bebida alcohólica <br> preparada que contiene <br> Mezcal</td>
                    <td style="width: 20px;">&nbsp;{{$segunda}}</td>
                    <td>Cóctel que <br> contiene Mezcal</td>
                    <td style="width: 20px;">&nbsp;{{$tercera}}</td>
                    <td style="width: 50px;">&nbsp;</td>

                </tr>
                <tr>
                    <td>Licor y/o crema que <br>contiene Mezcal </td>
                    <td>&nbsp;{{$cuarta}}</td>
                    <td colspan="5">&nbsp;</td>
                </tr>
            </table>

            <table class="no-top-border">
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Documentos normativos para los
                        cuales busca la
                        certificación:
                    </td>
                </tr>

            </table>
            <table class="no-top-border">
                <tr>
                    <td>NOM-070-SCFI-2016</td>
                    <td>&nbsp;{{$norma070}}</td>
                    <td>NOM-251-SSA1-2009</td>
                    <td>&nbsp;{{$norma251}}</td>
                    <td style="width: 50px;">&nbsp;</td>

                </tr>
                <tr>
                    <td>NMX-V-052-NORMEX-2016</td>
                    <td>&nbsp;{{$norma052}}</td>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>

            <table class="no-top-border">
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Actividad del cliente
                        NOM-070-SCFI-2016 :
                    </td>
                </tr>

            </table>
            <table class="no-top-border">
                <tr>
                    <td>Productor de Agave</td>
                    <td>&nbsp;{{$actividad1}}</td>
                    <td>Envasador de Mezcal</td>
                    <td>&nbsp;{{$actividad2}}</td>
                    <td>&nbsp;</td>


                </tr>
                <tr>
                    <td>Productor de Mezcal</td>
                    <td>&nbsp;{{$actividad3}}</td>
                    <td>Comercializador de Mezcal</td>
                    <td>&nbsp;{{$actividad4}}</td>
                    <td style="width: 50px;">&nbsp;</td>

                </tr>
            </table>
            <br>
            <p style="text-align: center; margin-top: 60px;">
                Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
            </p>
            <br>
            <div class="header">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
                <h3>Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V- <br> 052-NORMEX-2016 F7.1-01-02 <br>
                    Edición
                    12 Entrada en Vigor: 01-02-2024 <br>__________________________________________________________</h3>
            </div>
            <table>
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Actividad del cliente
                        NMX-V-052-NORMEX-2016: :
                    </td>
                </tr>

            </table>
            <table class="no-top-border">
                <tr>
                    <td style="font-weight: bold">Productor de bebidas <br> alcohólicas que contienen <br> Mezcal</td>
                    <td>&nbsp;{{$actividad5}}</td>
                    <td style="font-weight: bold">Envasador de bebidas <br> alcohólicas que contienen <br> Mezcal</td>
                    <td style="width: 20px;">&nbsp;{{$actividad6}}</td>
                    <td style="width: 50px;" colspan="2">&nbsp;</td>


                </tr>
                <tr>
                    <td style="font-weight: bold">Comercializador de bebidas <br> alcohólicas que contienen <br> Mezcal
                    </td>
                    <td style="width: 20px;">&nbsp;{{$actividad7}}</td>
                    <td></td>
                    <td colspan="3">&nbsp;</td>

                </tr>
            </table>

            <table class="no-bottom-border, no no-top-border">
                <td rowspan="4" class="custom-table-cell" style="vertical-align: top; ">
                    <!-- Contenido del lado izquierdo -->
                    <br>
                    <p style="text-align: center; font-weight: bold; margin-top: 0px">Información sobre los Procesos y productos a certificar por el cliente:</p>
                    <p style="text-align: center; ">{{$datos[0]->info_procesos}}</p>
                </td>
            </table>

            <table class="no-bottom-border">
                <tr>
                    <td style="text-align: center; font-weight: bold;">NOMBRE DEL CLIENTE SOLICITANTE:</td>
                </tr>
                <tr> <td style="text-align: center; font-weight: bold; font-size:16px">{{$datos[0]->representante ?? $datos[0]->razon_social}}</td></tr>
            </table>
            <table class="no-top-border">
                <td style="height: 5px; text-align: center; vertical-align: middle; font-weight: bold">
                    Quien queda enterado de todos los requisitos que debe cumplir para proseguir su proceso de
                    certificación.
                </td>
            </table>
            <br>
            <br>

            <table>
                <tr>
                    <th colspan="3">INFORMACIÓN DEL ORGANISMO CERTIFICADOR (Exclusivo CIDAM) <br>Viabilidad del
                        servicio
                    </th>
                </tr>
                <td style="width: 500px; text-align: center; font-weight: bold">DESCRIPCIÓN:</td>
                <td style="text-align: center; font-weight: bold">SI</td>
                <td style="text-align: center; font-weight: bold">NO</td>
                <tr>
                    <td style="width: 500px;">Se cuenta con todos los medios para realizar todas las actividades de
                        evaluación para la <br> Certificación </td>
                    <td>{{$medios}}</td>
                    <td>{{$medios2}}</td>

                </tr>
                <tr>
                    <td style="width: 500px;">El organismo de Certificación tiene la competencia para realizar la
                        Certificación :</td>
                    <td>{{$competencia}}</td>
                    <td>{{$competencia2}}</td>

                </tr>
                <tr>
                    <td style="width: 500px;">El organismo de Certificación tiene la capacidad para llevar a cabo las
                        actividades de <br> certificación.</td>
                    <td>{{$capacidad}}</td>
                    <td>{{$capacidad2}}</td>

                </tr>
                <tr>
                    <td colspan="3">No. De cliente CIDAM: </td>

                </tr>
                <tr>
                    <td colspan="3">Comentarios: 
                        {{$datos[0]->comentarios}}
                    </td>

                </tr>

            </table>
            <br>
            <br>
            <table>
                <tr>
                    <th style="height: 50px;">Nombre y Puesto de quien <br> realiza la revisión</th>
                    <td style="width: 140px;"></td>
                    <th style="height: 50px;">Firma de quien <br> realiza la revisión</td>
                    <td style="width: 140px;"></td>
                </tr>
            </table>


            <p style="text-align: center; margin-top: 100px;">
                Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
            </p>
            <br>
        </div>
    </div>
</body>

</html>
