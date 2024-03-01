<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Mostrar la lista de transacciones
    public function index()
    {
        $transactions = Transaction::all();
        return view('index', ['transactions' => $transactions]);
    }

    // Mostrar el formulario para crear una nueva transacción
    public function create()
    {
        return view('create');
    }

    // Almacenar una nueva transacción en la base de datos
    public function store(Request $request) {
    // Valida los datos del formulario
    $request->validate([
        'amount' => 'required|numeric',
        'category' => 'required',
    ]);

    // Crea una nueva instancia de Transaction
    $transaction = new Transaction();
    $transaction->amount = $request->amount;
    $transaction->category = $request->category;
    $transaction->date = now();

    // Asigna una descripción basada en la cantidad y la categoría
    $description = 'Transacción de ' . $request->amount . ' en la categoría ' . $request->category;
    $transaction->description = $description;

    // Guarda la transacción en la base de datos
    $transaction->save();

    // Redirecciona a la página principal con un mensaje de éxito
    return redirect('/')->with('success', '¡Transacción creada con éxito!');
    }

    // Mostrar una transacción específica
    public function show($id) {
        // Encuentra la transacción por su ID
        $transaction = Transaction::findOrFail($id);

        // Retornar la vista para mostrar la transacción
        return view('show', compact('transaction'));
    }

    public function edit($id) {
        // Encuentra la transacción por su ID
        $transaction = Transaction::findOrFail($id);

        // Retornar la vista para editar la transacción
        return view('edit', compact('transaction'));
    }

    // Actualizar una transacción específica en la base de datos
    public function update(Request $request, $id) {
    // Valida los datos del formulario
    $request->validate([
        'amount' => 'required|numeric',
        'category' => 'required',
    ]);

    // Encuentra la transacción por su ID
    $transaction = Transaction::findOrFail($id);
    $transaction->amount = $request->amount;
    $transaction->category = $request->category;

    $transaction->save();

    // Redirecciona a la página principal 
    return redirect('/')->with('success', '¡Transacción actualizada con éxito!');
    }

    // Eliminar una transacción 
    public function delete($id)
    {
    $transaction = Transaction::findOrFail($id);
    $transaction->delete();

    return redirect('/transactions')->with('success', '¡Transacción eliminada con éxito!');
    }

}

