<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Transacción</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center card-title">Editar Transacción</h1>
                <form method="POST" action="/transactions/{{ $transaction->id }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Campos de la transacción principal -->
                    <div class="form-group">
                        <label for="amount">Cantidad:</label>
                        <input type="text" name="amount" id="amount" class="form-control" value="{{ $transaction->amount }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="ocio" {{ $transaction->category == 'ocio' ? 'selected' : '' }}>Ocio</option>
                            <option value="trabajo" {{ $transaction->category == 'trabajo' ? 'selected' : '' }}>Trabajo</option>
                            <option value="hosteleria" {{ $transaction->category == 'hosteleria' ? 'selected' : '' }}>Hosteleria</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="transfer_type">Tipo de Transferencia:</label>
                        <select name="transfer_type" id="transfer_type" class="form-control">
                            <option value="transferencia_bancaria" {{ $transaction->transfer_type == 'transferencia_bancaria' ? 'selected' : '' }}>Transferencia Bancaria</option>
                            <option value="tarjeta_de_credito" {{ $transaction->transfer_type == 'tarjeta_de_credito' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                            <option value="efectivo" {{ $transaction->transfer_type == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Fecha:</label>
                        <input type="text" name="date" id="date" class="form-control" value="{{ $transaction->date }}" readonly>
                    </div>

                    <!-- Campos de los detalles de la transacción -->
                    @foreach($details as $detail)
                        <div class="form-group">
                            <label for="item_name_{{ $detail->id }}">Descripción:</label>
                            <input type="text" name="details[{{ $detail->id }}][item_name]" id="item_name_{{ $detail->id }}" class="form-control" value="{{ $detail->item_name }}">
                        </div>
                        <div class="form-group">
                            <label for="quantity_{{ $detail->id }}">Cantidad:</label>
                            <input type="number" name="details[{{ $detail->id }}][quantity]" id="quantity_{{ $detail->id }}" class="form-control" value="{{ $detail->quantity }}">
                        </div>
                        <div class="form-group">
                            <label for="unit_price_{{ $detail->id }}">Precio Unitario:</label>
                            <input type="number" name="details[{{ $detail->id }}][unit_price]" id="unit_price_{{ $detail->id }}" class="form-control" value="{{ $detail->unit_price }}">
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
