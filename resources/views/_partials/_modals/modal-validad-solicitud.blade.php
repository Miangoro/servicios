<div class="modal fade" id="addSolicitudValidar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Validación de la solicitud de servicio</h4>
                    <p id="tipoSolicitud" class="solicitud badge bg-primary fs-4"></p>
                    <div class="datos-importantes">
                      {{-- <div class="id_empresa"></div> --}}
                    </div>
                </div>
                <form id="addValidarSolicitud">
                    <input type="hidden" name="solicitud_id" id="solicitud_id">
                    <div>
                        <div id="muestreoAgave" class="d-none terminado">
                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td class="marcar">
                                                <select name="razonSocial" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
{{--                                         <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio Fiscal:</th>
                                            <td class="domicilioFiscal"></td>
                                            <td>
                                                <select name="domicilioFiscal" class="form-control form-control-sm"
                                                    id="cumpleDomicilioFiscalEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalacion" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha
                                                y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Guías de traslado de agave:</th>
                                            <td class="guiasTraslado"></td>
                                            <td>
                                                <select name="guiasTraslado" class="form-control form-control-sm" id="cumple">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="vigilanciaProduccion" class="d-none terminado">
                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" name="razonSocial" class="form-control form-control-sm"
                                                    id="cumpleRazonSocialEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
{{--                                         <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio Fiscal:</th>
                                            <td class="domicilioFiscal"></td>
                                            <td>
                                                <select name="domicilioFiscal" class="form-control form-control-sm"
                                                    id="cumpleDomicilioFiscalEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalacion" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Guías de traslado de agave:</th>
                                            <td class="guiasTraslado"></td>
                                            <td>
                                                <select name="guiasTraslado" class="form-control form-control-sm" id="cumple">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="dictamenInstalaciones" class="d-none terminado">
                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td class="marcar">
                                                <select name="razonSocial" class="form-control form-control-sm"
                                                    id="cumpleRazonSocialEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
{{--                                         <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio Fiscal:</th>
                                            <td class="domicilioFiscal"></td>
                                            <td class="marcar">
                                                <select name="domicilioFiscal" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción o Envasadora
                                                Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td class="marcar">
                                                <select name="domicilioInstalacion" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td class="marcar">
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Acta
                                                Constitutiva:</th>
                                            <td class="actaConstitutiva"></td>
                                            <td class="marcar">
                                                <select name="actaConstitutiva" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
{{--                                         <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                CSF:
                                            </th>
                                            <td class="csf"></td>
                                            <td class="marcar">
                                                <select name="csf" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Comprobante de Posesión:</th>
                                            <td class="comprobantePosesion"></td>
                                            <td class="marcar">
                                                <select name="comprobantePosesion" class="form-control form-control-sm"
                                                    id="cumpleComprobantePosesionDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Plano
                                                de Distribución:</th>
                                            <td class="planoDistribucion"></td>
                                            <td class="marcar">
                                                <select name="planoDistribucion" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="muestreoLoteAjustes" class="d-none terminado">
                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td class="marcar">
                                                <select name="razonSocial" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
{{--                                         <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio Fiscal:</th>
                                            <td class="domicilioFiscal"></td>
                                            <td>
                                                <select name="domicilioFiscal" class="form-control form-control-sm"
                                                    id="cumpleDomicilioFiscalEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción o Envasadora
                                                Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalacion" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote:</th>
                                            <td class="nombreLote"></td>
                                            <td>
                                                <select name="nombreLote" class="form-control form-control-sm"
                                                    id="cumpleNombreLoteRemuestreo">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Tipo de
                                                Análisis:</th>
                                            <td class="tipoAnalisis"></td>
                                            <td>
                                                <select name="tipoAnalisis" class="form-control form-control-sm"
                                                    id="cumpleTipoAnalisisRemuestreo">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Acta de
                                                Vigilancia de producción:</th>
                                            <td class="acta"></td>
                                            <td>
                                                <select name="actaVigilanciaRemuestreo" class="form-control form-control-sm"
                                                    id="cumpleActaVigilanciaRemuestreo">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div id="vigilanciaTraslado" class="d-none terminado">
                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" class="form-control form-control-sm"
                                                    id="cumpleRazonSocialEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción o Envasadora
                                                Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote:</th>
                                            <td class="nombreLote"></td>
                                            <td>
                                                <select name="nombreLote" class="form-control form-control-sm"
                                                    id="cumpleNombreLoteTraslado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                            </th>
                                            <td class="fq"></td>
                                            <td>
                                                <select name="fq" class="form-control form-control-sm" id="cumpleFqTraslado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Certificado a Granel:</th>
                                            <td class="certificadoGranel"></td>
                                            <td>
                                                <select name="certificadoGranel" class="form-control form-control-sm"
                                                    id="cumpleCertificadoGranelTraslado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Volumen
                                                del Lote Actual:</th>
                                            <td class="volumenActual"></td>
                                            <td>
                                                <select name="volumenActual" class="form-control form-control-sm"
                                                    id="cumpleVolumenLoteActualTraslado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Volumen
                                                Trasladado:</th>
                                            <td class="volumenTrasladado"></td>
                                            <td>
                                                <select name="cumpleVolumenTraslado" class="form-control form-control-sm"
                                                    id="cumpleVolumenTrasladado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Volumen
                                                Sobrante:</th>
                                            <td class="volumenSobrante"></td>
                                            <td>
                                                <select name="volumenSobrante" class="form-control form-control-sm"
                                                    id="cumpleVolumenSobrante">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="inspeccionEnvasado" class="d-none terminado">
                            <div class="datos-importantes">
                                <table style="font-size: 11px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" class="form-control form-control-sm"
                                                    id="cumpleRazonSocialEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción o Envasadora
                                                Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalacion" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote a Granel:</th>
                                            <td class="nombreLote"></td>
                                            <td><select name="nombreLote" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote Envasado:</th>
                                            <td class="nombreLoteEnvasado"></td>
                                            <td><select name="nombreLoteEnvasado" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Cajas/Botellas:</th>
                                            <td class="cajasBotellas"></td>
                                            <td><select name="cajasBotellas" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
{{--                                         <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Contenido Alcohólico:</th>
                                            <td class="cont_alc"></td>
                                            <td><select name="cont_alc" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                            </th>
                                            <td class="fq"></td>
                                            <td>
                                                <select name="fq" class="form-control form-control-sm" id="cumpleFqEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Certificado a Granel:</th>
                                            <td class="certificadoGranel"></td>
                                            <td>
                                                <select name="certificadoGranel" class="form-control form-control-sm"
                                                    id="cumpleCertificadoGranelEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Tipo (Sin/Con Etiqueta):</th>
                                            <td class="tipoEtiquetaEnvasado"></td>
                                            <td>
                                                <select name="tipoEtiquetaEnvasado" class="form-control form-control-sm"
                                                    id="cumpleTipoEtiquetaEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Inicio
                                                y Término de Envasado:</th>
                                            <td class="inicioTerminoEnvasado"></td>
                                            <td>
                                                <select name="inicioTerminoEnvasado" class="form-control form-control-sm"
                                                    id="cumpleInicioTerminoEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Destino
                                                (Nacional/Internacional):</th>
                                            <td class="destinoEnvasado"></td>
                                            <td>
                                                <select name="destinoEnvasado" class="form-control form-control-sm"
                                                    id="cumpleDestinoEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="inspeccionIngresoBarrica" class="d-none terminado">
                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" class="form-control form-control-sm"
                                                    id="cumpleRazonSocialEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
{{--                                         <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio Fiscal:</th>
                                            <td class="domicilioFiscal"></td>
                                            <td>
                                                <select name="domicilioFiscal" class="form-control form-control-sm"
                                                    id="cumpleDomicilioFiscalEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción o Envasadora
                                                Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalaciones" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote a Granel:</th>
                                            <td class="nombreLote"></td>
                                            <td><select name="nombreLote" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                       {{--  <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Categoría:</th>
                                            <td class="categoria"></td>
                                            <td><select name="categoria" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Clase:</th>
                                            <td class="clase"></td>
                                            <td><select name="clase" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Especie de Agave:</th>
                                            <td class="tipos"></td>
                                            <td><select name="tipos" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Contenido Alcohólico:</th>
                                            <td class="cont_alc"></td>
                                            <td><select name="cont_alc" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                            </th>
                                            <td class="fq"></td>
                                            <td>
                                                <select name="fq" class="form-control form-control-sm" id="cumpleFqEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Certificado a Granel:</th>
                                            <td class="certificadoGranel"></td>
                                            <td>
                                                <select name="certificadoGranel" class="form-control form-control-sm"
                                                    id="cumpleCertificadoGranelEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">MATERIAL DEL
                                                RECIPIENTE:</td>
                                            <td class="materialRecipiente"></td>
                                            <td>
                                                <select name="materialRecipiente" class="form-control form-control-sm" id="cumpleRecipiente"
                                                    style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">CAPACIDAD DEL
                                                RECIPIENTE:
                                            </td>
                                            <td class="capacidadRecipiente"></td>
                                            <td>
                                                <select name="capacidadRecipiente" class="form-control form-control-sm"
                                                    id="cumpleCapacidadRecipientes" style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">NÚMERO DE
                                                RECIPIENTES:</td>
                                            <td class="numeroRecipiente"></td>
                                            <td>
                                                <select name="numeroRecipiente" class="form-control form-control-sm"
                                                    id="cumpleNumeroRecipientes" style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">VOLUMEN INGRESADO:
                                            </td>
                                            <td class="volumenIngresado"></td>
                                            <td>
                                                <select name="volumenIngresado" class="form-control form-control-sm"
                                                    id="cumpleVolumenIngresado" style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">TIEMPO DE MADURACIÓN:</td>
                                        <td class="tiempoMaduracion"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleTiempoMaduracion"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>-->
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">TIPO DE INGRESO
                                                (BARRICA O VIDRIO):</td>
                                            <td class="tipoIngreso"></td>
                                            <td>
                                                <select name="tipoIngreso" class="form-control form-control-sm" id="cumpleTipoRecipiente"
                                                    style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="liberacionBarricaVidrio" class="d-none terminado">
                            <h4 class="address-title mb-2">Liberación de Barrica/Contenedor de Vidrio</h4>
                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" class="form-control form-control-sm"
                                                    id="cumpleRazonSocialEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción o Envasadora
                                                Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalacion" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote a Granel:</th>
                                            <td class="nombreLote"></td>
                                            <td><select name="nombreLote" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>

                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                            </th>
                                            <td class="fq"></td>
                                            <td>
                                                <select name="fq" class="form-control form-control-sm" id="cumpleFqEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Certificado a Granel:</th>
                                            <td class="certificadoGranel"></td>
                                            <td>
                                                <select name="certificadoGranel" class="form-control form-control-sm"
                                                    id="cumpleCertificadoGranelEnvasado">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">MATERIAL DEL
                                                RECIPIENTE:</td>
                                            <td class="materialRecipiente"></td>
                                            <td>
                                                <select name="materialRecipiente" class="form-control form-control-sm" id="cumpleRecipiente"
                                                    style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">CAPACIDAD DEL
                                                RECIPIENTE:
                                            </td>
                                            <td class="capacidadRecipiente"></td>
                                            <td>
                                                <select name="capacidadRecipiente" class="form-control form-control-sm"
                                                    id="cumpleCapacidadRecipientes" style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">NÚMERO DE
                                                RECIPIENTES:</td>
                                            <td class="numeroRecipiente"></td>
                                            <td>
                                                <select name="numeroRecipiente" class="form-control form-control-sm"
                                                    id="cumpleNumeroRecipientes" style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">VOLUMEN LIBERADO:
                                            </td>
                                            <td class="volumenLiberado"></td>
                                            <td>
                                                <select name="volumenLiberado" class="form-control form-control-sm"
                                                    id="cumpleVolumenIngresado" style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">TIEMPO DE
                                                MADURACIÓN:</td>
                                            <td class="tiempoMaduracion"></td>
                                            <td>
                                                <select name="tiempoMaduracion" class="form-control form-control-sm"
                                                    id="cumpleTiempoMaduracion" style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark fw-bold" style="font-size: 11px;">TIPO DE LIBERACIÓN
                                                (BARRICA O VIDRIO):</td>
                                            <td class="tipoLiberacion"></td>
                                            <td>
                                                <select name="tipoLiberacion" class="form-control form-control-sm" id="cumpleTipoRecipiente"
                                                    style="font-size: 11px;">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="liberacionPTNacional" class="d-none terminado">
                            <h4 class="address-title mb-2">Liberación de PT Nacional</h4>
                            <div class="datos-importantes">
                                <table style="font-size: 11px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Domicilio de Instalaciones
                                                (Unidad de Producción o Envasadora Autorizada):</th>
                                            <td id="domicilioInstalacion" class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalacion" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Fecha y Hora de Visita:</th>
                                            <td id="fechaHora" class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Nombre del Lote a Granel:
                                            </th>
                                            <td id="nombreLote" class="nombreLote"></td>
                                            <td>
                                                <select name="nombreLote" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Nombre del Lote Envasado:
                                            </th>
                                            <td class="nombreLoteEnvasado"></td>
                                            <td>
                                                <select name="nombreLoteEnvasado" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Cajas/Botellas:</th>
                                            <td class="cajasBotellasTN"></td>
                                            <td>
                                                <select name="cajasBotellas" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <th class="text-dark fw-bold" scope="row">Categoría:</th>
                                            <td class="categoria"></td>
                                            <td>
                                                <select name="categoria" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Clase:</th>
                                            <td class="clase"></td>
                                            <td>
                                                <select name="clase" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Especie de Agave:</th>
                                            <td class="tipos"></td>
                                            <td>
                                                <select name="tipos" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Contenido Alcohólico:</th>
                                            <td class="cont_alc"></td>
                                            <td>
                                                <select name="cont_alc" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">FQ:</th>
                                            <td class="fq"></td>
                                            <td>
                                                <select name="fq" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Certificado a Granel:</th>
                                            <td class="certificadoGranel"></td>
                                            <td>
                                                <select name="certificadoGranel" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Rango de Hologramas (acta de envasado):</th>
                                            <td id="rangoHologramas"></td>
                                            <td>
                                                <select name="rangoHologramas" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" scope="row">Dictamen de Envasado:</th>
                                            <td id="dictamenEnvasado" class="dictamenEnvasado"></td>
                                            <td>
                                                <select name="dictamenEnvasado" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="liberacionPTExportacion" class="d-none terminado">

                            <div class="datos-importantes">
                                <table style="font-size: 11px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Si">Sí</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote a Granel:</th>
                                            <td class="nombreLote"></td>
                                            <td><select name="nombreLote" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre
                                                del Lote Envasado:</th>
                                            <td class="nombreLoteEnvasado"></td>
                                            <td><select name="nombreLoteEnvasado" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Solicitud:</th>
                                            <td class="solicitudPdf"></td>
                                            <td><select name="solicitudPdf" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <!--<tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Cajas/Botellas:</th>
                                            <td class="cajasBotellas"></td>
                                            <td><select name="cajasBotellas" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Categoría:</th>
                                            <td class="categoria"></td>
                                            <td><select name="categoria" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Clase:</th>
                                            <td class="clase"></td>
                                            <td><select name="clase" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Especie de Agave:</th>
                                            <td class="tipos"></td>
                                            <td><select name="tipos" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Contenido Alcohólico:</th>
                                            <td class="cont_alc"></td>
                                            <td><select name="cont_alc" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>-->
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                FQ:
                                            </th>
                                            <td class="fq"></td>
                                            <td><select name="fq" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Certificado a Granel:</th>
                                            <td class="certificadoGranel"></td>
                                            <td><select name="certificadoGranel" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Dictamen de Envasado:</th>
                                            <td class="dictamenEnvasado"></td>
                                            <td><select name="dictamenEnvasado" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio de Instalaciones (Unidad de Producción o Envasadora
                                                Autorizada):
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioInstalacion" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Factura Proforma:</th>
                                            <td class="proforma"></td>
                                            <td><select name="proforma" name="proforma" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Etiqueta/Corrugado:</th>
                                            <td class="etiqueta"></td>
                                            <td><select name="etiqueta" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="georreferencia" class="d-none terminado">

                            <div class="datos-importantes">
                                <table style="font-size: 12px;" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                            <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Razón social y domicilio fiscal:</th>
                                            <td class="csf"></td>
                                            <td>
                                                <select name="razonSocial" class="form-control form-control-sm"
                                                    id="cumpleRazonSocialEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Nombre del predio:
                                            </th>
                                            <td class="nombrePredio"></td>
                                            <td>
                                                <select name="nombrePredio" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Domicilio del predio:
                                            </th>
                                            <td class="domicilioInstalacion"></td>
                                            <td>
                                                <select name="domicilioPredio" class="form-control form-control-sm"
                                                    id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Fecha y
                                                Hora de Visita:</th>
                                            <td class="fechaHora"></td>
                                            <td>
                                                <select name="fechaHora" class="form-control form-control-sm"
                                                    id="cumpleFechaHoraVisitaDictamen">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Comprobante de posesión del Predio:</th>
                                            <td class="comprobantePosesion"></td>
                                            <td><select name="comprobantePosesion" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                                Preregistro:</th>
                                            <td class="preregistro"></td>
                                            <td><select name="preregistro" class="form-control form-control-sm">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="si">Sí</option>
                                                    <option value="no">No</option>
                                                </select></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>




                        <!-- <div class="row">
                        <div class="form-floating form-floating-outline mb-5 mt-4">
                            <textarea name="info_adicional" class="form-control h-px-150 info_adicional" id="info"
                                placeholder="Información comentarios u observaciones sobre esta solicitud..."></textarea>
                            <label for="comentarios">Comentarios u observaciones sobre esta solicitud</label>
                        </div>
                    </div>-->
                        <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="submit" class="btn btn-primary"><i class="ri-checkbox-circle-line"></i> Validar</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script></script>
