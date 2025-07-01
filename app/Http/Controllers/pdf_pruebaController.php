<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class pdf_pruebaController extends Controller
{
    function ver_pdf(){
        $pdf = Pdf::loadView('pdf_prueba');
        return $pdf->stream('prueba.pdf'); //Para visualizar
    }
}
