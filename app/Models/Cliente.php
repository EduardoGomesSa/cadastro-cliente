<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
    ];

    public function endereco(){
        return $this->belongsTo(Endereco::class);
    }

    public function contato(){
        return $this->hasOne(Contato::class);
    }
}
