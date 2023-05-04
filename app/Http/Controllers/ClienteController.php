<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Endereco;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $enderecoModel;
    private $contatoModel;
    private $clienteModel;

    /**
     * Class constructor
     *
     * @param EnderecoController $enderecoController dependence injection
     */
    public function __construct(Endereco $endereco, Contato $contato, Cliente $cliente)
    {
        $this->enderecoModel = $endereco;
        $this->contatoModel = $contato;
        $this->clienteModel = $cliente;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resource = ClienteResource::collection(
            Cliente::all()
        );

        return  $resource->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nome'=>'required|string|max:255',
            'data_nascimento'=>'required|date_format:Y-m-d',
            'cpf'=>'required|string',
        ];

        $validatedData = $request->validate($rules);

        /** @param Endereco $enderecoExiste */
        $enderecoExiste = $this->enderecoModel->enderecoExiste($request);

        $contatoExiste = $this->contatoModel->contatoExiste($request);

        if($contatoExiste){
            $dadosIguais = $validatedData['email'] === $contatoExiste->email ?
                'email: '.$validatedData['email'] : '';
            $dadosIguais .= $validatedData['telefone'] === $contatoExiste->telefone ?
                ' telefone: '.$validatedData['telefone'] : '';
            $dadosIguais .= $validatedData['celular'] === $contatoExiste->celular ?
                ' celular: '.$validatedData['celular'] : '';

            return response()
                ->json(['message'=>"Contatos já estão cadastrados - Dados já cadastrados: $dadosIguais"])
                ->setStatusCode(422);
        }

        $contato = $this->contatoModel->criar($request);

        if($enderecoExiste != null){
            $cliente = Cliente::create([
                'nome'=>$validatedData['nome'],
                'cpf'=>$validatedData['cpf'],
                'data_nascimento'=>$validatedData['data_nascimento'],
                'endereco_id'=>$enderecoExiste->id,
                'contato_id'=>$contato->id,
            ]);

            $resource = new ClienteResource($cliente);

            return $resource->response()->setStatusCode(201);
        }

        $endereco = $this->enderecoModel->criar($request);

        $request['contato_id'] = $contato->id;
        $request['endereco_id'] = $endereco->id;
        $cliente = $this->clienteModel->criar($request);

        $resource = new ClienteResource($cliente);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {

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
        Cliente::find($id)->delete();
    }
}
