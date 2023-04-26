<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnderecoResource extends JsonResource
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
            'logradouro'=>$this->logradouro,
            'cidade'=>$this->cidade,
            'estado'=>$this->estado,
            'cep'=>$this->cep
        ];
    }
}
