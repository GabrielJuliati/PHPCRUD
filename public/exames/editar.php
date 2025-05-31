<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Editar Exame</title>
</head>
<body>
    
    <?php
      include('../../modelo/nav.php');
    ?>

    <?php
        require_once './controller/ExamesController.php';

        $examesParaEditar = null;
        if (isset($_GET['editar'])) {
            $id = $_GET['editar'];
            $examesDao = new ExamesDao();
            $examesParaEditar = $examesDao->buscarPorId($id);
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Exame</h1>
                <div>
                    <form method="POST" action="controller/ExamesController.php">
                        <input type="hidden" name="id" value="<?= $examesParaEditar ? $examesParaEditar->getId() : '' ?>">

                        <div class="mb-3 text-center">
                            <label>Nome:</label>
                            <input type="text" name="nome_exame" class="form-control" required
                                value="<?= $examesParaEditar ? $examesParaEditar->getNomeExame() : '' ?>">
                        </div>

                        <div class="mb-3 text-center">
                            <label>Descrição:</label>
                            <input type="text" name="descricao" class="form-control" required
                                value="<?= $examesParaEditar ? $examesParaEditar->getDescricao() : '' ?>">
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" name="atualizar" class="btn btn-success">
                                Enviar
                            </button>
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