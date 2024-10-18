<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/getUsuarios', [UsuarioController::class, 'getUsuarios'])->name('getUsuarios');
Route::post('/deleteUsuario', [UsuarioController::class, 'deleteUsuario'])->name('deleteUsuario');
Route::put('/updateUsuario', [UsuarioController::class, 'updateUsuario'])->name('updateUsuario');