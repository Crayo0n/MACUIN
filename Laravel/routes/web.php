<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UsuarioController;

define('API_URL', env('API_URL', 'http://server_api:8080'));

// ── Auth 
Route::get('/login', fn() => view('admin.auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// ── Sesión Protegida 
Route::middleware(['admin.auth'])->group(function () {
    
    // ── Dashboard Principal 
    Route::get('/admin', function () {
        return redirect('/inventario');
    })->name('admin.home');

    Route::get('/', function () {
        return redirect('/admin');
    });

    // ── Inventario 
    Route::prefix('inventario')->group(function () {
        Route::get('/', [InventarioController::class, 'index']);
        Route::get('/crear', [InventarioController::class, 'create']);
        Route::post('/store', [InventarioController::class, 'store']);
        Route::get('/editar/{id}', [InventarioController::class, 'edit']);
        Route::put('/update/{id}', [InventarioController::class, 'update']);
        Route::delete('/destroy/{id}', [InventarioController::class, 'destroy']);
        Route::post('/categorias', [InventarioController::class, 'storeCategoria']);
    });

    // ── Órdenes 
    Route::prefix('ordenes')->group(function () {
        Route::get('/', [OrdenController::class, 'index']);
        Route::put('/update-status/{id}', [OrdenController::class, 'updateStatus']);
        Route::get('/{id}/detalles', [OrdenController::class, 'getDetails']); // Ruta AJAX limpia
    });

    // ── Reportes
    Route::prefix('admin/reportes')->group(function () {
        Route::get('/ventas', [ReportesController::class, 'indexVentas']);
        Route::get('/pedidos', [ReportesController::class, 'indexPedidos']);
        
        // Gestión de Usuarios
        Route::post('/usuarios', [UsuarioController::class, 'store']);
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
        Route::get('/usuarios', [ReportesController::class, 'indexUsuarios']);
        Route::get('/usuarios_crear', fn() => view('admin.reportes.usuarios_crear'));
    });
});