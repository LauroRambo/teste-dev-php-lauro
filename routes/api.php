<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;

Route::apiResource('fornecedores', FornecedorController::class);
