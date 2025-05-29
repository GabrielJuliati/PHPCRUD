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
    <script>
    function validarSenha() {
        var senha = document.getElementById("s").value;
        var confirmarSenha = document.getElementById("sc").value;

        if (senha != confirmarSenha) {
            alert("Erro: As senhas não são iguais!");
            return false;
        }
        alert("Cadastro realizado com sucesso!");
        return true;
    }
</script>
</head>

<body style="overflow-x: hidden">
    <?php
    include('../../modelo/nav.php');
    ?>

    <div class="row mt-4">
        <div class="col"></div>
        <div class="col">
            <h2>Cadastro de novos usuários</h2>
            <form action="../acesso/controller/usuarioController.php" method="post" onsubmit="return validarSenha()">
                <label class="mt-3">O usuario sera um professor ou um aluno?</label>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="radio" name="tipoUsuario" id="aluno" value="DEFAULT" checked>
                    <label class="form-check-label" for="aluno">Aluno(Sem acesso administrador)</label>
                </div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="radio" name="tipoUsuario" id="professor" value="ADM">
                    <label class="form-check-label" for="professor">Professor(Com acesso administrador)</label>
                </div>

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
                    <input type="text" class="form-control" id="s" name="password" pattern=".{8,}" title="A senha deve ter pelo menos 8 caracteres" required>
                </div>
                <div class="form-group mt-3">
                    <label for="sc">Confirmação da senha:</label>
                    <input type="text" class="form-control" id="sc" name="pyes" pattern=".{8,}" title="A senha deve ter pelo menos 8 caracteres" required>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" name="cadastrar" class="btn btn-primary">Criar</button>
                </div>
            </form>
        </div>
        <div class="col"></div>

        <?php
        include('../../modelo/footer.php');
        ?>
    </div>
</body>

</html>