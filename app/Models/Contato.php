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

    public function apagar($id){
        $this::find($id)->delete();
    }
}
