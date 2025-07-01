<!-- MODAL CERTIFICADO FIRMADO -->
<div class="modal fade" id="ModalCertificadoFirmado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header bg-primary pb-4">
          <h5 class="modal-title text-white" id="modalTitulo">TITULO DEL MODAL (cer.INSTALACION Y GRANEL)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <form id="FormCertificadoFirmado" enctype="multipart/form-data">
        
            <input type="hidden" id="doc_id_certificado" name="id_certificado">
            <div class="mb-3">
                <label for="nuevoDocumento" class="form-label">Subir certificado firmado (.pdf)</label>
                <input type="file" class="form-control" id="nuevoDocumento" name="documento" accept="application/pdf" required>
            
                <div id="documentoActual" class="mt-2">
                  <!-- Aquí se mostrará el documento -->
                </div>
            </div>

            
          <div class="d-flex mt-6 justify-content-center">
            <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Registrar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="ri-close-line"></i> Cancelar</button>
          </div>

          </form>
        </div>

    </div>
  </div>
</div>
