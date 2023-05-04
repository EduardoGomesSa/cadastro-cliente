<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
