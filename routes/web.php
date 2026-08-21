<?php

use App\Http\Controllers\AprendizController;
use App\Http\Controllers\ValidacionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ActividadController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\FichoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas — Portal del Aprendiz
|--------------------------------------------------------------------------
*/
Route::get('/', [AprendizController::class, 'index'])->name('aprendiz.index');
Route::post('/buscar', [AprendizController::class, 'buscar'])
    ->middleware('throttle:15,1')
    ->name('aprendiz.buscar');
Route::get('/carnet/{documento}', [AprendizController::class, 'carnet'])->name('aprendiz.carnet');

/*
|--------------------------------------------------------------------------
| Rutas de Staff — Panel de Validación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\EsOperador::class])->group(function () {
    Route::get('/validacion', [ValidacionController::class, 'index'])->name('validacion.index');
    Route::post('/validacion', [ValidacionController::class, 'validar'])->name('validacion.validar');
});

/*
|--------------------------------------------------------------------------
| Rutas de Administración
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\EsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats', [DashboardController::class, 'stats'])->name('stats');

        // Importación Excel
        Route::get('/importar', [ImportController::class, 'show'])->name('importar.show');
        Route::post('/importar', [ImportController::class, 'import'])->name('importar.import');

        // CRUD Actividades
        Route::resource('actividades', ActividadController::class);

        // CRUD Usuarios/Operadores
        Route::resource('usuarios', UsuarioController::class);

        // Gestión de fichos
        Route::get('/fichos', [FichoController::class, 'index'])->name('fichos.index');
        Route::post('/fichos/{ficho}/resetear', [FichoController::class, 'resetear'])->name('fichos.resetear');
        Route::get('/exportar/{actividad}', [FichoController::class, 'exportar'])->name('fichos.exportar');
    });

/*
|--------------------------------------------------------------------------
| Rutas de Auth (Breeze) — Redirigir dashboard según rol
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->user()->esAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('validacion.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
