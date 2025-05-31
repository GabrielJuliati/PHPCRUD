<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>