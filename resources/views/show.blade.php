<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Transacción</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="container mt-3">
            <div class="row justify-content-between">
                <div class="col-md-9"></div>
                <div class="col-md-3 justify-content-end">
                    <button onclick="printPDF()" class="btn btn-primary btn-block">
                        <i class="fas fa-download mr-2"></i> Descargar en PDF
                    </button>
                </div>
            </div>
        </div>
        <h1 class="text-center mb-4">Detalles de la Transacción</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>ID:</strong> {{ $transaction->id }}</p>
                        <p><strong>Fecha:</strong> {{ $transaction->date }}</p>
                        <p><strong>Cantidad:</strong> {{ $transaction->amount }}</p>
                        <p><strong>Categoría:</strong> {{ $transaction->category }}</p>
                        <p><strong>Tipo de Transferencia:</strong> {{ $transaction->transfer_type }}</p>
                        <div class="bg-light p-4 rounded mt-5 mb-5"> 
                            <h3 class="text-center mb-3">Desglose transacciones</h3>
                            @if ($details->isNotEmpty())
                                <ul class="list-group list-group-flush"> 
                                    @foreach($details as $detail)
                                        <li class="list-group-item">
                                            <p><strong>Descripción producto:</strong> {{ $detail->item_name }}</p>
                                            <p><strong>Cantidad de productos:</strong> {{ $detail->quantity }}</p>
                                            <p><strong>Precio Unitario:</strong> {{ $detail->unit_price }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-center">No hay detalles disponibles para esta transacción.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printPDF() {
            window.print(); 
        }
    </script>
</body>
</html>
