@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Listado de Contenedores</h2>
    <a href="{{ route('containers.create') }}" class="btn btn-primary">Nuevo Contenedor</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                    <th>Cliente</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($containers as $container)
                    <tr>
                        <td><strong>{{ $container->code }}</strong></td>
                        <td>{{ $container->type }}</td>
                        <td>{{ $container->capacity }}</td>
                        <td>
                            @if($container->status === 'Almacenado')
                                <span class="badge bg-success">{{ $container->status }}</span>
                            @elseif($container->status === 'En reparación')
                                <span class="badge bg-warning text-dark">{{ $container->status }}</span>
                            @else
                                <span class="badge bg-info text-dark">{{ $container->status }}</span>
                            @endif
                        </td>
                        <td>{{ $container->client->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('containers.show', $container) }}" class="btn btn-sm btn-info text-white">Ver</a>
                            <a href="{{ route('containers.edit', $container) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('containers.destroy', $container) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este contenedor?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No hay contenedores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection