<!-- Modal para visualizar PDF (Botón en Encabezado) -->
<div class="modal fade" id="viewPdfModal" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered"> {{-- Tamaño 'xl' para el iframe --}}
        <div class="modal-content">
            <div class="modal-header bg-orange-header d-flex align-items-center justify-content-between"> {{-- Encabezado naranja, flexbox para alinear --}}
                <h5 class="modal-title text-white" id="viewPdfModalLabel">Documento</h5> {{-- Título "Documento" --}}
                <div class="d-flex align-items-center">
                    <a id="openPdfInNewTabBtn" href="#" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 py-2 me-2">Abrir en otra pestaña</a> {{-- Botón verde más pequeño, redondeado, con margen a la derecha --}}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> {{-- Botón de cerrar blanco --}}
                </div>
            </div>
            <div class="modal-body text-center py-3"> {{-- Cuerpo de la modal para el iframe y mensaje de carga --}}
                <p id="pdfLoadingMessage" class="text-muted" style="display: none;">Cargando PDF... Si no se muestra aquí, por favor, usa el botón "Abrir en otra pestaña".</p>
                <iframe id="pdfViewerFrame" style="width: 100%; height: 70vh; border: none; display: none;"></iframe>
            </div>
            {{-- El modal-footer se ha eliminado ya que el botón está en el encabezado --}}
        </div>
    </div>
</div>

<style>
    /* Estilo para el encabezado naranja */
    .bg-orange-header {
        background-color: #17cd75ff !important; /* Naranja más oscuro para contraste */
    }
    /* Estilo para el botón de cerrar blanco en encabezados oscuros */
    .btn-close-white {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") !important;
        opacity: 1 !important;
    }
    .btn-close-white:hover {
        opacity: 0.75 !important;
    }
    /* Ajuste para el título para que esté a la izquierda (ya manejado por justify-content-between) */
    .modal-header .modal-title {
        text-align: left;
        /* margin-right: auto; Ya no es necesario con justify-content-between */
    }
</style>
