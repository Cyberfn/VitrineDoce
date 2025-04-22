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
}
