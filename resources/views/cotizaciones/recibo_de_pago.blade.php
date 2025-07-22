<!--nuevo-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago - CIDAM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            margin-top: 20px;
            padding: 10px;
            font-size: 17px;
            line-height: 1.3;
        }

        .imagen-Logo {
            float: right;
            margin-left: 0px;
            margin-top: -10px;
            width: 150px;
            height: 80px;
        }

        .recibo-container {
            border: 1px solid #0a0a0a; /*borde*/
            margin-bottom: 20px;
            background: white;
        }

        .header {
            padding: 15px;
            border-bottom: 1px solid #000;
            text-align: center;
            position: relative;
        }

        .header h5 {
            margin: -15px 1px 15px 4px;
            font-size: 15px;
            text-align: right;
            font-weight: normal;
        }
        .Recibo{
            width: 100%;
            text-align: center;
        }

        .header h3 {  /*Encabezado*/
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            line-height: 1.2;
        }

        .info-section {
            background-color: #1689ec;
            padding: 0;
        }

        .info-table {
            width: 269%;
            border-collapse: collapse; /*fecha*/
            margin: 0;
        }

        .info-table td { /*tabla de fecha*/
            border: none;
            padding: 5px; /*espacio entre encabezado y fecha*/
            font-size: 12px;
        }

        .info-table td:first-child {
            width: 15%;
        }

        .info-table td:nth-child(2) {
            width: 20%;
            font-weight: bold;
            color: #1a5490;
        }

        .info-table td:last-child {
            width: 70%;
            color: #1a5490;
            border: none;
            padding: 5px 3px;
            font-size: 12px;
        }

        .info-section {
            background-color: #ffffffff; /*color fondo de fecha*/
            padding: 0;
        }

        .info-section2 {
            background-color: #e6f3ff; /* color fondo concepto*/
            padding: 0;
        }
        
        .info-table2 {
            width: 218%;
            border-collapse: collapse; /*concepto*/
            margin: 0;
        }

        .info-table2 td { /*concepto*/
            border: none;
            padding: 5px 3px;
            font-size: 12px;
        }

        .info-table2 td:first-child { /*espacio entre concepto*/
            width: 29%;
        }

        .info-table2 td:nth-child(2) {
            width: 5%;
            font-weight: bold;
            color: #1a5490;
        }

        .info-table2 td:last-child {
            width: 65%;
            color: #1a5490;
        }

        .field-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background-color: #e6f3ff;
        }
        

        .field-table td {
            border: none;
            padding: 2px 2px;
            font-size: 14px;
            color: #366aa2db; /* color dentro de la tabla recibi de*/
            
            
            
        }

        .field-table td:first-child {
            width: 40%;
            font-weight: bold;
            color: #345170; /* color Recibi de*/
            padding-left: 140px;
        }

        .field-table td:last-child {
            border: 1px solid #000000ad; /*borde de recibir*/
            background: #e6f3ff;
            font-weight: bold;
        }

        .amount-cell {
            text-align: center;
        }

       /* .concept-section {
            padding: 2px 10px;
            border-bottom: 1px solid #fffefe;
        }
        */

        .concept-table { /*por concepto*/
            width: 100%;
            border-collapse: collapse; /*fecha*/
            margin: 0;
        }

        .concept-table {  /*por concepto*/
            border: 0.5px solid #0000003d;
            font-size: 16px;
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            
        }

        .concept-table td:first-child {
            font-weight: bold;
            text-align: right;
            color: #4b6e92ff;
            width: 50%;
            padding: 5px;
            
        }

        .concept-table td:last-child {
            font-weight: bold;
            color: #3d6895ff;
            
        }

        .signature-table { /*tabla entrego*/
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .signature-table th { /*tabla entrego*/
            border: 0.5px solid #000000;
            padding: 4px;
            background-color: #e6f3ff; /*color fondo tabla entreggo*/
            font-weight: bold;
            color: #094789d5; /*color titulo entrego*/
            text-align: center;
        }

        .signature-table td {
            border: 0.5px solid #000;
            padding: 20px 10px;
            text-align: center;
            vertical-align: bottom;
            height: 20px;
            font-weight: bold;
            color: #2b537e; /*color texto tabla ent*/
            font-size: 11px;
        }

        .footer-section {
            padding: 12px 15px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .footer-table td {
            border: none;
            padding: 0;
            text-align: center;
            font-size: 13px;
            line-height: 1.5 ;
        }

        .admin-section {
            border-collapse: collapse;
            margin: 10px auto;
            text-align: justify
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .admin-table td {
            border: 1px solid  #0f0f0f;
            padding: 1px;
        }

        .admin-table td:first-child {
            font-family: 'Times New Roman', 'Century Gothic', sans-serif;
            color: #2e4c6bff;
            width: 200%;
        }

        .admin-table td:last-child {
            width: 10%;
            height: 0px;
        }

        .tcpdf-footer {
            text-align: center;
            font-size: 9px;
            color: #666;
            margin-top: 15px;
        }

        .vacio{
            height: 17px;
            border-bottom: 1px solid  #0f0f0f;
        }

        @media print {
            body { padding: 10px; }
            .recibo-container { page-break-after: always; }
            .recibo-container:last-child { page-break-after: avoid; }
        }
    </style>
</head>
<body>
    <!-- Primer Recibo -->
    <div class="recibo-container">
        <div class="header">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM" class="imagen-Logo">
            
            <div class="Recibo">
                <h5>Recibo de pago R-UGII-101 Ed. 2 02/01/2025</h5>
            </div>
            
            <h3>Centro de Innovación y Desarrollo Agroalimentario de<br>Michoacán A.C</h3>
        </div>
    
        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td></td>
                    <td>Fecha:</td>
                    <td>17/07/2025</td>
                </tr>
                </table>
                </div>
                <div class="info-section2">
                <table class="info-table2">
                <tr>
                    <td></td>
                    <td>Concepto:</td>
                    <td>COMPROBANTE DE PAGO</td>
                </tr>
            
        </table>
</div>
        <table class="field-table">
            <tr>
                <td>Recibí de:</td>
                <td>ORALIA ARAGON MIRANDA</td>
            </tr>
        </table>

        <table class="field-table">
            <tr>
                <td>La cantidad de:</td>
                <td class="amount-cell">$4,900.00 Cuatro mil novecientos pesos</td>
            </tr>
        </table>

        <div class="concept-section">
            <table class="concept-table">
               <tr>
                <th COLSPAN=2 class="vacio"></th>
               </tr>
            
                <tr>
                    
                    <td>Por concepto de:</td>
                    <td>Orden de Servicio CIDAM: OCC25-1388</td>
                </tr>
            </table>
        </div>

        <table class="signature-table">
            <tr>
                <th>Entregó</th>
                <th>Recibió</th>
            </tr>
            <tr>
                <td>ORALIA ARAGON MIRANDA<br>CLIENTE</td>
                <td>L.A.E. Alejandro Lenin Ayala Jacuinde<br>ventas cidam</td>
            </tr>
        </table>

        <div class="footer-section">
            <table class="footer-table">
                <tr>
                    <td>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Segundo Recibo -->
    <div class="recibo-container">
        <div class="header">
             <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM" class="imagen-Logo">
            <h5>Recibo de pago R-UGII-101 Ed. 2 02/01/2025</h5>
            <h3>Centro de Innovación y Desarrollo Agroalimentario de<br>Michoacán A.C</h3>
        </div>

        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td></td>
                    <td>Fecha:</td>
                    <td>17/07/2025</td>
                </tr>
                </table>
                </div>
                <div class="info-section2">
                <table class="info-table2">
                <tr>
                    <td></td>
                    <td>Concepto:</td>
                    <td>COMPROBANTE DE PAGO</td>
                </tr>
            
            </table>
                </div>
        <table class="field-table">
            <tr>
                <td>Recibí de:</td>
                <td>ORALIA ARAGON MIRANDA</td>
            </tr>
        </table>

        <table class="field-table">
            <tr>
                <td>La cantidad de:</td>
                <td class="amount-cell">$4,900.00 Cuatro mil novecientos pesos M.N.</td>
            </tr>
        </table>

        <div class="concept-section">
            <table class="concept-table">
                <tr>
                <th COLSPAN=2 class="vacio"></th>
               </tr>
            
                <tr>
                    
                    <td>Por concepto de:</td>
                    <td>Orden de Servicio CIDAM: OCC25-1388</td>
                </tr>
            </table>
        </div>

        <table class="signature-table">
            <tr>
                <th>Entregó</th>
                <th>Recibió</th>
            </tr>
            <tr>
                <td>ORALIA ARAGON MIRANDA<br>CLIENTE</td>
                <td>L.A.E. Alejandro Lenin Ayala Jacuinde<br>ventas cidam</td>
            </tr>
        </table>
    </div>  

    <table class="admin-table">
            <tr>
                <th style="border: none;"></th>
                <th style="border: none;"></th>
            </tr>
            <tr>
                <td style="width: 50%;">Nombre y firma de recibido de Administración:</td>
                <td style="width: 50%;"></td>
            </tr>
                    
                
            </table>
</body>
</html>
