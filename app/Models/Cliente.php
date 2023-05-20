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

    public function getAll(Request $request){
        if(!$request->filter){
            $this::all();
        }

        return $this::where('name', 'LIKE', $request->filter.'%');
    }

    public function endereco(){
        return $this->belongsTo(Endereco::class);
    }

    public function contato(){
        return $this->belongsTo(Contato::class);
    }

    public function clientesNoEndereco($idEndereco){
        return $this::where('endereco_id', $idEndereco)->get();
    }
}
