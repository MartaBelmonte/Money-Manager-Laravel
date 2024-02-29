<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Transacción</title>
</head>
<body>
    <h1>Actualizar Transacción</h1>
    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="amount">Cantidad:</label>
            <input type="text" name="amount" id="amount" value="{{ $transaction->amount }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="category">Categoría:</label>
            <input type="text" name="category" id="category" value="{{ $transaction->category }}" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar transacción</button>
    </form>
</body>
</html>
