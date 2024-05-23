<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacción Guardada</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Transacción Guardada</h1>
                <div class="alert alert-success" role="alert">
                    ¡La transacción se ha guardado correctamente!
                </div>
                <p>¿Qué deseas hacer a continuación?</p>
                <a href="{{ route('transactions.index') }}" class="btn btn-primary">Volver a la lista de transacciones</a>
                <a href="{{ route('transactions.create') }}" class="btn btn-success">Realizar otra transacción</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
