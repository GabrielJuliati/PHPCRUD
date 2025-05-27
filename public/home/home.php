<?php session_start(); ?>

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
    <?php
    include('../../modelo/nav.php');
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Bem-vindo
                    <?php
                    if (isset($_SESSION["nome"])) {
                        echo $_SESSION["nome"];
                    } else {
                        echo "Nenhum nome encontrado.";
                    }
                    ?>
                </h1>
                <p class="lead">Gerencie pacientes, agendamentos e relatórios de forma eficiente.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pacientes</h5>
                        <p class="card-text">Gerencie o cadastro de pacientes.</p>
                        <a href="../pacientes/escolhaPaciente.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Agendamentos</h5>
                        <p class="card-text">Agende consultas e procedimentos.</p>
                        <a href="../agendamento/agendamento.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Relatórios</h5>
                        <p class="card-text">Gere relatórios de atendimentos.</p>
                        <a href="../relatorio/relatatorio.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>

            <?php
            if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 'ADM') {
                include('admHome.php');
            }
            ?>
        </div>
    </div>

    <?php
    include('../../modelo/footer.php');
    ?>
</body>

</html>