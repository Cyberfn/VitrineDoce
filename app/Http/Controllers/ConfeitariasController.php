<?php

namespace App\Http\Controllers;

use App\Models\Confeitaria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfeitariasController extends Controller
{
    public function index()
    {
        $confeitarias = Confeitaria::all();
        return Inertia::render('Confeitarias/Index', [
            'confeitarias' => $confeitarias,
        ]);
    }

    public function create()
    {
        return Inertia::render('Confeitarias/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:10',
            'rua' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'numero' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Confeitaria::create($request->all());

        return redirect('/')->with('success', 'Confeitaria cadastrada com sucesso!');
    }

    public function update(Request $request, int $id)
    {
        $confeitaria = Confeitaria::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string',
            'descricao' => 'nullable|string',
            'endereco' => 'nullable|string',
            'telefone' => 'nullable|string',
            'cep' => 'nullable|string',
            'rua' => 'nullable|string',
            'numero' => 'nullable|string',
            'complemento' => 'nullable|string',
            'bairro' => 'nullable|string',
            'cidade' => 'nullable|string',
            'estado' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $confeitaria->update($validated);

        return redirect()->back()->with('success', 'Confeitaria atualizada com sucesso!');
    }

    public function excluir($id)
    {

        $confeitaria = Confeitaria::findOrFail($id);

        $confeitaria->produtos()->delete();

        $confeitaria->delete();

        return redirect('/')->with('success', 'Confeitaria Deletada com sucesso!');
    }
}
