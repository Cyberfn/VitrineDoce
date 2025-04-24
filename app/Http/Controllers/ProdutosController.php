<?php

namespace App\Http\Controllers;

use App\Models\Confeitaria;
use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Artisan;

class ProdutosController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('produto_imagens')->get();

        $produtos = $produtos->map(function ($produto) {
            $produto->produto_imagens->map(function ($imagem) {
                $imagem->imagem = Storage::url($imagem->imagem);
                return $imagem;
            });
            return $produto;
        });

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
            'imagens.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
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
            Artisan::call('storage:link');
        }

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function update(Request $request, int $id)
    {
        $produto = Produto::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string',
            'valor' => 'required|numeric',
            'descricao' => 'nullable|string',
            'novas_imagens.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'imagens_removidas' => 'nullable|array',
            'imagens_removidas.*' => 'integer|exists:produto_imagens,id',
            'confeitaria_id' => 'required|exists:confeitarias,id',
        ]);

        $produto->update([
            'nome' => $validated['nome'],
            'valor' => $validated['valor'],
            'descricao' => $validated['descricao'],
            'confeitaria_id' => $validated['confeitaria_id'],
        ]);

        if (!empty($validated['imagens_removidas'])) {
            ProdutoImagem::whereIn('id', $validated['imagens_removidas'])->delete();
        }

        if ($request->hasFile('novas_imagens')) {
            foreach ($request->file('novas_imagens') as $imagem) {
                $path = $imagem->store('produtos', 'public');
                $produto->produto_imagens()->create([
                    'imagem' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }
}
