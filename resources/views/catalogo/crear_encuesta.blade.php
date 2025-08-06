@extends('layouts/layoutMaster')

@section('Crear Encuesta', 
    $mode === 'create' ? 'Crear Encuesta' : 
    ($mode === 'edit' ? 'Editar Encuesta' : 'Ver Encuesta')
)

<!-- Vendor Styles -->
@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        //Animacion "loading"
        'resources/assets/vendor/libs/spinkit/spinkit.scss',
          'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  'resources/assets/vendor/libs/typeahead-js/typeahead.scss'
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js',
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
    ])
@endsection

@section('page-script')
@vite(['resources/js/encuestas.js'])

@endsection

@section('content')
<div class="container-fluid mt--7">

    <div class="card shadow">
        <form action="{{ $mode === 'create' ? route('encuestas.store') : route('encuestas.update', $encuesta) }}" 
              method="POST" class="space-y-6">
            @csrf
            @if($mode === 'edit')
                @method('PUT')
            @endif

            <!-- Información Básica -->
            <div class="card-body">
                <div class='card-header border-0 pb-1 m-5'>
                    <div>
                        <h3 class="text-lg font-semibold">Crear encuesta</h3>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col">
                                <label for="title" class="">
                                    Título de la Encuesta
                                </label>
                                <input type="text" 
                                    id="title" 
                                    name="title" 
                                    value="{{ old('title', $encuesta->title) }}"
                                    placeholder="Ingrese el título de la encuesta"
                                    {{ $mode === 'view' ? 'disabled' : '' }}
                                    required
                                    class="form-control h-auto {{ $mode === 'view' ? 'bg-gray-100' : '' }}">
                                @error('title')
                                    <p class="">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="target_type" class="">
                                    Tipo de Evaluación
                                </label>
                                <select id="target_type" 
                                        name="target_type" 
                                        {{ $mode === 'view' ? 'disabled' : '' }}
                                        required
                                        class="selectpicker w-100 {{ $mode === 'view' ? 'bg-gray-100' : '' }}">
                                    <option value="">Seleccione el tipo</option>
                                    <option value="personal" {{ old('target_type', $encuesta->target_type) === 'personal' ? 'selected' : '' }}>
                                        Evaluación de Personal
                                    </option>
                                    <option value="clientes" {{ old('target_type', $encuesta->target_type) === 'clientes' ? 'selected' : '' }}>
                                        Evaluación de Clientes
                                    </option>
                                    <option value="proveedores" {{ old('target_type', $encuesta->target_type) === 'proveedores' ? 'selected' : '' }}>
                                        Evaluación de Proveedores
                                    </option>
                                </select>
                                @error('target_type')
                                    <p class="text-danger text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
            

                    <!-- Preguntas -->
                    <div class="border rounded">
                        <div class="px-6 py-4 border-b flex justify-between items-center">
                            <h4 class="text-lg font-semibold">Preguntas</h4>
                        </div>
                        <div class="p-6">
                            <div id="questions-container" class="">
                                @forelse($encuesta->questions ?? [] as $index => $question)
                                    <div class="question-item border rounded" data-question-index="{{ $index }}">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1 space-y-4">
                                                <div class="d-flex flex-row col-md-12">
                                                    <div class="col-md-6">
                                                        <label class="block text-sm font-medium text-gray-700 question-number">
                                                            Pregunta {{ $index + 1 }}
                                                        </label>
                                                        <textarea name="questions[{{ $index }}][question_text]" 
                                                                rows="2"
                                                                placeholder="Escriba su pregunta aquí"
                                                                {{ $mode === 'view' ? 'disabled' : '' }}
                                                                onchange="updatePreview(this.closest('.question-item'))"
                                                                required
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 {{ $mode === 'view' ? 'bg-gray-100' : '' }}">{{ old("questions.{$index}.question_text", $question->question_text ?? '') }}</textarea>
                                                    </div>
                                                    <div class="col col-md-4">
                                                        <label class="block text-sm font-medium text-gray-700">
                                                            Tipo de Pregunta
                                                        </label>
                                                        <select name="questions[{{ $index }}][question_type]" 
                                                                {{ $mode === 'view' ? 'disabled' : '' }}
                                                                onchange="changeQuestionType(this)"
                                                                required
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 {{ $mode === 'view' ? 'bg-gray-100' : '' }}">
                                                            <option value="open" {{ old("questions.{$index}.question_type", $question->question_type ?? '') === 'open' ? 'selected' : '' }}>
                                                                Pregunta Abierta
                                                            </option>
                                                            <option value="closed" {{ old("questions.{$index}.question_type", $question->question_type ?? '') === 'closed' ? 'selected' : '' }}>
                                                                Pregunta Cerrada (Radio)
                                                            </option>
                                                            <option value="multiple" {{ old("questions.{$index}.question_type", $question->question_type ?? '') === 'multiple' ? 'selected' : '' }}>
                                                                Opción Múltiple (Checkbox)
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Vista previa -->
                                                <div class="preview-container"></div>

                                                <!-- Opciones -->
                                                <div class="options-container" style="{{ in_array(old("questions.{$index}.question_type", $question->question_type ?? ''), ['closed', 'multiple']) ? '' : 'display: none;' }}">
                                                    @if(in_array(old("questions.{$index}.question_type", $question->question_type ?? ''), ['closed', 'multiple']) && $mode !== 'view')
                                                        <div class="col m-2">
                                                            <div class="flex items-center justify-between">
                                                                <label class="">
                                                                    Opciones de Respuesta
                                                                </label>
                                                                <button type="button" 
                                                                        onclick="addOption(this.closest('.question-item'))"
                                                                        class="">
                                                                    Agregar Opción
                                                                </button>
                                                            </div>
                                                            <div class="options-list space-y-2">
                                                                @foreach(old("questions.{$index}.options", $question->options ?? []) as $optionIndex => $option)
                                                                    <div class="flex items-center gap-2 option-item">
                                                                        <input type="text" 
                                                                            name="questions[{{ $index }}][options][]" 
                                                                            value="{{ $option }}"
                                                                            placeholder="Opción {{ $optionIndex + 1 }}"
                                                                            onchange="updatePreview(this.closest('.question-item'))"
                                                                            class="">
                                                                        <button type="button" 
                                                                                onclick="removeOption(this)"
                                                                                class="px-3 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 border border-red-300 rounded-md">
                                                                            ✕
                                                                        </button>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($mode !== 'view')
                                                <button type="button" 
                                                        onclick="removeQuestion(this)"
                                                        class="btn btn-danger">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div id="no-questions-message" class="text-center py-8 text-gray-500">
                                        No hay preguntas agregadas.
                                        @if($mode !== 'view')
                                            Haga clic en "Agregar Pregunta" para comenzar.
                                        @endif
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    @if($mode !== 'view')
                        <div class="col-md-12 d-flex flex-row align-items-center justify-content-center m-2">
                            <button type="button" 
                                onclick="addQuestion()"
                                class="add-new btn btn-label-primary waves-effect waves-light">
                                <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                <span class="d-none d-sm-inline-block">Agregar Pregunta</span>
                            </button>
                        </div>
                    @endif

                    </div>

                    <!-- Botones de acción -->
                    @if($mode !== 'view')
                        <div class="col d-flex justify-content-center align-items-center">
                            <a href="{{ route('encuestas.index') }}" 
                            class="btn btn-danger m-2">
                                <i class="ri-close-line"></i>
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="add-new btn btn-primary waves-effect waves-light m-2">
                                <i class="ri-add-line"></i>
                                {{ $mode === 'create' ? 'Crear Encuesta' : 'Guardar Cambios' }}
                            </button>
                        </div>
                    @else
                        <div class="flex justify-center">
                            <a href="{{ route('encuestas.index') }}" 
                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-2 rounded-md">
                                Regresar
                            </a>
                        </div>
                    @endif
                </form>

                <!-- Template para nuevas preguntas -->
                <template id="question-template">
                    <div class="question-item  border border-primary rounded m-2 position-relative p-5" data-question-index="QUESTION_INDEX">
                    <div class="">
                        <div class="">
                        <div class="d-flex flex-column col-md-12">
                            <div class="d-flex flex-row col-md-8">
                                    <div class="col-md-3">
                                        <h3>
                                        Pregunta QUESTION_INDEX
                                        </h3>
                                    </div>

                                    <div class="col-md-4">
                                        <select name="questions[QUESTION_INDEX][question_type]" 
                                                    onchange="changeQuestionType(this)"
                                                    required
                                                    class="form-select">
                                                <option value="open">Pregunta Abierta</option>
                                                <option value="closed">Pregunta Cerrada (Radio)</option>
                                                <option value="multiple">Opción Múltiple (Checkbox)</option>
                                        </select>
                                    </div>
                                    
                            </div>
                            <div class="col-md-12">
                                    <textarea
                                            name="questions[QUESTION_INDEX][question_text]" 
                                            rows="2"
                                            placeholder="Escriba su pregunta aquí"
                                            onchange="updatePreview(this.closest('.question-item'))"
                                            required
                                            class="form-control h-px-100"></textarea>
                            </div>
                        </div>

                            <div class="preview-container"></div>

                            <div class="options-container" style="display: none;">
                                <div class="d-flex flex-column m-5 col-md-12">
                                    <div class="row">
                                        <h5 class="">
                                            Opciones de Respuesta
                                        </h5>

                                    </div>

                                    <div class="options-list d-flex flex-column col-md-12"></div>

                                    <div class="col-md-12 d-flex flex-row align-items-center justify-content-center">
                                        <button type="button" 
                                            onclick="addOption(this.closest('.question-item'))"
                                            class="add-new btn btn-outline-primary waves-effect waves-light">
                                            <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                            Agregar Opción
                                        </button>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                      <button type="button" 
                            onclick="removeQuestion(this)"
                            class="btn rounded-pill btn-icon btn-danger position-absolute top-0 end-0 m-2">
                        <i class="ri-close-line"></i>
                    </button> 
                </div>
                </template>
            </div>
    </div>
</div>

<script>
    // Inicializar contador con el número de preguntas existentes
    questionCounter = {{ count($survey->questions ?? []) }};
</script>
@endsection
