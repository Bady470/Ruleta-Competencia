<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuletaController;

/**
 * RUTA PRINCIPAL: La ruleta es la página de inicio
 */
Route::get('/', [RuletaController::class, 'index'])->name('ruleta.index');

/**
 * GRUPO DE RUTAS DE LA RULETA
 */
Route::prefix('ruleta')->group(function () {
    // Ruta para ver la ruleta directamente
    Route::get('/', [RuletaController::class, 'index']);

    // NUEVA RUTA: Para ver la pantalla final de resultados con todos los equipos
    Route::get('/resultados', [RuletaController::class, 'resultados'])->name('ruleta.resultados');
    Route::get('/puntaje', [RuletaController::class, 'puntaje'])->name('ruleta.puntaje');


    // Ruta para guardar los equipos en la sesión (se usa vía JavaScript)
    Route::post('/guardar', [RuletaController::class, 'guardarEquipos'])->name('ruleta.guardar');

    // Rutas para exportar y limpiar
    Route::get('/exportar-pdf', [RuletaController::class, 'exportarPDF'])->name('ruleta.exportar-pdf');
    Route::get('/exportar-excel', [RuletaController::class, 'exportarExcel'])->name('ruleta.exportar-excel');
    Route::get('/limpiar', [RuletaController::class, 'limpiar'])->name('ruleta.limpiar');
});
