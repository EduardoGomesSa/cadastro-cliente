<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'logradouro',
        'cidade',
        'estado',
        'cep',
    ];

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }

    public function enderecoExiste(Request $request){
        return $this::where('logradouro', $request['logradouro'])
            ->where('cidade', $request['cidade'])
            ->where('estado', $request['estado'])
            ->where('cep', $request['cep'])
            ->first();
    }

    public function criar(Request $request){
        $rules = [
            'logradouro'=>'required|string|max:255',
            'cidade'=>'required|string|max:255',
            'estado'=>'required|string|max:2',
            'cep'=>'required|string|max:9'
        ];

        $dadosValidados = $request->validate($rules);

        return $this::create([
            'logradouro'=>$dadosValidados['logradouro'],
            'cidade'=>$dadosValidados['cidade'],
            'estado'=>$dadosValidados['estado'],
            'cep'=>$dadosValidados['cep']
        ]);
    }
}
