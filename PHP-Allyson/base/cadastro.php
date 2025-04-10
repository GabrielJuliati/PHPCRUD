<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script></script>
    <title>Cadastro</title>
</head>
<body class="row gap-0 bg-info-subtle">
    <div>
        <div class="col"></div>
        <div class="text-center col-5 bg-primary-subtle border border-dark rounded-5 mx-auto p-2 mt-5 mb-5 pt-3 p-3">
            <h2>Login</h2>
            <form action='homeJ.php' class="align-items-center">
                <div class="mb-3">
                    <label for="mail" class="form-label">E-mail institucional:</label><br>
                    <input type="email" id="mail" class="form-control form-control-lg" required><br>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label><br>
                    <input type="password" id="password" class="form-control form-control-lg" required><br>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>

        <div class="text-center col-5 bg-primary-subtle border border-dark rounded-5 mx-auto p-2 mt-5 mb-5 pt-3 p-3">
            <h2>Esqueci minha senha</h2>
            <form action='forgotPassword.php' class="align-items-center">
                <button type="submit" class="btn btn-primary">Recuperar</button>
            </form>
        </div>
        <div class="col"></div>
    </div>
</body>
</html>