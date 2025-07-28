<!-- resources/views/_partials/_modals/modal-add-view-pdf.blade.php -->
<div class="modal fade" id="viewPdfModal" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado de la modal con estilo personalizado (fondo verde, texto blanco) -->
            <div class="modal-header" style="background-color: #28a745; color: #fff; padding: 0.75rem 1rem; border-bottom: 1px solid #dee2e6; display: flex; align-items: center;">
                <h5 class="modal-title" id="viewPdfModalLabel" style="font-weight: bold; font-size: 1.1rem; color: #fff;">Documento</h5>
                
                <!-- Botón "Abrir en otra pestaña" (azul) -->
                <!-- Se eliminó ms-auto para que el botón se posicione más a la izquierda -->
                <a id="openPdfInNewTabBtn" href="#" target="_blank" class="btn btn-primary btn-sm me-2" style="background-color: #007bff; border-color: #007bff; border-radius: 0.3rem; padding: 0.4rem 0.8rem; font-size: 0.9rem; color: #fff; text-decoration: none;">
                    Abrir en otra pestaña
                </a>
                
                <!-- Botón de cerrar la modal -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(1) brightness(2);"></button>
            </div>
            <div class="modal-body p-0" style="height: 80vh; display: flex; justify-content: center; align-items: center;">
                <!-- Iframe para cargar el PDF -->
                <iframe id="pdfViewerFrame" src="" frameborder="0" width="100%" height="100%" style="border: none;"></iframe>
                <!-- Mensaje de carga o error (opcional, si el PDF no carga) -->
                <div id="pdfLoadingMessage" style="position: absolute; color: #6c757d; font-size: 1.2rem; display: none;">Cargando PDF...</div>
            </div>
            <!-- No se necesita footer si el botón "Abrir en otra pestaña" está en el header -->
        </div>
    </div>
</div>

<!-- Estilos personalizados para el botón de abrir en otra pestaña al pasar el ratón -->
<style>
    #openPdfInNewTabBtn:hover {
        background-color: #ffffff !important; /* Fondo blanco al pasar el ratón */
        color: #007bff !important; /* Texto azul al pasar el ratón para contraste */
        border-color: #007bff !important; /* Borde azul al pasar el ratón */
    }
</style>
