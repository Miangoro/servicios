<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request; // Importar la clase Request

class ClientesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $clientes;
    protected $request; // Para almacenar el objeto Request

    public function __construct($clientes, Request $request)
    {
        $this->clientes = $clientes;
        $this->request = $request; // Asignar el objeto Request
    }

    /**
     * Define los encabezados de las columnas en el archivo Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'ID',
            'Razón Social', // Renombrado de 'Nombre Empresa'
            'RFC',
            'Régimen', // Renombrado de 'Regimen'
            'Estado',
            'Municipio',
            'Localidad',
            'Colonia', // Nueva columna
            'Calle',
            'No. Exterior', // Renombrado de 'No. Exterior'
            'Código Postal', // Renombrado de 'CP'
            'Teléfono',
            'Correo',
            'Constancia',
        ];

        // Añadir columna 'Crédito' solo si el filtro de Crédito fue aplicado
        if ($this->request->has('enableFiltroCredito') && $this->request->input('enableFiltroCredito') === 'on' && $this->request->filled('credito') && $this->request->input('credito') !== 'todos') {
            $headings[] = 'Estado de Crédito'; // Nombre de la columna para el Excel
        }

        // Añadir columna 'Estado de Pago' solo si el filtro de Estado de Pago fue aplicado
        if ($this->request->has('enableFiltroPago') && $this->request->input('enableFiltroPago') === 'on' && $this->request->filled('estado_pago') && $this->request->input('estado_pago') !== 'todos') {
            $headings[] = 'Estado de Pago'; // Nombre de la columna para el Excel
        }

        return $headings;
    }

    /**
     * Retorna la colección de clientes mapeada a las columnas deseadas.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->clientes->map(function($cliente) {
            $data = [
                'ID' => $cliente->id,
                'Razón Social' => $cliente->nombre,
                'RFC' => $cliente->rfc,
                'Régimen' => $cliente->regimen, // Asumiendo que 'regimen' ya contiene el nombre del régimen
                'Estado' => $cliente->estado,
                'Municipio' => $cliente->municipio,
                'Localidad' => $cliente->localidad,
                'Colonia' => $cliente->colonia, // Asegúrate que 'colonia' es el nombre correcto de la columna
                'Calle' => $cliente->calle,
                'No. Exterior' => $cliente->noext, // Asumiendo 'noext' es la columna
                'Código Postal' => $cliente->codigo_postal, // Asumiendo 'codigo_postal' es la columna
                'Teléfono' => $cliente->telefono, // Asumiendo 'telefono' es la columna
                'Correo' => $cliente->correo,
                'Constancia' => $cliente->constancia ? url(Storage::url($cliente->constancia)) : '', // Genera URL pública para la constancia PDF
            ];

            // Añadir el valor de 'Crédito' solo si el filtro de Crédito fue aplicado
            if ($this->request->has('enableFiltroCredito') && $this->request->input('enableFiltroCredito') === 'on' && $this->request->filled('credito') && $this->request->input('credito') !== 'todos') {
                $data['Estado de Crédito'] = $cliente->credito; // Asegúrate que 'credito' es el nombre correcto de la columna
            }

            // Añadir el valor de 'Estado de Pago' solo si el filtro de Estado de Pago fue aplicado
            if ($this->request->has('enableFiltroPago') && $this->request->input('enableFiltroPago') === 'on' && $this->request->filled('estado_pago') && $this->request->input('estado_pago') !== 'todos') {
                $data['Estado de Pago'] = $cliente->estado_pago; // Asegúrate que 'estado_pago' es el nombre correcto de la columna
            }

            return $data;
        });
    }
}
