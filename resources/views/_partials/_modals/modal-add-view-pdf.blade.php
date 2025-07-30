<!-- Modal para visualizar PDF (asegúrate de que esta modal exista en tu HTML principal) -->
<div class="modal fade" id="viewPdfModal" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="viewPdfModalLabel">Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body text-center">
                <p id="pdfLoadingMessage" style="display: none;">Cargando PDF...</p>
                <iframe id="pdfViewerFrame" style="width: 100%; height: 72vh; border: none; display: none;"></iframe>
            </div>
            <div class="modal-footer">
                <a id="openPdfInNewTabBtn" href="#" target="_blank" class="btn btn-primary">Abrir en nueva pestaña</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>