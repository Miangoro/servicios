@extends('layouts/layoutMaster')

@section('title', "Responder Encuesta")

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
    @vite(['resources/js/encuestas.js',
    'resources/assets/js/forms-selects.js',
  'resources/assets/js/forms-tagify.js',
  'resources/assets/js/forms-typeahead.js'])
    
@endsection

@section('content')
<div class="container-fluid mt--7">
    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('respuestas.store') }}">
                @csrf
            <div class="row">
                <div class="col">
                    <label for="title" class="">
                        Título de la Encuesta
                    </label>
                    <h3 id="titulo_encuesta" name="tituloEncuesta">{{ old('title', $encuesta->encuesta ?? '') }}</h3>
                </div>
                
                <div class="col">
                    <label for="aEvaluar" class="">
                        @if($encuesta->tipo === 1)
                            Empleado a evaluar
                        @elseif ($encuesta->tipo === 1)
                            Cliente a evaluar
                        @else
                            Proveedor a evaluar
                        @endif
                    </label>
                    <select id="a_Evaluar" name="aEvaluar" required class="select2 form-select form-select-lg"
                        data-allow-clear="true">
                        <option value="">Seleccione a quien evaluar</option>
                        @foreach($evaluados as $evaluado)
                            <option value="{{ $evaluado->id }}">
                                {{ $encuesta->tipo == 3 ? $evaluado->nombre_fiscal : $evaluado->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('aEvaluar')
                        <p class="text-danger text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="id_encuesta" value="{{ $encuesta->id_encuesta }}">

                <div class="mt-4">
                    @foreach ($encuesta->preguntas as $index => $pregunta)
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                {{ $index + 1 }}. {{ $pregunta->pregunta }}
                            </label>

                            @if ($pregunta->tipo_pregunta == 1)
                                {{-- Pregunta abierta: Textarea --}}
                                <textarea name="respuestas[{{ $pregunta->id_pregunta }}]"
                                        class="form-control" rows="3"
                                        placeholder="Escriba su respuesta aquí..."></textarea>

                            @elseif ($pregunta->tipo_pregunta == 2)
                                {{-- Pregunta de opción única: Radio buttons --}}
                                @foreach ($pregunta->opciones as $opcion)
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="respuestas[{{ $pregunta->id_pregunta }}]"
                                            id="radio_{{ $opcion->id_opcion }}"
                                            value="{{ $opcion->opcion }}">
                                        <label class="form-check-label" for="radio_{{ $opcion->id_opcion }}">
                                            {{ $opcion->opcion }}
                                        </label>
                                    </div>
                                @endforeach

                            @elseif ($pregunta->tipo_pregunta == 3)
                                {{-- Pregunta de opción múltiple: Checkboxes --}}
                                @foreach ($pregunta->opciones as $opcion)
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="respuestas[{{ $pregunta->id_pregunta }}][]"
                                            id="check_{{ $opcion->id_opcion }}"
                                            value="{{ $opcion->opcion }}">
                                        <label class="form-check-label" for="check_{{ $opcion->id_opcion }}">
                                            {{ $opcion->opcion }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="d-flex flex-row align-items-center justify-content-center">
                    <button type="submit" class="btn btn-text-info waves-effect">
                        <i class="ri-save-fill ri-16px me-0 me-sm-2 align-baseline"></i>
                        Guardar Respuestas
                    </button>
                </div>
            </form>
    </div>
</div>
@endsection