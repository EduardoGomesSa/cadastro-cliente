<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContatoRequest;
use App\Models\Contato;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    private $contato;

    public function __construct(Contato $contato)
    {
        $this->contato = $contato;
    }

    public function update(ContatoRequest $request, $id){
        $contatoExiste = $this->contato->find($id);

        if($contatoExiste){
            $contatoExiste->update($request->all());

            return response(["message"=>"contato atualizado com sucesso"])->setStatusCode(200);
        }

        return response(["rrror"=>"contato não existe"])->setStatusCode(401);
    }
}
