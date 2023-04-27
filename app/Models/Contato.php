<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $fillable = [
        'celular',
        'telefone',
        'email',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
