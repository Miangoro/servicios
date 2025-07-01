@extends('layouts/layoutMaster')

@section('title', 'Docusign')


<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/js/forms-selects.js'])
@endsection


@section('content')

    <div class="row">
        <!-- Form controls -->
        <div class="col-md-12">
            <div class="card mb-6">
                <h5 class="card-header">Firmar certificados con docusign</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <form id="formulario" action="{{ route('docusign.enviar') }}" method="POST">
                        @csrf
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="email" class="form-control" id="exampleFormControlInput1"
                                placeholder="name@example.com" name="email" />
                            <label for="exampleFormControlInput1">Correo de docusign</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="text" class="form-control" id="nombre"
                                placeholder="Introduce tu nombre completo" name="name" />
                            <label for="nombre">Nombre completo</label>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select multiple class="form-select select2" name="id_certificado[]"
                                    data-placeholder="Seleccione los certificados">
                                    <option value="" disabled>Seleccionar</option>
                                    @foreach ($certificados as $certificado)
                                        <option value="{{ $certificado->id_certificado }}">
                                            {{ $certificado->num_certificado }} | </option>
                                    @endforeach
                                </select>
                                <label for="">Certificados para firmar</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">Firmar</button>
                        <a href="/certificados/exportacion" class="btn btn-outline-danger waves-effect">Cancelar</a>
                    </div>
                </form>

                </div>

                
            </div>
        </div>




    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Selecciona una opción",
                allowClear: true,
                width: '100%' // Asegura que se ajuste al contenedor
            });
        });
    </script>
@endsection
