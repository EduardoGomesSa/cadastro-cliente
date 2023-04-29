<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Endereco;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $enderecoController;

    /**
     * Class constructor
     *
     * @param EnderecoController $enderecoController dependence injection
     */
    public function __construct(EnderecoController $enderecoController)
    {
        $this->enderecoController = $enderecoController;
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
            'nome' => 'required|string|max:255',
            'data_nascimento'=>'required|date_format:Y-m-d',
            'cpf'=>'required|string',

            'logradouro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9',

            'email' => 'required|string|email|unique:clientes,email|max:255',
            'telefone'=>'string',
            'celular'=>'required|string',
        ];

        $validatedData = $request->validate($rules);

        /** @param Endereco $enderecoExiste */
        $enderecoExiste = Endereco::where('logradouro', $validatedData['logradouro'])
            ->where('cidade', $validatedData['cidade'])
            ->where('estado', $validatedData['estado'])
            ->where('cep', $validatedData['cep']);

        $contato = Contato::create([
            'email'=>$validatedData['email'],
            'celular'=>$validatedData['celular'],
            'telefone'=>$validatedData['telefone'],
        ]);

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

        $endereco = Endereco::create([
            'logradouro'=>$validatedData['logradouro'],
            'cidade'=>$validatedData['cidade'],
            'estado'=>$validatedData['estado'],
            'cep'=>$validatedData['cep']
        ]);

        //$endereco = json_decode($this->enderecoController->store($request));

        $cliente = Cliente::create([
            'nome'=>$validatedData['nome'],
            'cpf'=>$validatedData['cpf'],
            'data_nascimento'=>$validatedData['data_nascimento'],
            'endereco_id'=>$endereco->id,
            'contato_id'=>$contato->id,
        ]);

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
        Cliente::find($id) -> delete();
    }
}
