<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Transacción</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Crear Nueva Transacción</h1>
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Monto:</label>
                        <input type="text" name="amount" id="amount" class="form-control" value="{{ old('amount') }}">
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría:</label>
                        <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}">
                    </div>
                    <div class="form-group">
                        <label for="transfer_type">Tipo de Transferencia:</label>
                        <input type="text" name="transfer_type" id="transfer_type" class="form-control" value="{{ old('transfer_type') }}">
                    </div>
                    <div id="details">
                        <!-- Detalles de la transacción -->
                    </div>
                    <button type="button" id="addDetail" class="btn btn-primary">Agregar Detalle</button>
                    <button type="submit" class="btn btn-success">Guardar Transacción</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addDetailButton = document.getElementById('addDetail');
            const detailsContainer = document.getElementById('details');

            addDetailButton.addEventListener('click', function () {
                const detail = `
                    <div class="form-row mt-3">
                        <div class="col">
                            <input type="text" name="item_name[]" class="form-control" placeholder="Nombre del ítem">
                        </div>
                        <div class="col">
                            <input type="number" name="quantity[]" class="form-control" placeholder="Cantidad" value="Cantidad producto">
                        </div>
                        <div class="col">
                            <input type="number" name="unit_price[]" class="form-control" placeholder="Precio Unitario" value="Importe">
                        </div>
                    </div>
                `;
                detailsContainer.insertAdjacentHTML('beforeend', detail);
                updateTotalAmount();
            });

            detailsContainer.addEventListener('input', function () {
                updateTotalAmount();
            });

            function updateTotalAmount() {
                let totalAmount = 0;
                const unitPrices = document.querySelectorAll('input[name="unit_price[]"]');
                const quantities = document.querySelectorAll('input[name="quantity[]"]');
                unitPrices.forEach((unitPrice, index) => {
                    const quantity = parseInt(quantities[index].value);
                    const price = parseFloat(unitPrice.value);
                    if (!isNaN(quantity) && !isNaN(price)) {
                        totalAmount += quantity * price;
                    }
                });
                document.getElementById('amount').value = totalAmount.toFixed(2);
            }
        });
    </script>
</body>
</html>
