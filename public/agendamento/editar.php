<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Editar Agendamento</title>
</head>
<body>
    
    <?php
      include('../../modelo/nav.php');
    ?>

    <?php
        require_once './controller/AgendamentoController.php';

        $agendamentoParaEditar = null;
        if (isset($_GET['editar'])) {
            $id = $_GET['editar'];
            $agendamentoDao = new AgendamentoDao();
            $agendamentoParaEditar = $agendamentoDao->buscarPorId($id);
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Agendamento</h1>
                <div>
                    <form method="POST" action="controller/AgendamentoController.php">
                        <input type="hidden" name="id" value="<?= $agendamentoParaEditar ? $agendamentoParaEditar->getId() : '' ?>">

                        <div class="mb-3 text-center">
                            <label>Nome:</label>
                            <input type="text" name="nome" class="form-control" required
                                value="<?= $agendamentoParaEditar ? $agendamentoParaEditar->getNome() : '' ?>">
                        </div>

                        <div class="mb-3 text-center">
                            <label>Data da Consulta:</label>
                            <input type="date" name="data_consulta" class="form-control" required
                                value="<?= $agendamentoParaEditar ? $agendamentoParaEditar->getDataConsulta() : '' ?>">
                        </div>

                        <div class="mt-3 text-center">
                            <label for="tipo_exame" class="form-label">Tipo do Exame:</label>
                            <select id="tipo_exame" name="tipo_exame" class="form-select" required>
                                <option value="ABO - Tipo Sanguíneo">ABO - Tipo Sanguíneo</option>
                                <option value="Dengue">Dengue</option>
                                <option value="COVID 19">COVID 19</option>
                            </select>
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" name="<?= $agendamentoParaEditar ? 'atualizar' : 'cadastrar' ?>" class="btn btn-success">
                                <?= $agendamentoParaEditar ? 'Atualizar' : 'Cadastrar' ?>
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