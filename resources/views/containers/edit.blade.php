@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar Contenedor</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('containers.update', $container) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Cliente Propietario</label>
                        <select name="client_id" class="form-select" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $container->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->document }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código del Contenedor</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $container->code) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Contenedor</label>
                        <select name="type" class="form-select" required>
                            <option value="Seco" {{ old('type', $container->type) == 'Seco' ? 'selected' : '' }}>Seco</option>
                            <option value="Isotanque" {{ old('type', $container->type) == 'Isotanque' ? 'selected' : '' }}>Isotanque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacidad</label>
                        <input type="number" step="0.01" name="capacity" class="form-control" value="{{ old('capacity', $container->capacity) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select" required>
                            <option value="Almacenado" {{ old('status', $container->status) == 'Almacenado' ? 'selected' : '' }}>Almacenado</option>
                            <option value="En reparación" {{ old('status', $container->status) == 'En reparación' ? 'selected' : '' }}>En reparación</option>
                            <option value="En lavado" {{ old('status', $container->status) == 'En lavado' ? 'selected' : '' }}>En lavado (Solo Isotanque)</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('containers.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Contenedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection