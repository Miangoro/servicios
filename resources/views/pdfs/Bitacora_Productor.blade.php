<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bitácora de Productor</title>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse; 
    }

    th, td {
        border: 1px solid;
        padding: 8px;
        text-align: center;
        font-size: 10px;
        word-wrap: break-word;
        width: auto;
        font-family: 'calibri';
    }

    img {
        display: flex;
        margin-bottom: 10px; 
    }

    .img .logo-small {
        height: 70px; 
        width: auto;
    }

    .text {
        text-align: center;
        margin-top: -50px; 
        font-family: 'calibri-bold';
        font-size: 18px;
    }

    tr.text-title td, tr.text-title th {
        padding: 0px; 
        text-align: center; 
        font-size: 12px; 
        word-break: break-word;
        height: auto;
        width: auto;
        vertical-align: middle;
        background: #D0CECE;     
        font-family: 'calibri-bold';
    }

    .num {
        text-align: right;
        margin-top: -30px; 
        font-family: 'calibri-bold';
        font-size: 18px;
    }
    
    .numero {
        text-align: right;
        margin-top: -30px; 
        font-family: 'calibri-bold';
        font-size: 18px;
        position: absolute; 
        right: 0;
        top: 80px; 
        right: 70px;
    }
    
    .subtitle {
        text-align: center;
        margin-top: -20px;
        margin-bottom: 1px;
        font-family: 'calibri-bold';
        font-size: 15px;
    }

    .no-border {
        border: none; 
        padding: 0; 
        font-family: 'calibri';
        font-size: 14px;
        background: white;
    }

    table .no-border {
        background: white;  
    }

    .inspector{
        font-family: 'calibri';
        margin-left: 20%;
    }

    .datos {
        text-align: right; 
        font-family: 'calibri-bold';
        font-size: 15px; 
        right: 70px;
        margin-bottom: -40px;
        margin-right: 170px; 
    }

    .segunda {
        width: 50%; 
        border-collapse: collapse;
        margin-left: -5;
    }

    .tercera {
    width: 50%; 
    border-collapse: collapse;
    margin-left: auto; 
    margin-right: -5; 
    margin-top: -220px;
    }

    .observaciones-table2 {
        width: 30%; 
        border-collapse: collapse;
        margin-left: 0;
    }

    .observaciones-table2 td {
        padding: 2px;
        text-align: center;
        font-size: 12px;
        word-break: break-word;
        height: auto;
        width: auto;
        vertical-align: top;
        background: #D0CECE;
        font-family: 'calibri-bold';
    }

    .observaciones-box {
        text-align: center;
        font-size: 16px; 
        font-weight: bold; 
        margin-bottom: 10px; 
    }

    .observaciones-table {
        width: 100%;
        border-collapse: collapse;
        margin-left: 0; 
    }

    .observaciones-table td {
        padding: 0; 
        text-align: left;
        font-size: 12px;
        word-break: break-word;
        height: 20px; 
        vertical-align: top; 
        background: white;
        font-family: 'calibri';
        border: none; 
    }

    .line td {
        border-bottom: 1px solid black; 
        height: 20px; 
    }

    .pie1 {
            text-align: right;
            font-size: 12px;
            line-height: 1;
            position: absolute;
            bottom: -40px;
            left: 0;
            right: 0;
            width: calc(100% - 40px);
            height: 45px;
            margin-right: 30px;
            padding: 10px 0;
            font-family: 'Lucida Sans Unicode';
            z-index: 1; 
            color: #A6A6A6;
     }

    .pie {
            text-align: right;
            font-size: 12px;
            line-height: 1;
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            width: calc(100% - 40px);
            height: 45px;
            margin-right: 30px;
            padding: 10px 0;
            font-family: 'Lucida Sans Unicode';
            z-index: 1; 
            color: #A6A6A6;
     }

</style>
<body>
    <div class="img"> 
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
    </div>

    <div>
        <p class="text">PROCESO DE ELABORACIÓN DE MEZCAL</p>
    </div>

    <div>
        <p class="num">NÚM. TAPADA: ________________</p>
        <p class="numero">2</p>
    </div>
    
    <div>
        <p class="subtitle">INGRESO E IDENTIFICACIÓN DEL AGAVE</p>
    </div>

    <table>
        <tbody>
            <tr class="text-title">
                <td class="no-border"></td>
                <td>FECHA DE INGRESO</td>
                <td>NÚM. DE GUÍA</td>
                <td>TIPO DE MAGUEY</td>
                <td>NÚM. PIÑAS</td>
                <td>KG DE MAGUEY</td>
                <td>% DE ART</td>
            </tr>
            <tr>
                <td class="no-border">1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div>
        <p class="datos"></p>
        <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR ____________________________________________________________________</p>
    </div>

    <br>

    <div>
        <p class="subtitle">COCCIÓN DE AGAVE</p>
    </div>

    <table>
        <tbody>
            <tr class="text-title">
                <td class="no-border"></td>
                <td>FECHA DE INGRESO</td>
                <td>NÚM. DE GUÍA</td>
                <td>TIPO DE MAGUEY</td>
                <td>NÚM. PIÑAS</td>
            </tr>
            <tr>
                <td class="no-border">1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    
    <div>
        <p class="datos"></p>
        <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR ____________________________________________________________________</p>
    </div>

    <div class="pie1">
        <p>Página 1 de 2</p>
    </div>

    <table>
        <tbody>
            <tr class="text-title">
                <td class="no-border"></td>
                <td rowspan="2">FECHA DE MOLIENDA</td>
                <td rowspan="2">NÚM. DE TINA</td>
                <td rowspan="2">FECHA DE FORMULACIÓN</td>
                <td rowspan="2">VOLUMEN FORMULADO</td>
                <td rowspan="2">FECHA DE DESTILACIÓN</td>
                <td colspan="2">FLOR</td>
                <td colspan="2">ORDINARIO</td>
                <td colspan="2">COLAS</td>
            </tr>
            <tr class="text-title">
                <td class="no-border"></td>
                <td>Volumen</td>
                <td>%Alc.Vol.</td>
                <td>Volumen</td>
                <td>%Alc.Vol.</td>
                <td>Volumen</td>
                <td>%Alc.Vol.</td>
            </tr>
            <tr>
                <td class="no-border">1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">4</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">5</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">6</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">7</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">8</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">9</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">10</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">11</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">12</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">13</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">14</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">15</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">16</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">17</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">18</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">19</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">20</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border"></td>
                <td class="no-border"></td>
                <td class="no-border"></td>
                <td>VOLUMEN TOTAL</td>
                <td></td>
                <td>VOLUMEN TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    
    <div class="pie">
        <p>Página 2 de 2</p>
    </div>
    
    <div>
        <p class="datos"></p>
        <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR ____________________________________________________________________</p>
    </div>

    <br>
    
    <table class="segunda">
            <tbody>
                <tr class="text-title">
                    <td class="no-border"></td>
                    <td rowspan="2">FECHA DE DESTILACIÓN</td>
                    <td colspan="2">FLOR</td>
                    <td colspan="2">MEZCAL</td>
                    <td colspan="2">COLAS</td>
                </tr>
                <tr>
                    <td class="no-border"></td>
                    <td>Volumen</td>
                    <td>%Alc.Vol.</td>
                    <td>Volumen</td>
                    <td>%Alc.Vol.</td>
                    <td>Volumen</td>
                    <td>%Alc.Vol.</td>
                </tr>
                <tr>
                    <td class="no-border">1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">3</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">5</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border"></td>
                    <td>VOLUMEN TOTAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="tercera">
            <tbody>
                <tr class="text-title">
                    <td class="no-border"></td>
                    <td rowspan="2">FECHA DE DESTILACIÓN</td>
                    <td colspan="2">FLOR</td>
                    <td colspan="2">MEZCAL</td>
                    <td colspan="2">COLAS</td>
                </tr>
                <tr>
                    <td class="no-border"></td>
                    <td>Volumen</td>
                    <td>%Alc.Vol.</td>
                    <td>Volumen</td>
                    <td>%Alc.Vol.</td>
                    <td>Volumen</td>
                    <td>%Alc.Vol.</td>
                </tr>
                <tr>
                    <td class="no-border">1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">3</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">5</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border"></td>
                    <td>VOLUMEN TOTAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <div>
            <p class="datos"></p>
            <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR ____________________________________________________________________</p>
        </div>

        <br>

        <table class="observaciones-table2">
        <tr>
            <td>OBSERVACIONES</td>
        </tr>
    </table>

    <table class="observaciones-table">
        <!-- Líneas para escribir -->
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
    </table>
    
</body>
</html>