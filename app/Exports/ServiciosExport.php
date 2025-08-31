<?php

namespace App\Exports;

use App\Models\Servicio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiciosExport implements FromCollection, WithHeadings
{
    protected $servicios;

    public function __construct($servicios)
    {
        $this->servicios = $servicios;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->servicios->map(function ($servicio) {
            $laboratorios = $servicio->laboratorios->map(function ($lab) {
                return "{$lab->laboratorio} ({$lab->pivot->precio}) - Clave: {$lab->clave}";
            })->implode(', ');

            return [
                'clave' => $servicio->clave,
                'nombre' => $servicio->nombre,
                'tipo_servicio' => $servicio->tipo_servicio,
                'precio' => $servicio->precio,
                'laboratorios' => $laboratorios,
            ];
        });
    }

    /**
     * Define los encabezados de las columnas del archivo Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Clave',
            'Servicio',
            'Tipo',
            'Precio',
            'Laboratorios',
        ];
    }
}
