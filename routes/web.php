<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect ('/transactions');
});

// Ruta para mostrar todas las transacciones
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

// Ruta para mostrar el formulario de creación de transacciones
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');

// Ruta para almacenar una nueva transacción
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

// Ruta para mostrar una transacción específica
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

// Ruta para mostrar el formulario de edición de una transacción
Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');

// Ruta para actualizar una transacción
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');

// Ruta para eliminar una transacción
Route::delete('/transactions/{id}', [TransactionController::class, 'delete'])->name('transactions.delete');



