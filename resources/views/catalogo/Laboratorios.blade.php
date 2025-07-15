@extends('layouts/layoutMaster')

@section('title', 'Laboratorios')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
@vite(['resources/js/tipos.js'])

{{-- Importa el archivo laboratorios.js desde la carpeta public --}}
<script src="{{ asset('js/laboratorios.js') }}"></script>

<script>
    $(document).ready(function() {
        // Inicializa DataTables
        $('#tablaLaboratorios').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('laboratorios.index') }}",
            columns: [
                { data: 'id_laboratorio', name: 'id_laboratorio' },
                { data: 'clave', name: 'clave' },
                { data: 'laboratorio', name: 'laboratorio' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endsection

@section('content')
<style>
    /* Aplica solo a la clase que contiene la tabla */
    .lab_datatable td {
        white-space: nowrap;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h1 class="mb-0"><b>Catálogo de laboratorios</b></h1>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarLab"><i class="fas fa-plus me-2"></i> Nuevo laboratorio </button>
                        </div>
                        <div class="col-6 text-right">
                        </div>
                    </div>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="table-responsive p-3">
                    <table id="tablaLaboratorios" class="table table-flush table-bordered lab_datatable table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-white">No.</th>
                                <th scope="col" class="text-white">Clave</th>
                                <th scope="col" class="text-white">Nombre de laboratorio</th>
                                <th scope="col" class="text-white">Descripción</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="..."></nav>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Incluye los modales al final del content o antes de los scripts de la página --}}
{{-- Esto asegura que el HTML del modal esté cargado antes que los scripts que interactúan con él --}}
@include('_partials/_modals/modal-add-new-laboratorio')
@include('_partials/_modals/modal-edit-laboratorio')

{{-- ELIMINA el @push('js') y su contenido de aquí. Se movió a @section('page-script') --}}
{{-- @push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('resources/js/laboratorios.js') }}"></script>
<script></script>
@endpush --}}

@endsection