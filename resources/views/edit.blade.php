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
                <h1 class="card-title">Editar Transacción</h1>
                <form method="POST" action="/transactions/{{ $transaction->id }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Campos de la transacción principal -->
                    <div class="form-group">
                        <label for="amount">Cantidad:</label>
                        <input type="text" name="amount" id="amount" class="form-control" value="{{ $transaction->amount }}">
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría:</label>
                        <input type="text" name="category" id="category" class="form-control" value="{{ $transaction->category }}">
                    </div>
                    <div class="form-group">
                        <label for="transfer_type">Tipo de Transferencia:</label>
                        <input type="text" name="transfer_type" id="transfer_type" class="form-control" value="{{ $transaction->transfer_type }}">
                    </div>
                    <div class="form-group">
                        <label for="date">Fecha:</label>
                        <input type="text" name="date" id="date" class="form-control" value="{{ $transaction->date }}">
                    </div>

                    <!-- Campos de los detalles de la transacción -->
                    @foreach($details as $detail)
                        <div class="form-group">
                            <label for="item_name_{{ $detail->id }}">Descripción:</label>
                            <input type="text" name="details[{{ $detail->id }}][item_name]" id="item_name_{{ $detail->id }}" class="form-control" value="{{ $detail->item_name }}">
                        </div>
                        <div class="form-group">
                            <label for="quantity_{{ $detail->id }}">Cantidad:</label>
                            <input type="text" name="details[{{ $detail->id }}][quantity]" id="quantity_{{ $detail->id }}" class="form-control" value="{{ $detail->quantity }}">
                        </div>
                        <div class="form-group">
                            <label for="unit_price_{{ $detail->id }}">Precio Unitario:</label>
                            <input type="text" name="details[{{ $detail->id }}][unit_price]" id="unit_price_{{ $detail->id }}" class="form-control" value="{{ $detail->unit_price }}">
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
