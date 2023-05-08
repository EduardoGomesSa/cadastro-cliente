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

        return  $resource->response()->setStatusCode(202);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clienteExiste = $this->clienteModel->cpfExiste($request->cpf);
        if($clienteExiste) return response()->json(["message"=>"cpf já está cadastrado"])->setStatusCode(409);

        $contatoExiste = $this->contatoModel->contatoExiste($request);

        if($contatoExiste){
            $dadosIguais = $request['email'] === $contatoExiste->email ?
                'email: '.$request['email'] : '';
            $dadosIguais .= $request['telefone'] === $contatoExiste->telefone ?
                ' telefone: '.$request['telefone'] : '';
            $dadosIguais .= $request['celular'] === $contatoExiste->celular ?
                ' celular: '.$request['celular'] : '';

            return response()
                ->json(['message'=>"Contatos já estão cadastrados - Dados já existentes: $dadosIguais"])
                ->setStatusCode(409);
        }

        $contato = $this->contatoModel->criar($request);
        $request['contato_id'] = $contato->id;

        $enderecoExiste = $this->enderecoModel->enderecoExiste($request);
        if($enderecoExiste != null){
            $request['endereco_id'] = $enderecoExiste->id;

            $cliente = $this->clienteModel->criar($request);

            $resource = new ClienteResource($cliente);

            return $resource->response()->setStatusCode(201);
        }
        $endereco = $this->enderecoModel->criar($request);

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
    public function update(Request $request)
    {
        $clienteExiste = $this->clienteModel->clienteExiste($request->id);

        if($clienteExiste){
            $clienteAtualizado = $this->clienteModel->atualizar($request);

            if($clienteAtualizado) return response()->json(["message"=>"cliente atualizado com sucesso"]);

            return response()->json(["message"=>"erro ao atualizar cliente"]);
        }

        return response()->json(["message"=>"cliente não existe"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cliente = Cliente::find($request->id);

        $this->contatoModel->apagar($cliente->contato_id);

        $clienteApagado = $cliente->delete();

        if($clienteApagado)
        return response()->json(['message'=>'cliente apagado com sucesso'])->setStatusCode(200);

        return response()->json(['message'=>'erro ao apagar cliente'], 401);
    }
}
