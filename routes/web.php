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
    $confeitarias = Confeitaria::all();
    return Inertia::render('Confeitarias/Mapa', ['confeitarias' => $confeitarias]);
})->name('mapa');

// Rotas de Confeitarias
Route::prefix('confeitarias')->name('confeitarias.')->group(function () {
    Route::get('/', [ConfeitariasController::class, 'index'])->name('index');
    Route::get('/create', [ConfeitariasController::class, 'create'])->name('create');
    Route::post('/', [ConfeitariasController::class, 'store'])->name('store');
    Route::get('/{id}', [ConfeitariasController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ConfeitariasController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ConfeitariasController::class, 'update'])->name('update');
    Route::put('/{id}/desativar', [ConfeitariasController::class, 'desativar'])->name('desativar'); 
});

// Rotas de Produtos 
Route::prefix('produtos')->name('produtos.')->group(function () {
    Route::get('/create/{confeitaria_id}', [ProdutosController::class, 'create'])->name('create');
    Route::get('/', [ProdutosController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProdutosController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProdutosController::class, 'update'])->name('update');
    Route::put('/{id}/desativar', [ProdutosController::class, 'desativar'])->name('desativar');
});
