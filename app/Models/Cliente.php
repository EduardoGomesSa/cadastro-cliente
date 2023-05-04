<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'endereco_id',
        'contato_id',
    ];

    public function endereco(){
        return $this->belongsTo(Endereco::class);
    }

    public function contato(){
        return $this->belongsTo(Contato::class);
    }

    public function criar(Request $request){
        $rules = [
            'nome'=>'required|string|max:255',
            'data_nascimento'=>'required|date_format:Y-m-d',
            'cpf'=>'required|string',
        ];

        $dadosValidados = $request->validate($rules);

        return Cliente::create([
            'nome'=>$dadosValidados['nome'],
            'cpf'=>$dadosValidados['cpf'],
            'data_nascimento'=>$dadosValidados['data_nascimento'],
            'contato_id'=>$request['contato_id'],
            'endereco_id'=>$request['endereco_id'],
        ]);
    }
}
