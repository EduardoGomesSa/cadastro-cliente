<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClienteResource;
use App\Http\Resources\EnderecoResource;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resource = EnderecoResource::collection(
            Endereco::all()
        );

        return $resource->response()->setStatusCode(200);
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

        $endereco = Endereco::create($validated);

        $resource = new EnderecoResource($endereco);

        return $resource->response()->setStatusCode(201);
    }

    public function clientesPorEndereco($enderecoId)
    {
        $endereco = Endereco::find($enderecoId);
        $clientes = $endereco->clientes;

        $resource = ClienteResource::collection($clientes);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $endereco = Endereco::find($request->id);

        $resource = new EnderecoResource($endereco);

        return $resource->response()->setStatusCode(200);
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
