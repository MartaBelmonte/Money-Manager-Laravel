<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Transacciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Lista de Transacciones Realizadas</h1>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Crear Transacción</a>
                @if(count($transactions) > 0)
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha de Transacción</th>
                                    <th>Cantidad Total</th>
                                    <th>Categoría</th>
                                    <th>Tipo de Transferencia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>
                                            @if ($transaction->date instanceof DateTime)
                                                {{ $transaction->date->format('Y-m-d') }}
                                            @else
                                                {{ $transaction->date }}
                                            @endif
                                        </td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->category }}</td>
                                        <td>{{ $transaction->transfer_type }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="actionsDropdown{{ $transaction->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Acciones
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionsDropdown{{ $transaction->id }}">
                                                    <li><a class="dropdown-item" href="{{ route('transactions.show', $transaction->id) }}">Ver Detalles</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('transactions.edit', $transaction->id) }}">Editar</a></li>
                                                    <li>
                                                        <form action="{{ route('transactions.delete', $transaction->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No hay transacciones disponibles.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    
</script>
</body>
</html>
