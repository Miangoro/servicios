<?php

namespace App\Http\Controllers\pdfscontrollers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\PdfModifier;
use Illuminate\Http\Request;

class CartaAsignacionController extends Controller
{
    public function index()
    {
        $pdf = Pdf::loadView('pdfs.CartaAsignacion');
        return $pdf->stream('NOM-070-341C_Asignacion-de-numero-de-cliente.pdf');
    }
    public function info()
    {
        $pdf = Pdf::loadView('pdfs.SolicitudInfoCliente');
        return $pdf->stream('F7.1-01-02  Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V-052-NORMEX-2016 Ed.pdf');
    }

    //vista
    public function ServicioPersonaFisica()
    {
        $pdf = Pdf::loadView('pdfs.prestacion_servicio_fisica');
        return $pdf->stream('F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 persona fisica VIGENTE.pdf');
    }


    //vista servicio persona vigente

    public function ServicioPersonaVigente()
    {
        $pdf = Pdf::loadView('pdfs.prestacion_servicios_vigente');
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        // Añadir script de página después de renderizar
        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $canvas->text(520, 820, "Página $pageNumber de $pageCount", $fontMetrics->get_font("Arial", "normal"), 12);
        });

        return $pdf->stream('F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 VIGENTE.pdf');
    }

    public function Contrato_NMX_052()
    {
        $pdf = Pdf::loadView('pdfs.CONTRATO_NMX-052');
        return $pdf->stream('F4.1-01-12 CONTRATO NMX-052 Ed 0.pdf');
    }

    public function Contrato_prestacion_servicio_NOM_199()
    {
        $pdf = Pdf::loadView('pdfs.Contrato_prestacion_servicio_NOM_199');
        return $pdf->stream('F4.1-01-07 Contrato Prestación de Servicios NOM-199 Ed 5 VIGENTE.pdf');
    }




    public function solicitudInfoNOM_199()
    {
        $pdf = Pdf::loadView('pdfs.solicitudInfoClienteNOM-199');
        return $pdf->stream('F7.1-03-02 Solicitud de Información al Cliente NOM-199-SCFI-2017 Ed. 4 VIGENTE.pdf');
    }

    public function access_user()
    {
        $pdf = Pdf::loadView('pdfs.AsignacionUsuario');
        return $pdf->stream('F7.1-01-46 Carta de asignación de usuario y contraseña para plataforma del OC Ed. 0, Vigente.pdf');
    }

    //PDF Dictamen de instalaciones
    public function dictamenp()
    {
        $pdf = Pdf::loadView('pdfs.DictamenProductor');
        return $pdf->stream('F-UV-02-04 Ver 10, Dictamen de cumplimiento de Instalaciones como productor.pdf');
    }
    public function dictamene()
    {
        $pdf = Pdf::loadView('pdfs.DictamenEnvasado');
        return $pdf->stream('F-UV-02-11 Ver 5, Dictamen de cumplimiento de Instalaciones como envasador.pdf');
    }
    public function dictamenc()
    {
        $pdf = Pdf::loadView('pdfs.DictamenComercializador');
        return $pdf->stream('F-UV-02-12 Ver 5, Dictamen de cumplimiento de Instalaciones como comercializador.pdf');
    }

    public function solicitudservi()
    {
        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio');
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }

    public function DictamenDeCumplimienoInstalaciones()
    {
        $pdf = Pdf::loadView('pdfs.DictamenDeCumplimienoInstalaciones');
        return $pdf->stream('F-UV-04-18 Ver 2. Dictamen de Cumplimiento para Producto de Exportación.pdf');
    }

    //Guias de translado
    /*     public function guiasTranslado()
    {
        $pdf = Pdf::loadView('pdfs.GuiaDeTranslado');
        return $pdf->stream('539G005_Guia_de_traslado_de_maguey_o_agave.pdf');
    } */

    public function Etiqueta()
    {
      $pdf = Pdf::loadView('pdfs.Etiqueta-2401ESPTOB');
      return $pdf->stream('Etiqueta-2401ESPTOB.pdf');
    }


    public function Etiqueta_Granel()
    {
        // Renderizar el PDF por primera vez para obtener el total de páginas
        $pdf = Pdf::loadView('pdfs.Etiqueta_lotes_mezcal_granel');
        $dompdf = $pdf->getDomPDF();
        $dompdf->render();

        // Obtener el total de páginas
        $totalPaginas = $dompdf->get_canvas()->get_page_count();

        // Pasar el total de páginas a la vista para la segunda renderización
        $pdfFinal = Pdf::loadView('pdfs.Etiqueta_lotes_mezcal_granel', [
            'totalPaginas' => $totalPaginas
        ]);

        // Retornar el PDF final
        return $pdfFinal->stream('Etiqueta para lotes de mezcal a granel.pdf');
    }

    //Certificados
    public function Certificadocom()
    {
        $pdf = Pdf::loadView('pdfs.Certificado_comercializador');
        return $pdf->stream('Certificado de comercializador.pdf');
    }

    public function Certificadoenv()
    {
        $pdf = Pdf::loadView('pdfs.Certificado_envasador_mezcal');
        return $pdf->stream('Certificado de envasador de mezcal.pdf');
    }

    public function Certificadoprod()
    {
        $pdf = Pdf::loadView('pdfs.Certificado_productor_mezcal');
        return $pdf->stream('Certificado de productor de mezcal.pdf');
    }

    //PDF oficio de comisión
    public function Comision()
    {
        $pdf = Pdf::loadView('pdfs.oficioDeComision');
        return $pdf->stream('F-UV-02-09 Oficio de Comisión Ed.5, Vigente.pdf');
    }

    //PDF orden de servicio
    public function Servicio()
    {
        $pdf = Pdf::loadView('pdfs.ordenDeServicio');
        return $pdf->stream('F-UV-02-01 Orden de servicio Ed. 5, Vigente.pdf');
    }

    //PDF certificado de exportacion
    public function certificadoDeExportacion()
    {
        $pdf = Pdf::loadView('pdfs.certificadoDeExportacion');
        return $pdf->stream('F7.1-01-23 Certificado de Exportación NOM-070-SCFI-2016.pdf');
    }

    //PDF de solicitud de hologramas
    /*     public function solicitudHologramas()
    {
        $pdf = Pdf::loadView('pdfs.solicitudDeHologramas');
        return $pdf->stream('INV-4232024-Nazareth_Camacho_.pdf');
    } */

    public function InspeccionGeoReferenciacion()
    {
        $pdf = Pdf::loadView('pdfs.inspeccion_geo_referenciacion');
        /*     $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    // Añadir script de página después de renderizar
    $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
        $canvas->text(520, 820, "Página $pageNumber de $pageCount", $fontMetrics->get_font("Arial", "normal"), 12);
    }); */
        return $pdf->stream('F-UV-21-02 Inspección para la geo-referenciación de los predios de maguey o agave Ed. 6 Vigente.pdf');
    }

    public function dictamenDeCumplimientoGranel()
    {
        $pdf = Pdf::loadView('pdfs.DictamenDeCumplimientoMezcalGranel');
        return $pdf->stream('F-UV-04-16 Ver 7 Dictamen de Cumplimiento NOM Mezcal a Granel.pdf');
    }

    public function Etiqueta_muestra()
    {
        $pdf = Pdf::loadView('pdfs.Etiqueta_tapa_muestra');
        return $pdf->stream('Etiqueta_para_tapa_de_la_muestra.pdf');
    }

    public function Dictamen_Cumplimiento()
    {
        $pdf = Pdf::loadView('pdfs.Dictamen_cumplimiento_Instalaciones');
        return $pdf->stream('F-UV-02-13 Ver 1, Dictamen de cumplimiento de Instalaciones almacen.pdf');
    }

    public function Etiqueta_Barrica()
    {
        $pdf = Pdf::loadView('pdfs.Etiqueta_Barrica');
        return $pdf->stream('Etiqueta_ingreso_a_barrica.pdf');
    }

    //pdf Bitácora de revisión de certificados NOM de Instalaciones
    public function bitacora_revision_SCFI2016()
    {
        $pdf = Pdf::loadView('pdfs.bitacora_revision_SCFI2016');
        return $pdf->stream('NOM-070-SCFI-2016 Ed. 5.pdf');
    }

/*     public function botacora_revicionPersonalOCCIDAM()
    {
        $pdf = Pdf::loadView('pdfs.botacora_revicionPersonalOCCIDAM');
        return $pdf->stream('NOM-070-SCFI-2016 Ed. 5.pdf');
    } */

    //Plan de auditoria
    public function PlanDeAuditoria()
    {
        $pdf = Pdf::loadView('pdfs.PlanDeAuditoria');
        return $pdf->stream('Plan de auditoría de esquema de certificación F7.1-01-13.pdf');
    }

/*     public function PreCertificado()
    {
        $pdf = Pdf::loadView('pdfs.pre-certificado');
        return $pdf->stream('Pre-certificado CIDAM C-GRA-210 2024.pdf');
    } */

    public function DictamenMezcalEnvasado()
    {
        $pdf = Pdf::loadView('pdfs.Dictamen_cumplimiento_mezcal-envasado');
        return $pdf->stream('F-UV-04-17 Ver 6. Dictamen de Cumplimiento NOM de Mezcal Envasado.pdf');
    }

    //Plan de auditoria
    public function CertificadoConformidad199()
    {
        $pdf = Pdf::loadView('pdfs.CertificadoDeConformidadNOM-199');
        return $pdf->stream('F7.1-03-17 Certificado de conformidad NOM-199-SCFI-2017.pdf');
    }

/*
    public function CertificadoConformidad199()
    {
        $pdf = Pdf::loadView('pdfs.CertificadoDeConformidadNOM-199');
        return $pdf->stream('F7.1-03-17 Certificado de conformidad NOM-199-SCFI-2017 Ed. 9 vigente.pdf');
    }
 */
    //certificado de instalaciones 052
    public function CertificadoComoProductor()
    {
        $pdf = Pdf::loadView('pdfs.CertificadoComoProductor');
        return $pdf->stream('F7.1-04-08 Certificado como Productor NMX-V-052-NORMEX-2016 Ed. 1 Vigente.pdf');
    }
    public function CertificadoComoComercializador ()
    {
        $pdf = Pdf::loadView('pdfs.CertificadoComoComercializador');
        return $pdf->stream('F7.1-04-10 Certificado como Comercializador NMX-V-052-NORMEX-2016 Ed. 1 Vig.pdf');
    }
    public function CertificadoComoEnvasador ()
    {
        $pdf = Pdf::loadView('pdfs.CertificadoComoEnvasador');
        return $pdf->stream('F7.1-04-09 Certificado como Envasador NMX-V-052-NORMEX-2016 Ed. 1 Vigente.pdf');
    }

    public function PlanAuditoria ()
    {
        $pdf = Pdf::loadView('pdfs.Plan_auditoria_esquema');
        return $pdf->stream('F7.1-04-15 Plan de auditoría de esquema de cert NMX-V-052 Ed 0, VIG.pdf');

    }

    public function SolicitudDeServicios052 ()
    {
        $pdf = Pdf::loadView('pdfs.SolicitudDeServicios052');
        return $pdf->stream('F7.1-04-07 Solicitud de servicios NMX-V-052-NORMEX-2016 Ed. 1, Vigente.pdf');
    }

    public function ReporteTecnico ()
    {
        $pdf = Pdf::loadView('pdfs.Reporte_Tecnico-cumplimiento');
        return $pdf->stream('F7.1-03-24 Reporte Técnico de cumplimiento NOM-199-SCFI-2017 Ed 9 VIGENTE.pdf');
    }

    public function OrdenTrabajoInspeccionEtiquetas(){
        $pdf = Pdf::loadView('pdfs.orden_trabajo_inspeccion_etiquetas');
        return $pdf->stream('R-UNIIC-004 Orden de trabajo de inspección de etiquetas, tq CAFE.pdf');
    }

    public function SolicitudEspecificaciones(){
        $pdf = Pdf::loadView('pdfs.Solicitud-Especificaciones');
        return $pdf->stream('R-UNIIC-001 Solicitud y especificaciones del Servicio para emisión de Constancias de Conformidad JUAN RAMÓN.pdf');

    }

    public function ListaVerificacionNom051Mod20200327Solrev005(){
        $pdf = Pdf::loadView('pdfs.lista_verificacion_nom051-mod20200327_solrev005');
        return $pdf->stream('R-UNIIC-005, Lista de Verificación  NOM-051-SCFI_SSA1-2010 y MOD 27.03.2020 SOL-REV-005.PDF');
    }

    public function OrdenTrabajo () {
        $pdf = Pdf::loadView('pdfs.Orden-Trabajo');
        return $pdf->stream('Copia de R-UNIIC-004 Orden de trabajo de inspección de etiquetas, tq CAFE.PDF');
    }

    public function  Contancia_trabajo() {
        $pdf = Pdf::loadView('pdfs.Constancia_de _conformidad');
        return $pdf->stream('R-UNIIC-010 Constancia de Conformidad NOM-142-SSA1_SCFI-2014 Ed. 1 Vigente.pdf');
    }

    public function SolicitudUNIIC() {
        $pdf = Pdf::loadView('pdfs.Solicitud-Servicio-UNIIC');
        return $pdf->stream('Solicitud de servicio UNIIC.pdf');
    }

    public function RegistroPrediosMagueyAgave() {
      $pdf = Pdf::loadView('pdfs.Registro_de_Predios_Maguey_Agave');
      return $pdf->stream('Registro de Predios Maguey Agave.pdf');
    }

    public function InformeInspeccionEtiqueta() {
        $pdf = Pdf::loadView('pdfs.Informe_de_inspección_de_etiqueta');
        return $pdf->stream('Informe_de_inspección_de_etiqueta,_Ed_1,_Vigente.pdf');
    }

    public function BitacoraMezcal() {
        $pdf = Pdf::loadView('pdfs.Bitacora_Mezcal')->setPaper('letter', 'landscape');
        return $pdf->stream('Bitácora Mezcal a Granel.pdf');
    }

    public function BitacoraMaduracion() {
        $pdf = Pdf::loadView('pdfs.Bitacora_Maduracion')->setPaper('letter', 'landscape');
        return $pdf->stream('Bitácora Producto en Maduración.pdf');
    }

    public function BitacoraProductor() {
        $pdf = Pdf::loadView('pdfs.Bitacora_Productor')->setPaper('letter', 'landscape');
        return $pdf->stream('Bitácora de Productor.pdf');
    }

    public function BitacoraTerminado() {
        $pdf = Pdf::loadView('pdfs.Bitacora_Terminado')->setPaper('letter', 'landscape');
        return $pdf->stream('Bitácora Producto Terminado.pdf');
    }

    public function BitacoraHologramas() {
        $pdf = Pdf::loadView('pdfs.Bitacora_Hologramas')->setPaper('letter', 'landscape');
        return $pdf->stream('Bitácora De Hologramas.pdf');
    }

    public function informeresulta(){
      $pdf = Pdf::loadView('pdfs.informe_resultados');
      return $pdf->stream('Registro de muestras y Reportes de resultados plaguicidas 2025.pdf');
    }
}
