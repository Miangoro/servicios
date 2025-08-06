<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ClientesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $clientes;
    protected $request;

    public function __construct($clientes, Request $request)
    {
        $this->clientes = $clientes;
        $this->request = $request;
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
            'Razón Social',
            'RFC',
            'Régimen',
            'Estado',
            'Municipio',
            'Localidad',
            'Colonia',
            'Calle',
            'No. Exterior',
            'Código Postal',
            'Teléfono',
            'Correo',
            'Constancia',
        ];

        // Añade la columna 'Estado de Crédito' si el filtro correspondiente está activado
        if ($this->request->boolean('enableFiltroCredito') && $this->request->filled('credito') && $this->request->input('credito') !== 'todos') {
            $headings[] = 'Estado de Crédito';
        }

        // Añade la columna 'Estado de Pago' si el filtro correspondiente está activado
        if ($this->request->boolean('enableFiltroPago') && $this->request->filled('estado_pago') && $this->request->input('estado_pago') !== 'todos') {
            $headings[] = 'Estado de Pago';
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
                // Usamos la relación cargada 'catalogoRegimen' para obtener el nombre
                'Régimen' => $cliente->catalogoRegimen ? $cliente->catalogoRegimen->nombre : null,
                'Estado' => $cliente->estado,
                'Municipio' => $cliente->municipio,
                'Localidad' => $cliente->localidad,
                'Colonia' => $cliente->colonia,
                'Calle' => $cliente->calle,
                'No. Exterior' => $cliente->noext,
                'Código Postal' => $cliente->codigo_postal,
                'Teléfono' => $cliente->telefono,
                'Correo' => $cliente->correo,
                // Genera la URL pública para la constancia PDF si existe
                'Constancia' => $cliente->constancia ? url(Storage::url($cliente->constancia)) : '',
            ];

            // Añade el valor de 'Crédito' si el filtro está activado
            if ($this->request->boolean('enableFiltroCredito') && $this->request->filled('credito') && $this->request->input('credito') !== 'todos') {
                $data['Estado de Crédito'] = $cliente->credito;
            }

            // Añade el valor de 'Estado de Pago' si el filtro está activado
            if ($this->request->boolean('enableFiltroPago') && $this->request->filled('estado_pago') && $this->request->input('estado_pago') !== 'todos') {
                $data['Estado de Pago'] = $cliente->estado_pago;
            }

            return $data;
        });
    }
}
