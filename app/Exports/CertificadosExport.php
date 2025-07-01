<?php

namespace App\Exports;

use App\Models\Certificado_Exportacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CertificadosExport implements FromCollection, WithHeadings, WithEvents, WithMapping
{
    protected $filtros;

    public function __construct($filtros)
    {
        $this->filtros = $filtros;
    }

    public function collection()
    {
        $query = Certificado_Exportacion::query()
            ->leftJoin('dictamenes_exportacion', 'dictamenes_exportacion.id_dictamen', '=', 'certificados_exportacion.id_dictamen')
            ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_exportacion.id_inspeccion')
            ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
            ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa');
            //->select('empresa.razon_social', 'certificados_exportacion.num_certificado', 'certificados_exportacion.fecha_emision', 'certificados_exportacion.fecha_vigencia', 'certificados_exportacion.estatus');

        // Aplicar filtros
        if (!empty($this->filtros['id_empresa'])) {
            $query->where('empresa.id_empresa', $this->filtros['id_empresa']);
        }

        if (!empty($this->filtros['anio'])) {
            $query->whereYear('certificados_exportacion.fecha_emision', $this->filtros['anio']);
        }

        if (!empty($this->filtros['mes'])) {
            $query->whereMonth('certificados_exportacion.fecha_emision', $this->filtros['mes']);
        }

        if (!empty($this->filtros['estatus'])) {
            $query->where('certificados_exportacion.estatus', $this->filtros['estatus']);
        }

        // Ordenar por empresa
        return $query->orderBy('certificados_exportacion.fecha_emision', 'asc')->get();
    }

    public function headings(): array
{
    return [
        ['Reporte de Certificados de Exportación'],
        ['ESTATUS', 'FECHA DE EXPEDICIÓN', 'No. DE CERTIFICADO', 'EMPRESA', 'LOTE ENVASADO', 'LOTE GRANEL', 'MARCA', 'PAÍS DESTINO', 'No. DE BOTELLAS', 'CONTENIDO', 'TOTAL DE LITROS', '% ALC. VOL']
    ];
}


    public function map($certificado): array
{
    //dd($certificado->estatus);
    //dd($certificado->pluck('estatus')->unique()); 

//Lote envasado
$lotes_env = $certificado->dictamen?->inspeccione?->solicitud?->lotesEnvasadoDesdeJson();//obtener todos los lotes
$lotes_envasados = $lotes_env?->pluck('nombre')->implode(', ') ?? 'No encontrado';
$marca = $lotes_env?->first()?->marca->marca ?? 'No encontrado';
$presentacion = $lotes_env?->first()
    ? $lotes_env->first()->presentacion . ($lotes_env->first()->unidad ? ' ' . $lotes_env->first()->unidad : '')
    : 'No encontrado';
//Lote granel
$lotes_gra = $lotes_env?->flatMap(function ($lote) {
    return $lote->lotesGranel; // Relación definida en el modelo lotes_envasado
    })->unique('id_lote_granel');//elimina duplicados
$lotes_granel = $lotes_gra?->pluck('nombre_lote')->implode(', ') ?? 'No encontrado';
$cont_alc = $lotes_gra?->first()?->cont_alc?? 'No encontrado';
$caracteristicas = $certificado->dictamen?->inspeccione?->solicitud?->caracteristicasDecodificadas() ?? [];

$estado= $certificado->estatus; // <-- Muestra el valor original
    return [
        /*match ((int) $estado) {
            0 => 'Emitido',
            1 => 'Cancelado',
            2 => 'Reexpedido',
            default => 'No encontrado',
        },*/
        $certificado->estatus,
        Carbon::parse($certificado->fecha_emision)->translatedFormat('d \d\e F \d\e Y'),
        $certificado->num_certificado ?? 'No encontrado',
        $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        $lotes_envasados,
        $lotes_granel,
        $marca,
        $certificado->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'No encontrado',
        collect($caracteristicas['detalles'] ?? [])->first()['cantidad_botellas'] ?? 'No encontrado',
        $presentacion,
        'pendiente',
        $cont_alc,
    ];
}

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            // **Título**
            $sheet->mergeCells('A1:L1');
            $sheet->getStyle('A1:L1')
                ->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('000000');
            $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // **Encabezados**
            $sheet->getStyle('A2:L2')
                ->getFont()->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle('A2:L2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2:L2')
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('8eaadc');

            // **Color Verde para "No. DE CERTIFICADO"**
            $sheet->getStyle('C2')->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle('C2')->getFill()->getStartColor()->setARGB('00FF00'); // Verde
            $sheet->getStyle('C2')->getFont()->setBold(true)->setSize(12);

            // **Color Naranja para "EMPRESA"**
            $sheet->getStyle('E2')->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle('E2')->getFill()->getStartColor()->setARGB('FFA500'); // Naranja
            $sheet->getStyle('E2')->getFont()->setBold(true)->setSize(12);

            // **Formato general para las columnas**
            foreach (range('A', 'L') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            $sheet->getStyle('A2:L' . ($event->sheet->getHighestRow()))
                ->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }
    ];
}
}