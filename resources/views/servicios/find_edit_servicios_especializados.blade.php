@extends('layouts/layoutMaster')

@section('title', 'Editar Servicio')

@section('content')
    <div class="card p-4">
        <h2>Editar Servicio: {{ $servicio->nombre }}</h2>
        <form action="{{ route('servicios.update', $servicio->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Usa el método PUT para las actualizaciones en RESTful --}}

            <div class="mb-3">
                <label for="clave" class="form-label">Clave:</label>
                <input type="text" class="form-control" id="clave" name="clave" value="{{ $servicio->clave }}" required>
            </div>
            
            <div class="mb-3">
                <label for="servicios" class="form-label">Servicio:</label>
                <input type="text" class="form-control" id="servicios" name="servicios" value="{{ $servicio->servicios }}" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ $servicio->precio }}" required>
            </div>
            
            {{-- Añade los demás campos del formulario aquí --}}

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection