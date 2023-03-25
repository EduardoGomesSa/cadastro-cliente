<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();

        return  response()->json($clientes);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User();
        $user -> nome = $request -> nome;
        $user -> email = $request -> email;

        $validatedAddress = $request -> endereco -> validate([
            'logradouro' => 'required | string',
            'cidade' => 'required | string',
            'estado' => 'required | string',
            'cep' => 'required | string',
        ]);

        $user -> endereco() -> create($validatedAddress);

        $validated = $request -> validate([
            'nome' => 'required | string',
            'email' => 'required | email:rfc,dns',
            'endereco_id' => 'required',
        ]);

        Cliente::create($validated);

        return response()->json(['message' => 'Operação bem sucedida'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // {
        //     "nome":"Eduardo Gomes",
        //     "email":"eduardo@gmail.com",
        //     "endereco_id": 1
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente -> delete();
    }
}
