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
        return view('index', compact('transactions'));
    }

    // Mostrar el formulario para crear una nueva transacción
    public function create()
    {
        return view('create');
    }

   public function store(Request $request)
{
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


        // Guardar los detalles de la transacción si existen
        if (!empty($request->details)) {
            foreach ($request->details['item_name'] as $index => $itemName) {
                $transactionDetail = new TransactionDetail();
                $transactionDetail->transaction_id = $transaction->id; // Asignar el ID de la transacción principal
                $transactionDetail->item_name = $itemName;
                $transactionDetail->quantity = $request->details['quantity'][$index];
                $transactionDetail->unit_price = $request->details['unit_price'][$index];
                $transactionDetail->save();
            }
        }

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
    // Verificar si se recibieron los detalles
    if (!empty($details)) {
        // Obtener los detalles de los arreglos
        $itemNames = $details['item_name'];
        $quantities = $details['quantity'];
        $unitPrices = $details['unit_price'];

        // Registro de depuración
        \Log::info('Detalles recibidos:', [
            'item_names' => $itemNames,
            'quantities' => $quantities,
            'unit_prices' => $unitPrices,
        ]);

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
            }
        }
    }
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
