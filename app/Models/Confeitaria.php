<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Confeitaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cep',
        'rua',
        'numero',
        'bairro',
        'estado',
        'cidade',
        'telefone',
        'latitude',
        'longitude',
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
