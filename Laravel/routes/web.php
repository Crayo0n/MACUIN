<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', fn() => view('admin.auth.login'));

Route::get('/inventario', fn() => view('admin.inventario.index'));
Route::get('/inventario/crear', fn() => view('admin.inventario.crear'));
Route::get('/inventario/editar', fn() => view('admin.inventario.editar'));

Route::get('/ordenes', fn() => view('admin.ordenes.index'));

Route::get('/pedidos', fn() => view('admin.reportes.pedidos'));
Route::get('/ventas', fn() => view('admin.reportes.ventas'));
Route::get('/usuarios', fn() => view('admin.reportes.usuarios'));