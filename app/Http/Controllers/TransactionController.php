<?php

namespace App\Http\Controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use DateTime; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['details', 'user'])->get();
        return view('index', ['transactions' => $transactions]);
    }

    public function create()
    {
        return view('create');
    }

   public function store(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric',
        'category' => 'required',
        'transfer_type' => 'required',
        'details.item_name.*' => 'required',
        'details.quantity.*' => 'required|numeric|min:1',
        'details.unit_price.*' => 'required|numeric|min:0',
        'type' => 'nullable',
    ]);

    DB::beginTransaction();

    try {
        // Crear la transacción principal
        $transaction = new Transaction();
        $transaction->amount = $request->input('amount', 0);
        $transaction->category = $request->category;
        $transaction->transfer_type = $request->transfer_type;
        $transaction->type = $request->type;
        $transaction->date = new DateTime($request->input('date'));
        $transaction->save();

        // Punto de depuración para verificar la transacción
        \Log::info('Transaction saved:', $transaction->toArray());

        // Obtener los detalles de la transacción desde el request
        $details = $request->input('details');

        // Comprobar si $details está definido y no está vacío
        if (isset($details) && count($details['item_name']) > 0) {
            foreach ($details['item_name'] as $index => $itemName) {
                // Crear un nuevo detalle de transacción
                $transactionDetail = new TransactionDetail();
                $transactionDetail->transaction_id = $transaction->id;
                $transactionDetail->item_name = $itemName;
                $transactionDetail->quantity = $details['quantity'][$index];
                $transactionDetail->unit_price = $details['unit_price'][$index];
                
                // Punto de depuración para verificar la instancia antes de guardar
                \Log::info('TransactionDetail before save:', $transactionDetail->toArray());

                // Guardar el detalle de la transacción
                $transactionDetail->save();

                // Punto de depuración para verificar la instancia después de guardar
                \Log::info('TransactionDetail after save:', $transactionDetail->toArray());
            }
        }

        DB::commit();

        return redirect()->route('transactions.index')->with('success', '¡Transacción creada con éxito!');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error al guardar la transacción:', ['error' => $e->getMessage()]);
        return back()->withInput()->withErrors(['error' => 'Error al guardar la transacción.']);
    }
}


    public function update(Request $request, $id)
{
    // Valida los datos del formulario de actualización
    $request->validate([
        'amount' => 'required|numeric',
        'category' => 'required',
        'transfer_type' => 'required',
        'date' => 'required|date',
    ]);

    // Encuentra la transacción por su ID
    $transaction = Transaction::findOrFail($id);

    // Agrega un dd() para verificar los datos de la transacción antes de la actualización
    dd('Datos de la transacción antes de la actualización', $transaction);

    // Actualiza los campos de la transacción
    $transaction->amount = $request->input('amount');
    $transaction->category = $request->input('category');
    $transaction->transfer_type = $request->input('transfer_type');
    $transaction->date = $request->input('date');

    // Guarda los cambios en la base de datos
    $transaction->save();

    // Agrega un dd() para verificar los datos de la transacción después de la actualización
    dd('Datos de la transacción después de la actualización', $transaction);

    // Redirecciona de vuelta a la página de transacciones con un mensaje de éxito
    return redirect('/transactions')->with('success', 'Transacción actualizada exitosamente.');
}



public function show($id)
{
    $transaction = Transaction::findOrFail($id);
    $details = TransactionDetail::where('transaction_id', $transaction->id)->get();

    return view('show', compact('transaction', 'details'));
}


  public function edit($id)
{
    $transaction = Transaction::findOrFail($id);
    $details = $transaction->details; 

    return view('edit', compact('transaction', 'details'));
}


    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect('/transactions')->with('success', '¡Transacción eliminada con éxito!');
    }
}
