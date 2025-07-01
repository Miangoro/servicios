<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de muestras y Reportes de resultados plaguicidas 2025.pdf</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 8px;
        }

        .center {
            text-align: center;
        }

        .lefty {
            text-align: left;
        }

        .textt {
            text-align: right;
            font-size: 8px;
        }

        .titlee {
            margin: 0;
            font-size: 10px;
        }
        .datoscl{
          font-size: 10px;
          padding-left: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*             margin-bottom: 15px; */
        }
        .tabla2 td{
          padding: 1.5px;
        }

        .tabla2{
          font-size: 8px;
          font-weight: bold;
        }
        .equisde td {
          text-align: center;
          border: 0.1px solid black;
          padding: 0.1px;
        }
        .derecha{
          text-align: right;
        }

        .table3 td{
          text-align: center;
          border: 0.1px solid black;
          padding: 0.1px;
        }

        th,
        td {
            /*  border: 1px solid #e2e2e2; */
            text-align: left;
        }

        .colorAzul {
            background-color: #3D6BBD;
        }

        .negrita{
          font-weight: bold;
        }
        .subtitle {
            text-align: center;
            background: #66E838;
        }

        .sub-title {
            background-color: #93C47D;
            text-align: center;
            font-weight: bold;
        }

        .results {
            font-size: 13px;
            background-color: #3D6BBD;
            text-align: center;
            font-weight: bold;
        }

        .gray-bg {
            background-color: #F2F2F2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="gray-bg">
            <table width="100%" class="center encabezado">
                <tr>
                    <td width="20%" class="lefty">
                        <img src="{{ public_path('img_pdf/provalab.png') }}" alt="Provalab" style="width: 120px;">
                    </td>
                    <td width="50%" class="center">
                        <h5 class="titlee">INFORME DE RESULTADOS DE ANALÍTICOS</h5>
                        <h5 class="titlee">ANÁLISIS DE PLAGUICIDAS POR CROMATOGRAFÍA DE GC-MS & LC-MS</h5>
                    </td>
                    <td width="25%" class="textt">
                        Productos de valor agregado S.A de C.V.<br>
                        Calle 30 número 2760 int A, Zona industrial<br>
                        Guadalajara Jalisco México CP 44940<br>
                        No. Telefónico:<br>
                        <a href="http://www.provalaboratorio.com">www.provalaboratorio.com</a>
                    </td>
                </tr>
            </table>





            <table class="tabla2">
              <tr>
                  <td>No. Análisis y Referencia:</td>
                  <td>1</td>
                  <td colspan="2"></td>
              </tr>
              <tr>
                  <td>Orden de Trabajo:</td>
                  <td>OT25-0001</td>
                  <td class="derecha">Método:</td>
                  <td>Método Interno para análisis de plaguicidas GC/MS+LC/MS</td>
              </tr>
              <tr>
                  <td>Fecha de Recepción:</td>
                  <td>01/02/2025</td>
                  <td class="derecha">Normativa:</td>
                  <td>Basado en UNE-EN15662 / AENOR</td>
              </tr>
              <tr>
                  <td class="datoscl" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Datos de contacto del cliente y/o empresa</td>
                  <td class="derecha">Código:</td>
                  <td>ASC-F-07.0 INFORME DE RESULTADOS</td>
              </tr>
              <tr>
                  <td>Empresa / Cliente:</td>
                  <td>Sesaja SA de CV</td>
                  <td class="derecha">Fecha de muestreo:</td>
                  <td>06/01/2025</td>
              </tr>
              <tr>
                  <td>Domicilio Cliente:</td>
                  <td>Colon industrial; calle 22 numero 2332</td>
                  <td class="derecha">Inicio del análisis:</td>
                  <td>00/01/1900</td>
              </tr>
              <tr>
                  <td>RFC:</td>
                  <td>SES991115670</td>
                  <td class="derecha">Fecha de finalización:</td>
                  <td>00/01/1900</td>
              </tr>
              <tr>
                  <td>Contacto:</td>
                  <td>Araceli Arias</td>
                  <td class="derecha">Código/Lote:</td>
                  <td>39120</td>
              </tr>
              <tr>
                  <td>Número de contacto:</td>
                  <td>3334962159</td>
                  <td class="derecha">Tipo de Muestra:</td>
                  <td>Ajonjolí Orgánico</td>
              </tr>
              <tr>
                  <td>No. Cotización:</td>
                  <td>Cotizacion-0001</td>
                  <td class="derecha">Muestreado por:</td>
                  <td>Araceli E Arias Ocegueda</td>
              </tr>
              <tr>
                  <td>Correo / E-mail:</td>
                  <td>araceli.arias@sesajal.com</td>
                  <td class="derecha">Origen de muestra:</td>
                  <td>Laboratorio de planta 1</td>
              </tr>
              <tr>
                  <td>Descripción y tipo de muestra:</td>
                  <td>BOLSA 300g Ajonjolí nat organico</td>
                  <td class="derecha">Contenedor de la muestra:</td>
                  <td>bolsa propileno</td>
              </tr>
              <tr>
                  <td>Hora; Recepción de la muestra:</td>
                  <td>11:10:00 a. m.</td>
                  <td class="derecha">Transporte:</td>
                  <td>Entregada por el cliente</td>
              </tr>
              <tr>
                  <td>Lugar de muestreo:</td>
                  <td>Planta 1</td>
                  <td class="derecha">Análisis:</td>
                  <td>GC + LC</td>
              </tr>
          </table>


        </div>


        <table class="equisde">
          <tr>
            <td colspan="7" class="results">
              Resultados Analíticos
            </td>
          </tr>
            <tr>
                <td colspan="7" class="subtitle">No se ha
                    detectado ningún analito de interés.</td>
            </tr>
            <tr class="colorAzul">
                <td>GC/MS+ LC/MS Nombre del analito</td>
                <td>LC</td>
                <td>Parámetro</td>
                <td>Unidades</td>
                <td>Resultados mg/kg</td>
                <td>Unidades</td>
                <td>Unitario</td>
            </tr>
            <tr>
                <td>2,6- Dichlorobenzamide</td>
                <td>
                    0.010</td>
                <td>0.01</td>
                <td>µg/kg</td>
                <td>trazas</td>
                <td>µg/kg</td>
                <td>12</td>
            </tr>
            <tr>
                <td>Diethyl Phthalate</td>
                <td>
                    0.010 </td>
                <td>0.01</td>
                <td>trazas</td>
                <td>trazas</td>
                <td>µg/kg</td>
                <td>197</td>
            </tr>
            <tr>
                <td>Benzyl benzoate</td>
                <td>
                    0.010</td>
                <td>0.01</td>
                <td>trazas</td>
                <td>trazas</td>
                <td>µg/kg</td>
                <td>78</td>
            </tr>
            <tr>
                <td>Pindone</td>
                <td>
                    0.010</td>
                <td>0.01</td>
                <td>trazas</td>
                <td>trazas</td>
                <td>µg/kg</td>
                <td>475</td>
            </tr>
            <tr>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>0.00000</td>
              <td>#N/D</td>
              <td>0</td>
            </tr>
            <tr>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>0.00000</td>
              <td>#N/D</td>
              <td>0</td>
            </tr>
            <tr>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>0.00000</td>
              <td>#N/D</td>
              <td>0</td>
            </tr>
            <tr>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>0.00000</td>
              <td>#N/D</td>
              <td>0</td>
            </tr>
            <tr>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>0.00000</td>
              <td>#N/D</td>
              <td>0</td>
            </tr>
            <tr>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>0.00000</td>
              <td>#N/D</td>
              <td>0</td>
            </tr>
            <tr>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>#N/D</td>
              <td>0.00000</td>
              <td>#N/D</td>
              <td>0</td>
            </tr>

            <tr >
              <td colspan="7" class="results"> Base de datos de moleculas analizadas</td>
            </tr>
        </table>
        <table class="table3">
          <tr class="negrita">
            <td colspan="7" class="">Cromatografia GC/MS y Cromatografia LQ/Ms</td>
        </tr>
        <tr class="negrita">
            <td>No</td>
            <td>Parámetro</td>
            <td>Lectura</td>
            <td>Res Esp</td>
            <td>LC</td>
            <td>Unidades:</td>
            <td>Nivel</td>
        </tr>
        <tr>
          <td>1</td>
          <td>(E)-Metominostrobin</td>
          <td></td>
          <td> <0.010 </td>
          <td>0.010</td>
          <td>µg/kg</td>
          <td></td>
        </tr>

        </table>
    </div>

</body>

</html>
