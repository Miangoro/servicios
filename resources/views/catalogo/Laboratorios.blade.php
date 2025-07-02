@extends('layouts/layoutMaster')

@section('title', 'Laboratorios')

<!-- Vendor Styles -->
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

<!-- Vendor Scripts -->
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

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/tipos.js'])
@endsection

@section('content')
<style>
  /* Aplica solo a la clase que contiene la tabla */
.lab_datatable td {
    white-space: nowrap;
}

</style>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h1 class="mb-0"><b>Catálogo de laboratorios</b></h1>
                        </div>
                        <div class="col-6 text-right">
                        
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive p-3">
                    <table class="table table-flush table-bordered lab_datatable table-striped table-sm">
                       
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
                            @foreach ($labs as $lab)
                                <tr>
                                    {{ $lab->id_laboratorio }}
                                </tr>
                                <tr>
                                    {{ $lab->clave }}
                                </tr>
                                <tr>
                                    {{ $lab->laboratorio }}
                                </tr>
                                <tr>
                                    {{ $lab->descripcion }}
                                </tr>
                            @endforeach
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


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush

<script>
    $(function() {
        var table = $('.lab_datatable').DataTable({

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
        url: "{{ route('laboratorios.index') }}",
        type: "GET",
        data: function (d) {
        }
        },
            dataType: 'json',
            type: "POST",
            columns: [
                {
                    data: 'id_laboratorio',
                    name: 'id_laboratorio'
                },
                
               
                {
                    data: 'clave',
                    name: 'clave'
                }, 
                
                {
                    data: 'laboratorio',
                    name: 'laboratorio'
                },
                {
                    data: 'descripcion',
                    name: 'descripcion'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]

        });
       
    });
</script>


@endsection
