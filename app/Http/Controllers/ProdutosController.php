<?php

namespace App\Http\Controllers;

use App\Models\Confeitaria;
use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProdutosController extends Controller
{

    public function index()
    {
        $produtos = Produto::all();
        return Inertia::render('Produtos/Index', [
            'produtos' => $produtos,
        ]);
    }

    public function create()
    {
        $confeitarias = Confeitaria::all();
        return Inertia::render('Produtos/Create', [
            'confeitarias' => $confeitarias,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'valor' => 'required|numeric',
            'descricao' => 'nullable|string',
            'confeitaria_id' => 'required|exists:confeitarias,id',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $produto = Produto::create([
            'nome' => $request->nome,
            'valor' => $request->valor,
            'descricao' => $request->descricao,
            'confeitaria_id' => $request->confeitaria_id,
        ]);

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $path = $imagem->store('produtos', 'public');
                ProdutoImagem::create([
                    'imagem' => $path,
                    'produto_id' => $produto->id,
                ]);
            }
        }

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }
}
