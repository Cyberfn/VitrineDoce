<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfeitariasController;
use App\Http\Controllers\ProdutosController;
use App\Models\Confeitaria;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('confeitarias.index');
});

Route::get('/mapa', function () {
    return Inertia::render('Mapa', ['confeitarias' => Confeitaria::all()]);
})->name('mapa');

// Rotas de Confeitarias
Route::prefix('confeitarias')->name('confeitarias.')->group(function () {
    Route::get('/', [ConfeitariasController::class, 'index'])->name('index');         // Listar todas as confeitarias
    Route::get('/create', [ConfeitariasController::class, 'create'])->name('create'); // Formulário de criação
    Route::post('/', [ConfeitariasController::class, 'store'])->name('store');        // Salvar nova confeitaria
    Route::put('/{id}', [ConfeitariasController::class, 'update'])->name('update');   // Atualizar confeitaria existente
    Route::delete('/{id}', [ConfeitariasController::class, 'excluir'])->name('destroy'); // Excluir confeitaria
});

// Rotas de Produtos
Route::prefix('produtos')->name('produtos.')->group(function () {
    Route::get('/', [ProdutosController::class, 'index'])->name('index');        // Rota para listar todos os produtos
    Route::get('/create', [ProdutosController::class, 'create'])->name('create'); // Rota para exibir o formulário de criação de novo produto
    Route::post('/', [ProdutosController::class, 'store'])->name('store');        // Rota para salvar um novo produto no banco de dados  // Rota para exibir o formulário de edição de um produto existente
    Route::put('/{id}', [ProdutosController::class, 'update'])->name('update');   // Rota para atualizar um produto existente
    Route::delete('/{id}', [ProdutosController::class, 'excluir'])->name('excluir'); // Rota para excluir um produto
});
