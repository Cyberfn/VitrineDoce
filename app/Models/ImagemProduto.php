<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImagemProduto extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'caminho',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
