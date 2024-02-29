<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Transacción</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Eliminar Transacción</h1>
                <p>¿Estás seguro de que deseas eliminar la transacción con ID {{ $transaction->id }}?</p>
                <form method="POST" action="{{ route('transactions.delete', $transaction->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
                </form>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-2">Cancelar</a>
            </div>
        </div>
    </div>
</body>
</html>


