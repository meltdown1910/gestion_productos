<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// Página principal.
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Rutas de autenticación.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Cerrar sesión.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Rutas disponibles para administradores y empleados.
Route::middleware(['auth'])->group(function () {

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    // Primero las rutas específicas.
    Route::get('/products/create', [ProductController::class, 'create'])
        ->middleware('role:admin')
        ->name('products.create');

    // Después la ruta dinámica.
    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

});

// Rutas exclusivas para administradores.
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

});
