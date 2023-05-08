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

    public function cpfExiste($cpf){
        return $this::where('cpf', $cpf)->first();
    }

    public function clienteExiste($id){
        return $this::find($id);
    }

    public function clientesNoEndereco($idEndereco){
        return $this::where('endereco_id', $idEndereco)->get();
    }

    public function atualizar(Request $request){
        $rules = [
            'nome' => 'string|max:255',
            'cpf' => 'string',
            'data_nascimento'=>'date_format:Y-m-d',
        ];

        $request->validate($rules);

        return $this::find($request->id)->update($request->all());
    }
}
