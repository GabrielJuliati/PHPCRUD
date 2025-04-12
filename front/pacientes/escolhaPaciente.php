<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Home</title>
</head>

<body style="overflow-x: hidden">
    <?php
      include('../modelo/nav.php');
    ?>
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <h1>Escolha a opção desejada</h1>
        </div>
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center align-items-center mt-5">

            <div class="col-md-4 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cadastrar</h5>
                        <p class="card-text">Cadastre novos pacientes.</p>
                        <a href="cadastroPaciente.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Editar</h5>
                        <p class="card-text">Edite o cadastro de pacientes.</p>
                        <a href="gestaoPaciente.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
        include('../modelo/footer.php');
    ?>
</body>

</html>