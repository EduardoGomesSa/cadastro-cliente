<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enderecos = Endereco::all();

        return response()->json($enderecos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'logradouro' => 'required | string',
            'cidade' => 'required | string',
            'estado' => 'required | string',
            'cep' => 'required | string',
        ]);

        Endereco::create($validated);

        return response()->json(['message' => 'Operação bem sucedida'], 200);
    }

    public function clientesPorEndereco($enderecoId)
    {
        $endereco = Endereco::find($enderecoId);
        $clientes = $endereco->clientes;

        return response()->json($clientes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Endereco $endereco)
    {
        $enderecos = Endereco::find(1);

        dd($enderecos->clientes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Endereco $endereco)
    {
        $request->validate([

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Endereco $endereco)
    {
        //
    }
}
