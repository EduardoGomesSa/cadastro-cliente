<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
                'id'=>$this->id,
                'nome'=>$this->nome,
                'cpf'=>$this->cpf,
                'data_nascimento'=>$this->data_nascimento,
                'endereco_id'=> new EnderecoResource($this->endereco),
                'contato_id'=> new ContatoResource($this->contato),
            ];
    }
}
