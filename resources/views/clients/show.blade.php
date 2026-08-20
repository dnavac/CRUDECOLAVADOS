@extends('layouts.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Detalle del Cliente: {{ $client->name }}</h4>
        <a href="{{ route('clients.index') }}" class="btn btn-sm btn-light">Volver</a>
    </div>
    <div class="card-body">
        <p><strong>Documento:</strong> {{ $client->document }}</p>
        <p><strong>Teléfono:</strong> {{ $client->phone }}</p>
        <p><strong>Correo:</strong> {{ $client->email }}</p>
        <p><strong>Dirección:</strong> {{ $client->address }}</p>
        <p class="mb-0"><strong>Total de Contenedores Asociados:</strong> <span class="badge bg-primary fs-6">{{ $client->containers->count() }}</span></p>
    </div>
</div>

<h4>Contenedores de este Cliente</h4>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($client->containers as $container)
                    <tr>
                        <td>{{ $container->code }}</td>
                        <td>{{ $container->type }}</td>
                        <td>{{ $container->capacity }}</td>
                        <td><span class="badge bg-secondary">{{ $container->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3">Este cliente aún no tiene contenedores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection