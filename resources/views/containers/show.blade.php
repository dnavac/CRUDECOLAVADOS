@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Detalle del Contenedor: {{ $container->code }}</h4>
        <a href="{{ route('containers.index') }}" class="btn btn-sm btn-light">Volver</a>
    </div>
    <div class="card-body">
        <p><strong>Código:</strong> {{ $container->code }}</p>
        <p><strong>Tipo:</strong> {{ $container->type }}</p>
        <p><strong>Capacidad:</strong> {{ $container->capacity }}</p>
        <p><strong>Estado Actual:</strong> <span class="badge bg-primary">{{ $container->status }}</span></p>
        <hr>
        <h5>Cliente Asociado</h5>
        <p><strong>Nombre:</strong> {{ $container->client->name }}</p>
        <p><strong>Documento:</strong> {{ $container->client->document }}</p>
        <p><strong>Teléfono:</strong> {{ $container->client->phone }}</p>
    </div>
</div>
@endsection