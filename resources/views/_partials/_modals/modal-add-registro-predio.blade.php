   {{--  modal de edicion equisde --}}
   <div class="modal fade" id="modalAddRegistroPredio" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header bg-primary pb-4">
                   <h5 class="modal-title text-white">Agregar Registro del Predio</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body py-8">
                   <form id="modalAddRegistroPredioForm">
                       @csrf
                       <input type="hidden" id="id_predio_registro" name="id_predio" value="">
                       {{--  --}}
                       <!-- Datos del Predio -->
                       <div class="row mb-4">
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="num_predio" autocomplete="off"
                                       name="num_predio" placeholder="Número del predio"></input>
                                   <label for="num_predio">Número del predio</label>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control datepicker" id="fecha_emision"
                                       name="fecha_emision" autocomplete="off" placeholder="yyyy-mm-dd">
                                   <label for="fecha_emision">Fecha de emisión</label>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline">
                                   <input type="text" class="form-control datepicker" id="fecha_vigencia"
                                       name="fecha_vigencia" autocomplete="off" placeholder="yyyy-mm-dd">
                                   <label for="fecha_vigencia">Fecha de vigencia</label>
                               </div>
                           </div>
                           <div class="mb-3">
                               <label for="fuv2103" class="form-label mt-1">
                                  Adjuntar registro de predios de maguey o agave
                               </label>
                               <input class="form-control" type="file" id="fuv2103" name="fuv2103">
                           </div>
                           <div id="PrdocumentoPreview" class="mb-3"></div>
                       </div>


                       <div class="d-flex justify-content-center mt-3">
                           <button disabled class="btn btn-primary me-2 d-none" type="button"
                               id="btnSpinnerRegistroPredio">
                               <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                               Registrando...
                           </button>
                           <button type="submit" class="btn btn-primary me-2" id="btnRegistroPredio"><i
                                   class="ri-add-line me-1"></i>
                               Registrar</button>
                           <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"><i
                                   class="ri-close-line me-1"></i> Cancelar</button>
                       </div>

                   </form>
               </div>
           </div>
       </div>
   </div>
   {{--  modal de edicion equisde --}}
