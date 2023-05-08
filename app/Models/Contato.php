<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Contato extends Model
{
    use HasFactory;

    protected $fillable = [
        'celular',
        'telefone',
        'email',
    ];

    public function cliente(){
        return $this->hasOne(Cliente::class);
    }

    public function contatoExiste(Request $request){
        return $this::orWhere('email', $request['email'])
        ->orWhere('telefone', $request['telefone'])
        ->orWhere('celular', $request['celular'])
        ->first();
    }

    public function criar(Request $request){
        $rules = [
            'email'=>'required|email|max:255',
            'telefone'=>'string',
            'celular'=>'required|string',
        ];

        $dadosValidados = $request->validate($rules);

        return $this::create([
            'email'=>$dadosValidados['email'],
            'celular'=>$dadosValidados['celular'],
            'telefone'=>$dadosValidados['telefone'],
        ]);
    }

    public function apagar($id){
        $this::find($id)->delete();
    }
}
