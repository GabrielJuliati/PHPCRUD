<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Cadastrar Exame</title>
</head>
<body>
    
    <?php
      include('../../modelo/nav.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Exame</h1>
                <div>
                    <form action="controller/ExamesController.php" method="post">
                        <div class="mt-3 text-center">
                            <label for="nome_exame" class="form-label">Nome do Exame</label>
                            <input type="text" name="nome_exame" id="nome_exame" class="form-control" required>
                        </div>
                        <div class="mt-3 text-center">
                            <label for="descricao">Descrição do Exame</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" required>
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