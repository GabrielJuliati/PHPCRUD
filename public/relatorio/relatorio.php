<?php
session_start();

require_once(__DIR__ . '/controller/RelatorioController.php');

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

$editar = false;
$editar_id = $editar_nome = $editar_tipo_exame = $editar_data_exame = '';

if (isset($_GET['editar_id'])) {
    $editar = true;
    $id = (int)$_GET['editar_id'];
    $registro = RelatorioController::getEdicao($id);
    if ($registro) {
        $editar_id = $registro['id'];
        $editar_nome = $registro['nome_paciente'];
        $editar_tipo_exame = $registro['tipo_exame'];
        $editar_data_exame = $registro['data_exame'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    RelatorioController::handleRequest();

    // Redireciona para o próprio arquivo relatorio.php dentro da pasta relatorio
    header("Location: relatorio.php");
    exit;
}

$registros = RelatorioController::listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Relatórios</title>

    <link href="../CSS/styleCP.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include('../../modelo/nav.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo à tela dos relatórios</h1>

        <div class="container mt-3 mb-5">
            <?php if ($mensagem) : ?>
                <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
            <?php endif; ?>

            <!-- Formulário de adicionar -->
            <?php if (!$editar) : ?>
                <form method="POST" action="relatorio.php" class="row g-2 align-items-center mb-4">
                    <div class="col-md-4">
                        <input type="text" name="nome" class="form-control" placeholder="Nome do Paciente" required />
                    </div>
                    <div class="col-md-4">
                        <select name="tipo_exame" class="form-select" required>
                            <option value="" disabled selected>Selecione o tipo de exame</option>
                            <option value="Dengue">Dengue</option>
                            <option value="ABO Tipo Sanguíneo">ABO Tipo Sanguíneo</option>
                            <option value="COVID-19">COVID-19</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="data_exame" class="form-control" required />
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="adicionar_relatorio" class="btn btn-primary w-100">Adicionar</button>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Formulário de editar -->
            <?php if ($editar) : ?>
                <h2>Editar Relatório</h2>
                <form method="POST" action="relatorio.php" class="row g-2 align-items-center mb-4">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editar_id) ?>" />
                    <div class="col-md-4">
                        <input type="text" name="nome" class="form-control" placeholder="Nome do Paciente" required value="<?= htmlspecialchars($editar_nome) ?>" />
                    </div>
                    <div class="col-md-4">
                        <select name="tipo_exame" class="form-select" required>
                            <option value="" disabled>Selecione o tipo de exame</option>
                            <option value="Dengue" <?= $editar_tipo_exame == 'Dengue' ? 'selected' : '' ?>>Dengue</option>
                            <option value="ABO Tipo Sanguíneo" <?= $editar_tipo_exame == 'ABO Tipo Sanguíneo' ? 'selected' : '' ?>>ABO Tipo Sanguíneo</option>
                            <option value="COVID-19" <?= $editar_tipo_exame == 'COVID-19' ? 'selected' : '' ?>>COVID-19</option>
                            <option value="Outro" <?= $editar_tipo_exame == 'Outro' ? 'selected' : '' ?>>Outro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="data_exame" class="form-control" required value="<?= htmlspecialchars($editar_data_exame) ?>" />
                    </div>
                    <div class="col-md-1 d-flex gap-2">
                        <button type="submit" name="atualizar_relatorio" class="btn btn-success">Salvar</button>
                        <a href="relatorio.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Tabela de relatórios -->
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Paciente</th>
                        <th>Tipo de Exame</th>
                        <th>Data do Exame</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($registros) : ?>
                        <?php foreach ($registros as $row) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['nome_paciente']) ?></td>
                                <td><?= htmlspecialchars($row['tipo_exame']) ?></td>
                                <td><?= htmlspecialchars($row['data_exame']) ?></td>
                                <td>
                                    <a href="relatorio.php?editar_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                                    <form method="POST" action="relatorio.php" style="display:inline-block;" onsubmit="return confirm('Deseja realmente excluir este relatório?');">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                        <button type="submit" name="excluir_relatorio" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="5">Nenhum registro encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('../../modelo/footer.php'); ?>

</body>

</html>
