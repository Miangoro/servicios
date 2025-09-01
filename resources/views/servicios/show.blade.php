@extends('layouts/layoutMaster')

@section('title', 'Detalles del Servicio')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Detalles del Servicio</h3>
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-go-back-line me-1"></i> Volver a la Lista
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Clave:</strong> {{ $servicio->clave }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Nombre del Servicio:</strong> {{ $servicio->nombre }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Precio Principal:</strong> ${{ number_format($servicio->precio, 2) }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Duración:</strong> {{ $servicio->duracion }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Requiere Muestra:</strong> {{ $servicio->id_requiere_muestra ? 'Sí' : 'No' }}
                                </li>
                                @if($servicio->id_requiere_muestra)
                                    <li class="list-group-item">
                                        <strong>Descripción de la Muestra:</strong> 
                                        {{ $servicio->descripcion_Muestra ?: 'No se proporcionó descripción' }}
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <strong>Estatus:</strong> 
                                    @if($servicio->id_habilitado == 1)
                                        <span class="badge bg-success">Habilitado</span>
                                    @else
                                        <span class="badge bg-danger">Deshabilitado</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Acreditación:</strong> 
                                    @if($servicio->id_acreditacion == 1)
                                        <span class="badge bg-info">Acreditado</span>
                                    @else
                                        <span class="badge bg-secondary">No Acreditado</span>
                                    @endif
                                </li>
                                @if($servicio->id_acreditacion == 1)
                                    <li class="list-group-item">
                                        <strong>Nombre de Acreditación:</strong> 
                                        {{ $servicio->nombre_Acreditacion ?: 'No se proporcionó nombre' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Descripción de Acreditación:</strong> 
                                        {{ $servicio->descripcion_Acreditacion ?: 'No se proporcionó descripción' }}
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <strong>Análisis:</strong> {{ $servicio->analisis }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Unidades:</strong> {{ $servicio->unidades }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Prueba:</strong> {{ $servicio->prueba }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Sección para mostrar archivo desde url_requisitos -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Archivo de Requisitos</h4>
                            @if($servicio->url_requisitos)
                                @php
                                    // Parsear la URL para obtener información del archivo
                                    $rutaArchivo = $servicio->url_requisitos;
                                    $urlParts = parse_url($rutaArchivo);
                                    $path = $urlParts['path'] ?? '';
                                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                                    $nombreArchivo = basename($path);
                                    
                                    // Verificar si es una URL válida
                                    $esUrlValida = filter_var($rutaArchivo, FILTER_VALIDATE_URL) !== false;
                                @endphp
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="card-title">{{ $nombreArchivo ?: 'Archivo de requisitos' }}</h5>
                                                <p class="card-text mb-1">
                                                    @if($extension === 'pdf')
                                                        <span class="badge bg-danger me-2">PDF</span>
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <span class="badge bg-primary me-2">Word</span>
                                                    @else
                                                        <span class="badge bg-secondary me-2">{{ $extension ? strtoupper($extension) : 'ARCHIVO' }}</span>
                                                    @endif
                                                    <small class="text-muted">Archivo adjunto</small>
                                                </p>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ $rutaArchivo }}" target="_blank" class="btn btn-info">
                                                    <i class="ri-eye-line me-1"></i> Ver
                                                </a>
                                                <a href="{{ $rutaArchivo }}" download class="btn btn-success">
                                                    <i class="ri-download-line me-1"></i> Descargar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Vista previa para PDF -->
                                @if($extension === 'pdf')
                                <div class="mt-3">
                                    <h5>Vista Previa del PDF</h5>
                                    <div class="border rounded p-2" style="background-color: #f8f9fa;">
                                        <iframe src="{{ $rutaArchivo }}#toolbar=0" width="100%" height="500px" style="border: none;"></iframe>
                                    </div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="ri-information-line me-2"></i> No se ha cargado ningún archivo de requisitos para este servicio.
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            <h4>Precios por Laboratorio</h4>
                            @if($servicio->laboratorios->isNotEmpty())
                                <ul class="list-group">
                                    @foreach($servicio->laboratorios as $laboratorio)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>{{ $laboratorio->laboratorio }}:</strong></span>
                                            <span class="badge bg-primary fs-6">${{ number_format($laboratorio->pivot->precio, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No hay laboratorios asignados a este servicio.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <style>
        .btn-group .btn {
            border-radius: 0.375rem;
        }
        .btn-group .btn:first-child {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .btn-group .btn:last-child {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
@endsection