<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Home</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand">SPS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Bem-vindo ao Sistema Positivo de Saude</h1>
                <p class="lead">Realize seu login para começar a utilizar.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="../home/home.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail institucional:</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center mt-5">
                <p>Esqueci minha senha. <a href="forgotPassword.php">Clique aqui</a></p>
            </div>
        </div>
    </div>

    <?php
        include('../modelo/footer.php');
    ?>
</body>

</html>