<?php session_start(); 

    if (!isset($_SESSION["id"])) {
        header("Location: ../acesso/login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Cadastrar Agendamento</title>
</head>
<body>
    
    <?php
      include('../../modelo/nav.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Agendamento</h1>
                <div>
                    <form action="controller/AgendamentoController.php" method="post">
                        <div class="mt-3 text-center">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>
                        <div class="mt-3 text-center">
                            <label for="data_consulta" class="form-label">Data do Exame:</label>
                            <input type="date" name="data_consulta" id="data_consulta" class="form-control" required>
                        </div>
                        <div class="mt-3 text-center">
                            <label for="tipo_exame" class="form-label">Tipo do Exame:</label>
                            <select id="tipo_exame" name="tipo_exame" class="form-select" required>
                                <option value="ABO - Tipo Sanguíneo">ABO - Tipo Sanguíneo</option>
                                <option value="Dengue">Dengue</option>
                                <option value="COVID 19">COVID 19</option>
                            </select>
                        </div>
                        <div class="mt-3 text-center">
                            <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
    <?php
        include('../../modelo/footer.php');
    ?>

</body>
</html>