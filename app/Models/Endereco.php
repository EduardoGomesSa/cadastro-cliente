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

    public function apagar($id){
        $this::find($id)->delete();
    }
}
