<?php

namespace App\Exports;

use App\Models\Servicio;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ServiciosExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    protected $servicios;

    public function __construct(Collection $servicios)
    {
        $this->servicios = $servicios;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->servicios;
    }

    /**
     * @param mixed $servicio
     * @return array
     */
    public function map($servicio): array
    {
        // Lógica para cambiar el valor del tipo de servicio de 2 a 'Especializados'
        $tipo_servicio = ($servicio->tipo_servicio == 2) ? 'Especializados' : 'Otros';

        $laboratorios = $servicio->laboratorios->map(function ($lab) {
            return "{$lab->laboratorio} ({$lab->pivot->precio}) - Clave: {$lab->clave}";
        })->implode(', ');

        return [
            $servicio->clave,
            $servicio->nombre,
            $tipo_servicio, // Valor modificado
            $servicio->precio,
            $laboratorios,
        ];
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

    /**
     * Define el formato de las columnas.
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            // La columna 'D' corresponde a 'Precio'.
            // Cambia 'D' si el orden de tus encabezados es diferente.
            'D' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }
}
