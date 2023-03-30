<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
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
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clientes,email|max:255',
            'logradouro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9'
        ];

        $validatedData = $request->validate($rules);

        $endereco = Endereco::create([
            'logradouro' => $validatedData['logradouro'],
            'cidade' => $validatedData['cidade'],
            'estado' => $validatedData['estado'],
            'cep' => $validatedData['cep']
        ]);

        Cliente::create([
            'nome' => $validatedData['nome'],
            'email' => $validatedData['email'],
            'endereco_id' => $endereco->id
        ]);

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
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clientes,email|max:255',
            'logradouro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Cliente::find($id) -> delete();
    }
}
