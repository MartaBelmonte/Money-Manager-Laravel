<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Transacción</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Crear Transacción</h1>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>¡Ups! Hubo algunos problemas con tus datos:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="amount">Cantidad:</label>
                    <input type="text" id="amount" name="amount" value="{{ old('amount') }}" class="form-control" required>
                    <div id="amount-error" class="text-danger d-none">Por favor, introduce solo números.</div>
                </div>

                <div class="form-group">
                    <label for="category">Categoría:</label>
                    <div class="dropdown">
                        <input type="text" id="category" name="category" value="{{ old('category') }}" class="form-control dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                        <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <a class="dropdown-item" href="#" onclick="setValue('Trabajo')">Trabajo</a>
                            <a class="dropdown-item" href="#" onclick="setValue('Ocio')">Ocio</a>
                            <a class="dropdown-item" href="#" onclick="setValue('Otros')">Otros</a>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fullname">Nombre Completo:</label>
                    <input type="text" id="fullname" name="fullname" value="{{ old('fullname') }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="transfer_type">Tipo de Transferencia:</label>
                    <div class="dropdown">
                        <input type="text" id="transfer_type" name="transfer_type" value="{{ old('transfer_type') }}" class="form-control dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                        <div class="dropdown-menu" aria-labelledby="transferTypeDropdown">
                            <a class="dropdown-item" href="#" onclick="setTransferType('Transferencia ordinaria')">Transferencia ordinaria</a>
                            <a class="dropdown-item" href="#" onclick="setTransferType('Transferencia urgente')">Transferencia urgente</a>
                            <a class="dropdown-item" href="#" onclick="setTransferType('Transferencia inmediata')">Transferencia inmediata</a>
                            <a class="dropdown-item" href="#" onclick="setTransferType('Transferencia programada')">Transferencia programada</a>
                        </div>
                    </div>
                </div>

                <button id="submit-btn" type="submit" class="btn btn-primary">Crear transacción</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS y jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Función para establecer el valor del campo de categoría
    function setValue(value) {
        document.getElementById('category').value = value;
    }

    // Función para establecer el valor del campo de tipo de transferencia
    function setTransferType(value) {
        document.getElementById('transfer_type').value = value;
    }

    // Escuchar el evento clic fuera del input de categoría para ocultar las opciones del dropdown
    document.addEventListener('click', function(event) {
        var categoryInput = document.getElementById('category');
        var categoryDropdown = document.querySelector('.category-dropdown');
        if (!categoryInput.contains(event.target)) {
            categoryDropdown.classList.remove('show');
        }
    });

    // Escuchar el evento clic en el input de categoría para mostrar u ocultar las opciones del dropdown
    var categoryDropdown = document.querySelector('.category-dropdown');
    document.getElementById('category').addEventListener('click', function() {
        if (categoryDropdown.classList.contains('show')) {
            categoryDropdown.classList.remove('show');
        } else {
            categoryDropdown.classList.add('show');
        }
    });

    // Escuchar el evento clic fuera del input de tipo de transferencia para ocultar las opciones del dropdown
    document.addEventListener('click', function(event) {
        var transferTypeInput = document.getElementById('transfer_type');
        var transferTypeDropdown = document.querySelector('.transfer-type-dropdown');
        if (!transferTypeInput.contains(event.target)) {
            transferTypeDropdown.classList.remove('show');
        }
    });

    // Escuchar el evento clic en el input de tipo de transferencia para mostrar u ocultar las opciones del dropdown
    var transferTypeDropdown = document.querySelector('.transfer-type-dropdown');
    document.getElementById('transfer_type').addEventListener('click', function() {
        if (transferTypeDropdown.classList.contains('show')) {
            transferTypeDropdown.classList.remove('show');
        } else {
            transferTypeDropdown.classList.add('show');
        }
    });
</script>
</body>
</html>