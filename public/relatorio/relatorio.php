<?php
session_start();

require_once(__DIR__ . '/controller/RelatorioController.php');

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

$editar = false;
$editar_id = $editar_nome = $editar_tipo_exame = $editar_data_exame = $editar_resultado = $editar_observacao = '';

if (isset($_GET['editar_id'])) {
    $editar = true;
    $id = (int)$_GET['editar_id'];
    $registro = RelatorioController::getEdicao($id);
    if ($registro) {
        $editar_id = $registro['id'];
        $editar_nome = $registro['nome_paciente'];
        $editar_tipo_exame = $registro['tipo_exame'];
        $editar_data_exame = $registro['data_exame'];
        $editar_resultado = $registro['resultado'];
        $editar_observacao = $registro['observacao'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    RelatorioController::handleRequest();

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
                <div class="d-flex justify-content-center">
                    <form method="POST" action="relatorio.php" class="row g-2 align-items-center mb-4 mx-auto" style="max-width: 900px;">
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
                        <div class="col-md-2">
                            <input type="date" name="data_exame" class="form-control" required />
                        </div>
                        <div class="col-md-2">
                            <select name="resultado" class="form-select" required>
                                <option value="" disabled selected>Resultado</option>
                                <option value="Positivado">Positivado</option>
                                <option value="Negativado">Negativado</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <textarea name="observacao" class="form-control" placeholder="Observação (opcional)"></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-center mt-2">
                            <button type="submit" name="adicionar_relatorio" class="btn btn-primary">Adicionar</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Formulário de editar -->
            <?php if ($editar) : ?>
                <h2 class="text-center mb-4">Editar Relatório</h2>
                <div class="d-flex justify-content-center">
                    <form method="POST" action="relatorio.php" class="row g-2 align-items-center mb-4 mx-auto" style="max-width: 900px;">
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
                        <div class="col-md-2">
                            <input type="date" name="data_exame" class="form-control" required value="<?= htmlspecialchars($editar_data_exame) ?>" />
                        </div>
                        <div class="col-md-2">
                            <select name="resultado" class="form-select" required>
                                <option value="" disabled>Resultado</option>
                                <option value="Positivado" <?= $editar_resultado == 'Positivado' ? 'selected' : '' ?>>Positivado</option>
                                <option value="Negativado" <?= $editar_resultado == 'Negativado' ? 'selected' : '' ?>>Negativado</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <textarea name="observacao" class="form-control" placeholder="Observação (opcional)"><?= htmlspecialchars($editar_observacao) ?></textarea>
                        </div>
                        <div class="col-md-3 mt-2 d-flex gap-2">
                            <button type="submit" name="atualizar_relatorio" class="btn btn-success flex-grow-1">Salvar</button>
                            <a href="relatorio.php" class="btn btn-secondary flex-grow-1 text-center">Cancelar</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Tabela de relatórios -->
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Paciente</th>
                        <th>Tipo de Exame</th>
                        <th>Data do Exame</th>
                        <th>Resultado</th>
                        <th>Observação</th>
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
                                <td><?= htmlspecialchars($row['resultado']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['observacao'])) ?></td>
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
                        <tr><td colspan="7">Nenhum registro encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('../../modelo/footer.php'); ?>

</body>

</html>
