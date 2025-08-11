@extends('layouts/layoutMaster')

@section('title', $modoLectura ? 'Ver Respuestas' : 'Responder Encuesta')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/spinkit/spinkit.scss',
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
        'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
        'resources/assets/vendor/libs/tagify/tagify.scss',
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
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
        'resources/assets/vendor/libs/typeahead-js/typeahead.js',
        'resources/assets/vendor/libs/tagify/tagify.js',
        'resources/assets/vendor/libs/bloodhound/bloodhound.js'
    ])
@endsection

@section('page-script')
    @vite(['resources/js/responder_encuesta.js',
            'resources/assets/js/forms-selects.js',
            'resources/assets/js/forms-tagify.js',
            'resources/assets/js/forms-typeahead.js'])
@endsection

@section('content')
<div class="container-fluid mt--7">
    <div class="card shadow">
        <div class="card-body">
            <form id="formResponderEncuesta" method="POST" action="{{ route('respuestas.store') }}">
                @csrf
                <input type="hidden" name="id_encuesta" value="{{ $encuesta->id_encuesta }}">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label>Título de la Encuesta</label>
                        <h3>{{ $encuesta->encuesta ?? '' }}</h3>
                    </div>
                    
                    <div class="col-md-6">
                        
                        @if ($modoLectura)
                            <label>
                                @if($encuesta->tipo === 1)
                                    Empleado evaluado
                                @elseif ($encuesta->tipo === 2)
                                    Cliente evaluado
                                @else
                                    Proveedor evaluado
                                @endif
                            </label>
                            <p><strong>{{ $evaluadoNombre ?? 'N/A' }}</strong></p>
                        @else
                            <label>
                                @if($encuesta->tipo === 1)
                                    Empleado a evaluar
                                @elseif ($encuesta->tipo === 2)
                                    Cliente a evaluar
                                @else
                                    Proveedor a evaluar
                                @endif
                            </label>
                            <select id="a_Evaluar" name="aEvaluar" required class="select2 form-select form-select-lg">
                                <option value="">Seleccione</option>
                                @foreach($evaluados as $evaluado)
                                    <option value="{{ $encuesta->tipo == 3 ? $evaluado->id_proveedor : $evaluado->id }}">
                                        {{ $encuesta->tipo == 3 ? $evaluado->razon_social : $evaluado->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="mt-4">
                    @foreach($encuesta->preguntas as $pregunta)
                        <div class="pregunta-item mb-4 m-4" data-tipo="{{ $pregunta->tipo_pregunta }}">
                            <h4>{{ $pregunta->pregunta }}</h4>

                            @if($pregunta->tipo_pregunta == 1)
                                <textarea 
                                    name="respuestas[{{ $pregunta->id_pregunta }}]" 
                                    class="form-control" 
                                    rows="3"
                                    {{ $modoLectura ? 'disabled' : '' }}
                                >{{ $respuestasUsuario[$pregunta->id_pregunta] ?? '' }}</textarea>
                            @elseif($pregunta->tipo_pregunta == 2)
                                @foreach($pregunta->opciones as $opcion)
                                    <div class="m-4">
                                        <input type="radio"
                                            class="form-check-input"
                                            name="respuestas[{{ $pregunta->id_pregunta }}]" 
                                            value="{{ $opcion->id_opcion }}" 
                                            {{ $modoLectura ? 'disabled' : '' }}
                                            {{ isset($respuestasUsuario[$pregunta->id_pregunta]) && $respuestasUsuario[$pregunta->id_pregunta] == $opcion->id_opcion ? 'checked' : '' }}
                                        >
                                        {{ $opcion->opcion }}
                                    </div>
                                @endforeach
                            @elseif($pregunta->tipo_pregunta == 3)
                                @foreach($pregunta->opciones as $opcion)
                                    <div class="m-4">
                                        <input type="checkbox" 
                                            class="form-check-input"
                                            name="respuestas[{{ $pregunta->id_pregunta }}][]" 
                                            value="{{ $opcion->id_opcion }}" 
                                            {{ $modoLectura ? 'disabled' : '' }}
                                            {{ isset($respuestasUsuario[$pregunta->id_pregunta]) && in_array($opcion->id_opcion, $respuestasUsuario[$pregunta->id_pregunta]) ? 'checked' : '' }}
                                        >
                                        {{ $opcion->opcion }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>

                <hr>

                <div class="d-flex justify-content-center mt-4">
                    @if ($modoLectura)
                        <a href="{{ route('encuestas.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-fill"></i>
                        Volver</a>
                    @else
                        <a href="{{ route('encuestas.index') }}" class="btn btn-danger m-2">
                            <i class="ri-close-line"></i>
                            Cancelar</a>
                        <button type="submit" class="btn btn-primary m-2">
                            <i class="ri-save-fill"></i>
                        Guardar Respuestas</button>
                    @endif
                </div>

            </form>

        </div>
    </div>
</div>
@endsection