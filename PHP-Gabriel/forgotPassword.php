<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Password recover</title>
</head>
<body class="row gap-0 bg-info-subtle">
    <div>
        <div class="col"></div>
        <div class="text-center col-5 bg-primary-subtle border border-dark rounded-5 mx-auto p-2 mt-5 mb-5 pt-3 p-3">
            <h2>Password recover</h2>
            <form action="" class="align-items-center">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label><br>
                    <input type="text" id="email" class="form-control form-control-lg" required><br>
                </div>
                <div class="mb-3">
                    <label for="csus" class="form-label">Cartão do SUS:</label><br>
                    <input type="text" id="csus" class="form-control form-control-lg" required><br>
                </div>
                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF:</label><br>
                    <input type="text" id="cpf" class="form-control form-control-lg" required><br>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
        <div class="col"></div>
    </div>
</body>
</html>