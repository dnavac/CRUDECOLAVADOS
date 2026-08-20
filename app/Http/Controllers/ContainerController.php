<?php

namespace App\Http\Controllers;

use App\Models\Container;
use Illuminate\Http\Request;
use App\Models\Client;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Cargamos el contenedor junto con la info del cliente
        $containers = Container::with('client')->latest()->get();
        return view('containers.index', compact('containers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Obtenemos todos los clientes para mostrarlos en el formulario de creación de contenedores
        $clients = Client::all();
        return view('containers.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Todo contnedor nuevo debe ser almacenado por defecto, si no se especifica un estado
        if(!$request->filled('status')){
            $request->merge(['status' => 'Almacenado']);
        }    

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:containers,code',
            'type' => 'required|string|in:Seco,Isotanque',
            'capacity' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:Almacenado,En lavado,En reparación',
            'client_id' => 'required|exists:clients,id',
        ],
        [
            'code.unique' => 'El código del contenedor ya está en uso. Por favor, elige otro.',
            'code.max' => 'El código del contenedor no puede tener más de 50 caracteres.',
            'type.in' => 'El tipo de contenedor debe ser "Seco" o "Isotanque".',
            'capacity.min' => 'La capacidad del contenedor debe ser un número positivo.',
            'status.in' => 'El estado del contenedor debe ser "Almacenado", "En lavado" o "En reparación".',
            'client_id.exists' => 'El cliente seleccionado no existe.',
        ]
        );

        //Seco NUNCA puede ser "En lavado"
        if ($request->type === 'Seco' && $request->status === 'En lavado') {
            return back()->withErrors(['status' => 'Un contenedor seco no puede estar en estado "En lavado".'])->withInput();
        }
        Container::create($validated);
        return redirect()->route('containers.index')->with('success', 'Contenedor registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Container $container)
    {
        $container->load('client');
        return view('containers.show', compact('container'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Container $container)
    {
        $clients = Client::all();
        return view('containers.edit', compact('container', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Container $container)
    {
        $validated = $request->validate([
            'code'      => 'required|string|max:50|unique:containers,code,' . $container->id,
            'type'      => 'required|in:Seco,Isotanque',
            'capacity'  => 'required|numeric|min:0',
            'status'    => 'required|in:Almacenado,En lavado,En reparación',
            'client_id' => 'required|exists:clients,id',
        ],
        [
            'code.unique' => 'El código del contenedor ya está en uso. Por favor, elige otro.',
            'type.in' => 'El tipo de contenedor debe ser "Seco" o "Isotanque".',
            'capacity.min' => 'La capacidad del contenedor debe ser un número positivo.',
            'status.in' => 'El estado del contenedor debe ser "Almacenado", "En lavado" o "En reparación".',
            'client_id.exists' => 'El cliente seleccionado no existe.',
        ]
        );

        //Seco NUNCA puede ser "En lavado"
        if ($request->type === 'Seco' && $request->status === 'En lavado') {
            return back()->withErrors([
                'status' => 'Un contenedor de tipo seco jamás puede guardarse con el estado "En lavado".'
            ])->withInput();
        }

        $container->update($validated);

        return redirect()->route('containers.index')->with('success', 'Contenedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Container $container)
    {
        $container->delete();

        return redirect()->route('containers.index')->with('success', 'Contenedor eliminado exitosamente.');
    }
}
