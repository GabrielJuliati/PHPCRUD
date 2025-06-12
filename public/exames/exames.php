<?php session_start(); 

    if (!isset($_SESSION["id"])) {
        header("Location: ../acesso/login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Exames</title>
</head>

<body>

    <?php
        include('../../modelo/nav.php');
        require_once './controller/ExamesController.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
            $id = $_POST['excluir'];
            $examesDao = new ExamesDao();
            $examesDao->delete($id);

            header("Location: exames.php");
            exit;
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="col mx-4 mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th> <th>Nome do Exame</th> <th>Descrição</th> <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                         if($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST"){
                            require_once './controller/ExamesController.php';
                            listar();
                         }
                         ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <?php
        include('../../modelo/footer.php');
    ?>
</body>
</html>