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
                    <div class="form-group">
                        <label for="amount">Cantidad:</label>
                        <input type="text" name="amount" id="amount" class="form-control" value="{{ $transaction->amount }}">
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría:</label>
                        <input type="text" name="category" id="category" class="form-control" value="{{ $transaction->category }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>



