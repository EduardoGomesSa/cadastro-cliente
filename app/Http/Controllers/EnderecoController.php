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

    public function clientesPorEndereco($enderecoId)
    {
        $endereco = Endereco::find($enderecoId);
        $clientes = $endereco->clientes;

        $resource = ClienteResource::collection($clientes);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Endereco $endereco)
    {

    }
}
