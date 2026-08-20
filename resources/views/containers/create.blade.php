@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Nuevo Contenedor</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('containers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Cliente Propietario</label>
                        <select name="client_id" class="form-select" required>
                            <option value="">-- Seleccione un Cliente --</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->document }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código del Contenedor</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="Ej: EXFU3902145" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Contenedor</label>
                        <select name="type" class="form-select" required>
                            <option value="Seco" {{ old('type') == 'Seco' ? 'selected' : '' }}>Seco</option>
                            <option value="Isotanque" {{ old('type') == 'Isotanque' ? 'selected' : '' }}>Isotanque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacidad (m³ / Litros)</label>
                        <input type="number" step="0.01" name="capacity" class="form-control" value="{{ old('capacity') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado Inicial (Por defecto: Almacenado)</label>
                        <select name="status" class="form-select">
                            <option value="Almacenado" {{ old('status', 'Almacenado') == 'Almacenado' ? 'selected' : '' }}>Almacenado</option>
                            <option value="En reparación" {{ old('status') == 'En reparación' ? 'selected' : '' }}>En reparación</option>
                            <option value="En lavado" {{ old('status') == 'En lavado' ? 'selected' : '' }}>En lavado (Solo Isotanque)</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('containers.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar Contenedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection