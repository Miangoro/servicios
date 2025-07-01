<!--MODAL GENERAL PDF's-->
<div class="modal fade" id="mostrarPdf" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     

      <div id="encabezado_modal"  class="modal-header bg-primary pb-6 text-center">
                 <a id="NewPestana" href="#" target="_blank" class="btn btn-info btn-sm" style="display: none;">
          Abrir en nueva pestaña
        </a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-0">
          <h4 id="titulo_modal" class="address-title mb-2"></h4>
          <p id="subtitulo_modal" class="address-subtitle"></p>
        </div>
        <div id="cargando" class="text-center my-3" style="display: flex; height: 70vh; justify-content: center; align-items: center;">
          <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
          </div>
        </div>
        <iframe src="" id="pdfViewer" width="100%" height="800px" style="border: none;"></iframe>
      </div>
    </div>
  </div>
</div>


<!--/  Modal para dictamenes grnel-->
<div class="modal fade" id="mostrarPdfDictamen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-6">
          <h4 id="titulo_modal_Dictamen" class="address-title mb-2"></h4>
          <p id="subtitulo_modal_Dictamen" class="address-subtitle"></p>
        </div>

        <div id="loading-spinner" class="text-center my-3" style="display: flex; height: 70vh;   justify-content: center;  align-items: center;">
          <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
          </div>
        </div>

        <iframe src="" id="pdfViewerDictamen" width="100%" height="800px" style="border: none;"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mostrarPdfDictamen1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
    <a id="openPdfBtnDictamen1" href="#" target="_blank" class="btn btn-primary btn-sm ms-auto" style="display: none;">Abrir PDF en nueva pestaña</a>
      <div class="modal-header d-flex justify-content-center">
        <h4 id="titulo_modal_Dictamen1" style="text-align: center; flex-grow: 1;"></h4>
        <!-- Botón de cierre más pequeño y alineado a la derecha -->
      </div><button type="button" class="btn-close btn-sm ml-auto" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-6">
          <p id="subtitulo_modal_Dictamen1" class="address-subtitle"></p>
        </div>
        <div id="loading-spinner1" class="text-center my-3" style="display: flex; height: 70vh; justify-content: center; align-items: center;">
          <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
          </div>
        </div>

        <iframe src="" id="pdfViewerDictamen1" width="100%" height="800px" style="border: none;"></iframe>
      </div>
    </div>
  </div>
</div>







<!-- Modal para dictamenes guias -->
<div class="modal fade" id="mostrarPdfGUias" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
      <button type="button" class="btn-close" id="btnX" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-6">
          <h4 id="titulo_modal_GUIAS" class="address-title mb-2"></h4>
          <p id="subtitulo_modal_GUIAS" class="address-subtitle"></p>
        </div>

        <div id="loading-spinner-chelo" class="text-center my-3" style="display: flex; height: 70vh;   justify-content: center;  align-items: center;">
          <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
          </div>
        </div>
        <!-- Botón para descargar el PDF -->
<!--         <a href="#" id="descargarPdfBtn" class="btn btn-primary position-absolute waves-effect" style="top: 0; right: 0; margin: 15px;">Descargar PDF</a>
 -->          <iframe src="" id="pdfViewerGuias" width="100%" height="800px" style="border: none;"></iframe>

      </div>
    </div>
  </div>
</div>


<script>
  //funcion para reditrigir a otra vista
document.addEventListener("DOMContentLoaded", function() {
  // Selecciona los botones por su id
  const closeModalButtons = [document.getElementById("btnX")];

  closeModalButtons.forEach(button => {
    button.addEventListener("click", function(event) {
      // Encuentra el modal padre del botón de cierre
      const modalElement = button.closest('.modal');

      // Asegúrate de que no sea el modal #verGuiasRegistardas
      if (modalElement && modalElement.id !== "verGuiasRegistardas") {
        // Espera a que el modal actual se cierre antes de abrir el nuevo modal
        setTimeout(() => {
          // Abre el modal de guías registradas
          const verGuiasRegistardasModal = new bootstrap.Modal(document.getElementById("verGuiasRegistardas"));
          verGuiasRegistardasModal.show();
        }, 300); // Ajusta el tiempo para asegurar que el modal anterior se cierre completamente
      }
    });
  });
});
</script>




