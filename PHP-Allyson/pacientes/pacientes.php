<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleP.css">
    <title>Cadastro de Pacientes</title>
</head>

<body>
    <?php
      include('../modelo/nav.php');
    ?>
    <div class="row mt-4">
        <div class="col"></div>
        <div class="col">
            <h2>Cadastro de Pacientes</h2>
            <form action="salvar_paciente.php" method="post">
                <div class="form-group mt-3">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="form-group mt-3">
                    <label for="nascimento">Data de nascimento:</label>
                    <input type="text" class="form-control" id="nascimento" name="nascimento">
                </div>
                <div class="form-group mt-3">
                    <label for="endereco">Endereço:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco">
                </div>
                <div class="form-group mt-3">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone">
                </div>
                <div class="form-group mt-3">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf">
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
        <div class="col"></div>
    </div>
</body>

</html>