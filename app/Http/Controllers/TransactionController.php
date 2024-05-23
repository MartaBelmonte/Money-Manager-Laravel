<?php

namespace App\Http\Controllers;

use DateTime; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
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
                    $totalAmount += $detail->unit_price * $detail->quantity; 
                    $totalQuantity += $detail->quantity;
                }
            }

            // Almacenar la suma en el array
            $totalAmounts[$transaction->id] = $totalAmount;
            $transaction->totalQuantity = $totalQuantity;
        }

        // Pasar los datos a la vista  
        $transactions = Transaction::all();
        return view('index', ['transactions' => $transactions]);

    }

    // Mostrar el formulario para crear una nueva transacción
    public function create()
    {
        return view('create');
    }

public function store(Request $request)
{
    // Agregar dd para verificar los datos recibidos del formulario
    dd($request->all());
    
    // Valida los datos del formulario
    $request->validate([
        'amount' => 'required|numeric',
        'category' => 'required',
        'transfer_type' => 'required',
        'details.*.item_name' => 'required',
        'details.*.quantity' => 'required|numeric|min:1',
        'details.*.unit_price' => 'required|numeric|min:0',
        'type' => 'nullable',
    ]);
    
    // Utilizamos una transacción para garantizar la integridad de los datos
    DB::beginTransaction();

    try {
        // Crear una nueva instancia de Transaction
        $transaction = new Transaction();
        $transaction->amount = $request->input('amount', 0);
        $transaction->category = $request->category;
        $transaction->transfer_type = $request->transfer_type;
        $transaction->type = $request->type;

        // Convertir la fecha a un objeto DateTime
        $transaction->date = new DateTime($request->input('date')); // Asegúrate de que 'date' sea el nombre correcto del campo de fecha en tu formulario

        // Guardar la transacción
        $transaction->save();

        // Obtener los detalles del formulario
        $details = $request->input('details');

        // Agregar dd para verificar los detalles antes de guardar
        dd($details);

        // Guardar los detalles de la transacción si existen
if (!empty($details)) {
    foreach ($details['item_name'] as $index => $itemName) {
        // Crear una nueva instancia de TransactionDetail
        $transactionDetail = new TransactionDetail();

        // Establecer los atributos de TransactionDetail
        $transactionDetail->transaction_id = $transaction->id;
        $transactionDetail->item_name = $itemName;
        $transactionDetail->quantity = $details['quantity'][$index];
        $transactionDetail->unit_price = $details['unit_price'][$index];

        // Guardar el detalle de la transacción en la base de datos
        $transactionDetail->save();

        // Agregar dd para verificar los detalles después de guardar
        dd($transactionDetail); // Este dd debería mostrar los detalles después de guardarlos en la base de datos
    }
}
// Agregar dd para verificar los detalles después de guardar
    dd(TransactionDetail::all());
        // Confirmar la transacción
        DB::commit();
        
        // Redireccionar al índice de transacciones con un mensaje de éxito
        return redirect()->route('transactions.index')->with('success', '¡Transacción creada con éxito!');
    } catch (\Exception $e) {
        // Si ocurre algún error, deshacemos la transacción y mostramos un mensaje de error
        DB::rollBack();
        dd($e->getMessage()); // Agrega esta línea para mostrar el mensaje de error
        return back()->withInput()->withErrors(['error' => 'Error al guardar la transacción.']);
    }
}





private function saveTransactionDetails(Transaction $transaction, $details)
{
    // Agregar dd para verificar los detalles recibidos
    dd($details);

    // Verificar si se recibieron los detalles
    if (isset($details['item_name']) && isset($details['quantity']) && isset($details['unit_price'])) {
        // Obtener los detalles de los arreglos
        $itemNames = $details['item_name'];
        $quantities = $details['quantity'];
        $unitPrices = $details['unit_price'];

        // Verificar si los arreglos tienen la misma cantidad de elementos
        if (count($itemNames) === count($quantities) && count($quantities) === count($unitPrices)) {
            // Iterar sobre los detalles de la transacción y guardarlos en la base de datos
            foreach ($itemNames as $index => $itemName) {
                // Crear una nueva instancia de TransactionDetail
                $transactionDetail = new TransactionDetail();

                // Establecer los atributos de TransactionDetail
                $transactionDetail->transaction_id = $transaction->id;
                $transactionDetail->item_name = $itemName;
                $transactionDetail->quantity = $quantities[$index];
                $transactionDetail->unit_price = $unitPrices[$index];

                // Guardar el detalle de la transacción en la base de datos
                $transactionDetail->save();

                // Registro de depuración
                \Log::info('Detalle de transacción guardado:', [
                    'transaction_id' => $transaction->id,
                    'item_name' => $itemName,
                    'quantity' => $quantities[$index],
                    'unit_price' => $unitPrices[$index],
                ]);

                // Agregar dd para verificar los datos antes de guardar
                dd('Detalle guardado:', $transactionDetail);
            }
        } else {
            // Si los arreglos no tienen la misma cantidad de elementos
            dd('Los arreglos de detalles no tienen la misma longitud:', count($itemNames), count($quantities), count($unitPrices));
        }
    } else {
        // Si los detalles no están presentes o incompletos
        dd('Los detalles no están presentes o incompletos:', $details);
    }
}


// Actualizar una transacción específica en la base de datos
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

    // Actualiza los campos de la transacción
    $transaction->amount = $request->input('amount');
    $transaction->category = $request->input('category');
    $transaction->transfer_type = $request->input('transfer_type');
    $transaction->date = $request->input('date');

    // Guarda los cambios en la base de datos
    $transaction->save();

    // Redirecciona de vuelta a la página de transacciones con un mensaje de éxito
    return redirect('/transactions')->with('success', 'Transacción actualizada exitosamente.');
}



    public function show($id)
{
    // Encuentra la transacción por su ID junto con los detalles asociados
    $transaction = Transaction::with('details')->findOrFail($id);
    $details = $transaction->details; // Recuperar los detalles asociados a la transacción

    // Retornar la vista para mostrar la transacción y sus detalles
    return view('show', compact('transaction', 'details'));
}

    // Mostrar el formulario para editar una transacción
    public function edit($id) 
    {
        $transaction = Transaction::find($id);
        $details = TransactionDetail::where('transaction_id', $transaction->id)->get(); 

        return view('edit', ['transaction' => $transaction, 'details' => $details]);
    }

    // Eliminar una transacción 
    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect('/transactions')->with('success', '¡Transacción eliminada con éxito!');
    }
}
