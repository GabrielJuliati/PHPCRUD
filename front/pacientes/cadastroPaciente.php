<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Cadastro de Pacientes</title>
</head>

<body style="overflow-x: hidden">
    <?php
      include('../modelo/nav.php');
    ?>
    <div class="row mt-4">
        <div class="col"></div>
        <div class="col">
            <h2>Cadastro de Pacientes</h2>
            <form action="cadastroPaciente.php" method="post">
                <div class="form-group mt-3">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="form-group mt-3">
                    <label for="nascimento">Data de nascimento:</label>
                    <input type="date" class="form-control" id="nascimento" name="nascimento" required>
                </div>
                <div class="form-group mt-3">
                    <label for="endereco">Endereço:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
                <div class="form-group mt-3">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" required>
                </div>
                <div class="form-group mt-3">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required>
                </div>
                <div class="form-group mt-3">
                    <label for="nomeMae">Nome da mãe:</label>
                    <input type="text" class="form-control" id="nomeMae" name="nomeMae" required>
                </div>
                <div class="form-group mt-3">
                    <label>Tipo sanguineo:</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="A+" class="form-check-input me-2">
                    <label for="A+" class="form-check-label">A+</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="A-" class="form-check-input me-2">
                    <label for="A-" class="form-check-label">A-</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="B+" class="form-check-input me-2">
                    <label for="B+" class="form-check-label">B+</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="B-" class="form-check-input me-2">
                    <label for="B-" class="form-check-label">B-</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="O+" class="form-check-input me-2">
                    <label for="O+" class="form-check-label">O+</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="O-" class="form-check-input me-2">
                    <label for="O-" class="form-check-label">O-</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="AB+" class="form-check-input me-2">
                    <label for="AB+" class="form-check-label">AB+</label>
                    <br>
                    <input type="radio" id="tipoSangue" name="tipoSangue" value="AB-" class="form-check-input me-2">
                    <label for="AB-" class="form-check-label">AB-</label>
                </div>
                <div class="form-group mt-3">
                    <label for="observacoes">Observações do paciente:</label>
                    <textarea type="text" class="form-control" id="observacoes" name="observacoes" required></textarea>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
        <div class="col"></div>

        <?php
            include('../modelo/footer.php');
        ?>
    </div>
</body>

</html>