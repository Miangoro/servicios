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
                                        <strong>Descripción de la Muestra:</strong> {{ $servicio->descripcion_muestra }}
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
                                @if($servicio->id_acreditacion)
                                    <li class="list-group-item">
                                        <strong>Nombre de Acreditación:</strong> {{ $servicio->nombre_acreditacion }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Descripción de Acreditación:</strong> {{ $servicio->descripcion_acreditacion }}
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <strong>Análisis:</strong> {{ $servicio->analisis }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Unidades:</strong> {{ $servicio->unidades }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Método:</strong> {{ $servicio->metodo }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Prueba:</strong> {{ $servicio->prueba }}
                                </li>
                            </ul>
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