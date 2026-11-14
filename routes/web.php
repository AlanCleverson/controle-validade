<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::get('/', [ProdutoController::class, 'index'])
    ->name('produtos.index');

Route::resource('produtos', ProdutoController::class)
    ->except(['index', 'show']);
