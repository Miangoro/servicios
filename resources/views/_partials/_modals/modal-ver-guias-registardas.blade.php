<style>
    .modal-custom-size {
        max-width: 100%;
        width: 50%;
    }

    /* Estilo para pantallas pequeñas (móviles) */
    @media (max-width: 768px) {
        .modal-custom-size {
            width: auto;
        }
    }
</style>
<div class="modal fade" id="verGuiasRegistardas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Guías de traslado</h4>
                    <p class="address-subtitle"></p>
                </div>

                <form id="verGuiasRegistardasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="d-flex justify-content-center mb-3">
                        <a href="#" id="descargarPdfBtn" class="btn btn-primary waves-effect">Descargar PDFs</a>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>folio</th>
                                        <th>Guía</th>
                                        <th>Abrir Guia</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablita">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cerrar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
