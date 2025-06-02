<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <?php
        include('../../modelo/nav.php');
        require_once './controller/AgendamentoController.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
            $id = $_POST['excluir'];
            $agendamentoDao = new AgendamentoDao();
            $agendamentoDao->delete($id);

            header("Location: agendamentos.php");
            exit;
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="col mx-4 mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th> <th>Nome</th> <th>Data Consulta</th> <th>Exame</th> <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                         if($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST"){
                            require_once './controller/AgendamentoController.php';
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