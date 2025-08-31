@extends('layouts/layoutMaster')

@section('title', 'Editar Servicio')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/select2/select2.scss')
    @vite('resources/assets/vendor/libs/form-validation/form-validation.scss')
    @vite('resources/assets/vendor/libs/animate-css/animate.scss')
    @vite('resources/assets/vendor/libs/sweetalert2/sweetalert2.scss')
    @vite('resources/assets/vendor/libs/spinkit/spinkit.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/select2/select2.js')
    @vite('resources/assets/vendor/libs/form-validation/form-validation.js')
    @vite('resources/assets/vendor/libs/form-validation/auto-focus.js')
    @vite('resources/assets/vendor/libs/sweetalert2/sweetalert2.js')
@endsection

@section('page-script')
    @vite('resources/js/servicios_create.js')
    @vite('resources/assets/js/forms-selects.js')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title">Editar Servicio</h3>
                </div>
                <div class="card-body">
                    <form id="formEditorServicio" class="row g-5" action="{{ route('servicios.update', $servicio) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Fila 1: Clave, Clave Adicional, Nombre del Servicio, Precio --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="clave" value="{{ old('clave', $servicio->clave ?? '') }}">
                                <label>Clave</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="clave_adicional" value="{{ old('clave_adicional', $servicio->clave_adicional ?? '') }}">
                                <label>Clave adicional</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $servicio->nombre ?? '') }}">
                                <label>Nombre del servicio</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="precio" value="{{ old('precio', $servicio->precio ?? '') }}">
                                <label>Precio</label>
                            </div>
                        </div>

                        {{-- Fila 2: Duración, ¿Se requiere muestra?, Acreditación, Estatus --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="duracion" value="{{ old('duracion', $servicio->duracion ?? '') }}">
                                <label>Duración</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" name="requiere_muestra">
                                    <option value="si" {{ old('requiere_muestra', $servicio->requiere_muestra) == 'si' ? 'selected' : '' }}>Sí</option>
                                    <option value="no" {{ old('requiere_muestra', $servicio->requiere_muestra) == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                                <label>¿Se requiere muestra?</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" name="id_acreditacion">
                                    <option value="1" {{ old('id_acreditacion', $servicio->id_acreditacion) == 1 ? 'selected' : '' }}>Acreditado</option>
                                    <option value="0" {{ old('id_acreditacion', $servicio->id_acreditacion) == 0 ? 'selected' : '' }}>No Acreditado</option>
                                </select>
                                <label>Acreditación</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" name="id_habilitado">
                                    <option value="1" {{ old('id_habilitado', $servicio->id_habilitado) == 1 ? 'selected' : '' }}>Habilitado</option>
                                    <option value="2" {{ old('id_habilitado', $servicio->id_habilitado) == 2 ? 'selected' : '' }}>No Habilitado</option>
                                    <option value="3" {{ old('id_habilitado', $servicio->id_habilitado) == 3 ? 'selected' : '' }}>Observado</option>
                                </select>
                                <label>Estatus</label>
                            </div>
                        </div>

                        {{-- Fila 3: Análisis --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="analisis" value="{{ old('analisis', $servicio->analisis ?? '') }}">
                                <label>Análisis</label>
                            </div>
                        </div>

                        {{-- Fila 4: Unidades --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="unidades" value="{{ old('unidades', $servicio->unidades ?? '') }}">
                                <label>Unidades</label>
                            </div>
                        </div>

                        {{-- Fila 5 y 6: Acreditación (oculto si no es acreditado) --}}
                        @if ($servicio->id_acreditacion == 1)
                            <div class="col-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="nombre_acreditacion" value="{{ old('nombre_acreditacion', $servicio->nombre_acreditacion ?? '') }}">
                                    <label>Nombre de la Acreditación</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="form-control h-px-100" name="descripcion_acreditacion">{{ old('descripcion_acreditacion', $servicio->descripcion_acreditacion ?? '') }}</textarea>
                                    <label>Descripción de la Acreditación</label>
                                </div>
                            </div>
                        @endif

                        {{-- Fila 7: Prueba --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control h-px-100" name="prueba">{{ old('prueba', $servicio->prueba ?? '') }}</textarea>
                                <label>Prueba</label>
                            </div>
                        </div>

                        {{-- Fila 8: Descripción de Muestra (oculto si no se requiere) --}}
                        @if ($servicio->requiere_muestra == 'si')
                            <div class="col-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="form-control h-px-100" name="descripcion_muestra">{{ old('descripcion_muestra', $servicio->descripcion_muestra ?? '') }}</textarea>
                                    <label>Descripción de Muestra</label>
                                </div>
                            </div>
                        @endif
                        
                        {{-- Laboratorios y Precios (requiere lógica de js) --}}
                        <div class="col-12 mt-5">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white rounded-top-4 py-3">
                                    <h5 class="fw-bold text-dark mb-0">Laboratorios y Precios</h5>
                                </div>
                                <div class="card-body bg-white py-3">
                                    @foreach ($servicio->laboratorios as $laboratorio)
                                        <div class="input-group mb-3 laboratorio-item">
                                            <div class="form-floating form-floating-outline flex-grow-1">
                                                <input type="text" class="form-control" name="precios_laboratorio[]" value="{{ old('precios_laboratorio.'.$loop->index, $laboratorio->pivot->precio) }}">
                                                <label>Precio</label>
                                            </div>
                                            <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                                                <input type="text" class="form-control" value="{{ $laboratorio->laboratorio }} (Clave: {{ $laboratorio->clave }})" readonly>
                                                <input type="hidden" name="laboratorios_responsables[]" value="{{ $laboratorio->id_laboratorio }}">
                                                <label>Laboratorio responsable</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-go-back-line"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formEditorServicio');
    if (form) {
        form.addEventListener('submit', async function(event) {
            event.preventDefault(); // Detiene el envío del formulario por defecto

            Swal.fire({
                title: 'Guardando...',
                didOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false
            });

            // Recolectar datos del formulario
            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                // Manejar arrays como precios_laboratorio[]
                if (key.endsWith('[]')) {
                    const cleanKey = key.slice(0, -2);
                    if (!data[cleanKey]) {
                        data[cleanKey] = [];
                    }
                    data[cleanKey].push(value);
                } else {
                    data[key] = value;
                }
            });

            // Agregar el token CSRF y el método PUT explícitamente al objeto de datos
            data['_token'] = formData.get('_token');
            data['_method'] = 'PUT';

            try {
                // Usar this.action para obtener la URL del formulario, que ya contiene el ID del servicio
                const response = await fetch(this.action, { 
                    method: 'POST', // Usar POST para enviar _method=PUT
                    body: JSON.stringify(data),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: result.message || 'El servicio se ha actualizado correctamente.',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                } else {
                    let errorMessage = 'Error al actualizar el servicio.';
                    if (result && result.message) {
                        errorMessage = result.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor. Por favor, intente de nuevo.',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }
        });
    }
});
</script>