<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Transaction</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Create Transaction</h1>
                
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
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount') }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Transaction</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

