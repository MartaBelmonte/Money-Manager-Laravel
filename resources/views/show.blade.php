<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Transacción</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Detalles de la Transacción</h1>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $transaction->id }}</p>
                        <p><strong>Fecha:</strong> {{ $transaction->date }}</p>
                        <p><strong>Cantidad:</strong> {{ $transaction->amount }}</p>
                        <p><strong>Categoría:</strong> {{ $transaction->category }}</p>
                        <p><strong>Tipo de Transferencia:</strong> {{ $transaction->transfer_type }}</p>
                        <h2 class="card-title">Desglose transacciones</h2>
                        @foreach($transaction->details as $detail)
                        <h5><strong>Descripción producto:</strong> {{ $detail->item_name }}</h5>
                        <p><strong>Cantidad de productos:</strong> {{ $detail->quantity }}</p>
                        <p><strong>Precio Unitario:</strong> {{ $detail->unit_price }}</p>
                         @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>                  
</body>
</html>
