<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::WithCount('containers')->latest()->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'document' => 'required|string|max:50|unique:clients,document',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:10',
            'address' => 'required|string|max:255',
        ],
        [
            'document.unique' => 'El documento del cliente ya está en uso. Por favor, elige otro.',
            'document.max' => 'El documento del cliente no puede tener más de 50 caracteres.',
            'email.email' => 'El correo electrónico no es válido.',
            'phone.max' => 'El número de teléfono no puede tener más de 10 dígitos.',
        ]
        );

        Client::create($validated);

        return redirect()->route('clients.index')-> with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client ->load('containers');
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'document' => 'required|string|max:50|unique:clients,document,' . $client->id,
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:10',
            'address' => 'required|string|max:255',
        ], 
        [
            'document.unique' => 'El documento del cliente ya está en uso. Por favor, elige otro.',
            'document.max' => 'El documento del cliente no puede tener más de 50 caracteres.',
            'email.email' => 'El correo electrónico no es válido.',
            'phone.max' => 'El número de teléfono no puede tener más de 10 dígitos.',
        ]
        );

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
