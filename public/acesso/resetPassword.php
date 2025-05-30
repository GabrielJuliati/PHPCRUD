<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Cadastro</title>
</head>

<body style="overflow-x: hidden">
    <?php
    include('../../modelo/nav.php');
    ?>

    <div class="row mt-4">
        <div class="col"></div>
        <div class="col mt-5">

            <?php if (isset($_SESSION['sucesso'])) { ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['sucesso'];
                    unset($_SESSION['sucesso']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['erro'])) { ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['erro'];
                    unset($_SESSION['erro']); ?>
                </div>
            <?php } ?>

            <h2>Troca de senha.</h2>
            <form action="controller/usuarioController.php" method="post">
                <div class="form-group mt-3">
                    <label for="sa">Senha atual:</label>
                    <input type="text" class="form-control" id="sa" name="passwordAtual" pattern=".{8,}" title="A senha deve ter pelo menos 8 caracteres" required>
                </div>
                <div class="form-group mt-3">
                    <label for="s">Nova senha:</label>
                    <input type="text" class="form-control" id="s" name="password" pattern=".{8,}" title="A senha deve ter pelo menos 8 caracteres" required>
                </div>
                <div class="form-group mt-3">
                    <label for="sc">Confirmação da senha:</label>
                    <input type="text" class="form-control" id="sc" name="pyes" pattern=".{8,}" title="A senha deve ter pelo menos 8 caracteres" required>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" name="alterar" class="btn btn-primary">Alterar</button>
                </div>
            </form>
        </div>
        <div class="col"></div>
    </div>

    <?php
    include('../../modelo/footer.php');
    ?>
</body>

</html>