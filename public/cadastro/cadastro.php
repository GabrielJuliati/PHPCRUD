<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Cadastro</title>
</head>

<body>
    <?php
      include('../../modelo/nav.php');
    ?>

    <div class="row mt-4">
        <div class="col"></div>
        <div class="col">
            <h2>Cadastro de novos usuários</h2>
            <form action="#" method="post">
                <div class="form-group mt-3">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="form-group mt-3">
                    <label for="mail">Email institucional:</label>
                    <input type="email" class="form-control" id="mail" name="mail" required>
                </div>
                <div class="form-group mt-3">
                    <label for="s">Senha para primeiro acesso:</label>
                    <input type="text" class="form-control" id="s" name="passowrd" required>
                </div>
                <div class="form-group mt-3">
                    <label for="sc">Confirmação da senha:</label>
                    <input type="text" class="form-control" id="sc" name="pyes" required>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </form>
        </div>
        <div class="col"></div>

        <?php
        include('../../modelo/footer.php');
    ?>
</body>

</html>