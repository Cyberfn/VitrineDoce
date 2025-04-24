<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoImagem extends Model
{
    protected $table = 'produto_imagens';

    protected $fillable = ['imagem', 'produto_id'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}