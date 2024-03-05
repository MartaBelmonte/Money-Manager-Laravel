<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function index()
{
    // Obtener todas las transacciones con sus detalles, usuario asociado y la suma de precios unitarios y cantidad total
    $transactions = Transaction::with(['details', 'user'])->get();
    
    // Array para almacenar la suma de los precios unitarios por ID de transacción
    $totalAmounts = [];

    // Calcular la suma de los precios unitarios y la cantidad total para cada transacción
    foreach ($transactions as $transaction) {
        // Obtener los detalles de la transacción
        $details = TransactionDetail::where('transaction_id', $transaction->id)->get();

        // Inicializar la suma de precios unitarios y cantidad total para esta transacción
        $totalAmount = 0;
        $totalQuantity = 0;

        // Sumar los precios unitarios y la cantidad de los detalles de la transacción, si hay detalles disponibles
        if ($details->isNotEmpty()) {
            foreach ($details as $detail) {
                $totalAmount += $detail->unit_price * $detail->quantity; // Corrección aquí
                $totalQuantity += $detail->quantity;
            }
        }

        // Almacenar la suma en el array
        $totalAmounts[$transaction->id] = $totalAmount;
        $transaction->totalQuantity = $totalQuantity;
    }

    // Pasar los datos a la vista
    return view('index', compact('transactions'));
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
        'transfer_type' => 'required',
        'details.*.item_name' => 'required',
        'details.*.quantity' => 'required|numeric|min:1',
        'details.*.unit_price' => 'required|numeric|min:0',
    ]);

    // Crear una nueva instancia de Transaction
    $transaction = new Transaction();
    $transaction->amount = $request->input('amount', 0);
    $transaction->category = $request->category;
    $transaction->transfer_type = $request->transfer_type;
    $transaction->date = now();

    // Guardar la transacción en la base de datos
    $transaction->save();

    // Guardar los detalles de la transacción si se proporcionaron y son válidos
    if ($request->filled('details') && is_array($request->details)) {
        foreach ($request->details as $detail) {
            // Guardar detalles de la transacción con la transacción principal
            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_id = $transaction->id; // Asociar con la transacción principal
            $transactionDetail->item_name = $detail['item_name'];
            $transactionDetail->quantity = $detail['quantity'];
            $transactionDetail->unit_price = $detail['unit_price'];
            $transactionDetail->save();
        }
    }

    // Redireccionar a la página principal con un mensaje de éxito
    return redirect('/')->with('success', '¡Transacción creada con éxito!');
}

    // Mostrar el formulario para editar una transacción
    public function edit($id)
{
    $transaction = Transaction::find($id);
    $details = TransactionDetail::where('transaction_id', $transaction->id)->get(); 

    return view('edit', ['transaction' => $transaction, 'details' => $details]);
}


   // Actualizar una transacción específica en la base de datos
public function update(Request $request, $id)
{
    // Encuentra la transacción por su ID
    $transaction = Transaction::findOrFail($id);

    // Actualiza la transacción principal
    $transaction->update($request->except('details'));

    // Actualiza los detalles de la transacción si se proporcionan datos de detalle
    if ($request->filled('details')) {
        foreach ($request->details as $detailId => $detailData) {
            $detail = TransactionDetail::findOrFail($detailId);
            $detail->update($detailData);
        }
    }

    // Establece el mensaje de sesión flash solo si se actualiza exitosamente
    session()->flash('status', 'Los cambios se han guardado correctamente.');

    // Redirecciona a la página de edición con el mensaje de éxito
    return redirect()->route('transactions.edit', $id);
}


    //Mostrar transaccion
    public function show($id)
{
    // Encuentra la transacción por su ID
    $transaction = Transaction::findOrFail($id);

    // Cargar los detalles de la transacción
    $details = TransactionDetail::where('transaction_id', $transaction->id)->get();

    // Retornar la vista para mostrar los detalles de la transacción
    return view('show', compact('transaction', 'details'));
}


    // Eliminar una transacción 
    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect('/transactions')->with('success', '¡Transacción eliminada con éxito!');
    }
}
