<?php

namespace App\Http\Controllers\pdf_llenado;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use TCPDF; // Asegúrate de tener TCPDF instalado

class PdfController extends Controller
{
    public function generatePdf()
    {
        // Crear una instancia de TCPDF
        $pdf = new TCPDF();

        // Configuración del PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Autor');
        $pdf->SetTitle('Título del PDF');
        $pdf->SetSubject('Asunto');
        $pdf->SetKeywords('TCPDF, PDF, formulario, editable');

        $pdf->SetMargins(70, 40, 70);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);

        $pdf->AddPage();

        $pdf->SetFont('dejavusans', '', 10);

        // Contenido del PDF
        $pdf->setXY(50,20);
        $pdf->Cell(0, 10, 'Nombre / Razón Social:', 0, 0, 'L');
        $pdf->SetX(80);
        $pdf->TextField('nombre', 100, 10);

        $pdf->SetXY(50, 60);
        $pdf->Cell(0, 10, 'No. De Cliente:', 0, 0, 'L');
        $pdf->SetX(80);
        $pdf->TextField('cliente', 100, 10);

        $pdf->SetXY(50, 70);
        $pdf->Cell(0, 10, 'Dirección:', 0, 0, 'L');
        $pdf->SetX(80);
        $pdf->MultiCell(0, 10, 'Boulevard Fray Antonio de San Miguel No. 519, Int. Lote 13, Col. Fray Antonio de San Miguel, Morelia, Michoacán, C.P. 58277.');

        // Más campos...

        return $pdf->Output('pdf_editable.pdf', 'I');
    }
}
