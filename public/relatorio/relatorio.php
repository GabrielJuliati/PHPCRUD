<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../acesso/login.php");
    exit;
}

require_once(__DIR__ . "/controller/RelatorioController.php");

$mensagem = $_SESSION["mensagem"] ?? "";
unset($_SESSION["mensagem"]);

$editar = false;
$editar_id = $editar_nome = $editar_cpf = $editar_tipo_exame = $editar_data_exame = $editar_resultado = $editar_observacao = "";

if (isset($_GET["editar_id"])) {
    $editar = true;
    $id = (int)$_GET["editar_id"];
    $registro = RelatorioController::getEdicao($id);
    if ($registro) {
        $editar_id = $registro["id"];
        $editar_nome = $registro["nome_paciente"];
        $editar_cpf = $registro["cpf"];
        $editar_tipo_exame = $registro["tipo_exame"];
        $editar_data_exame = $registro["data_exame"];
        $editar_resultado = $registro["resultado"];
        $editar_observacao = $registro["observacao"];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["adicionar_relatorio"])) {
        RelatorioController::adicionar($_POST);
    } elseif (isset($_POST["atualizar_relatorio"])) {
        RelatorioController::atualizar($_POST);
    } elseif (isset($_POST["excluir_relatorio"])) {
        RelatorioController::excluir($_POST["id"]);
    }

    header("Location: relatorio.php");
    exit;
}

$registros = RelatorioController::listarTodos();

// Função para formatar CPF
function formatarCPF($cpf) {
    // Remove qualquer coisa que não seja número (caso tenha pontos, traço, espaços)
    $cpf = preg_replace("/\\D/", "", $cpf);
    if (strlen($cpf) === 11) {
        return substr($cpf, 0, 3) . "." .
               substr($cpf, 3, 3) . "." .
               substr($cpf, 6, 3) . "-" .
               substr($cpf, 9, 2);
    }
    return $cpf; // Retorna o CPF "cru" caso não tenha 11 dígitos
}

// Função para formatar data
function formatarData($data) {
    if (empty($data)) return "-";
    return date("d/m/Y", strtotime($data));
}

// Variáveis para dados da API Node.js
$paciente_api = null;
$agendamentos_api = [];
$relatorios_api = [];
$cpf_para_busca = "";
$mensagem_api = "";

// Verifica se houve uma submissão para buscar dados via API
if (isset($_GET["buscar_dados_api"]) && !empty($_GET["cpf_busca_api"])) {
    $cpf_para_busca = htmlspecialchars($_GET["cpf_busca_api"]);
    $cpf_limpo = preg_replace("/\\D/", "", $cpf_para_busca); // Limpa o CPF para a API

    // Buscar dados consolidados (paciente, agendamentos e relatórios) por CPF
    $url_api = "http://localhost:3000/api/relatorios/consolidado/" . $cpf_limpo;
    $response = @file_get_contents($url_api);

    if ($response === FALSE) {
        $mensagem_api = "Erro ao conectar com a API Node.js. Verifique se o servidor Node.js está rodando.";
    } else {
        $dados_api = json_decode($response, true);
        if ($dados_api && isset($dados_api["success"]) && $dados_api["success"]) {
            $paciente_api = $dados_api["data"]["paciente"];
            $agendamentos_api = $dados_api["data"]["agendamentos"];
            $relatorios_api = $dados_api["data"]["relatorios"];
        } else {
            $mensagem_api = $dados_api["message"] ?? "Erro ao buscar dados na API Node.js.";
        }
    }
}
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
    <link rel="icon" href="../faviconSPS.png" type="image/x-icon">

    <style>
        .table-responsive {
            overflow-x: auto;
        }

        table {
            table-layout: fixed;
            width: 100%;
        }

        th,
        td {
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
            vertical-align: middle;
        }

        td:nth-child(7) {
            max-width: 250px;
        }
        
        .resultado-pendente {
            color: #6c757d;
            font-style: italic;
        }
        
        .resultado-positivo {
            color: #dc3545;
            font-weight: bold;
        }
        
        .resultado-negativo {
            color: #198754;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include("../../modelo/nav.php"); ?>

    <div class="container-fluid mt-5">
        <h1 class="text-center">Bem-vindo à tela dos relatórios</h1>

        <div class="container mt-3 mb-5">
            <?php if ($mensagem) : ?>
                <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
            <?php endif; ?>

            <!-- Formulário de adicionar -->
            <?php if (!$editar) : ?>
                <div class="d-flex justify-content-center">
                    <form method="POST" action="relatorio.php" style="max-width: 700px; width: 100%;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" name="nome" class="form-control" placeholder="Nome do Paciente" required />
                            </div>
                            <div class="col-md-6">
                                <!-- Limite no HTML para 11 caracteres (sem máscara visual) -->
                                <input type="text" name="cpf" class="form-control" placeholder="CPF do Paciente" maxlength="11" pattern="\\d{11}" title="Digite 11 números" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <select name="tipo_exame" class="form-select" required>
                                    <option value="" disabled selected>Selecione o tipo de exame</option>
                                    <option value="Dengue">Dengue</option>
                                    <option value="ABO Tipo Sanguíneo">ABO Tipo Sanguíneo</option>
                                    <option value="COVID-19">COVID-19</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="data_exame" class="form-control" required />
                            </div>
                            <div class="col-md-4">
                                <select name="resultado" class="form-select" required>
                                    <option value="" disabled selected>Resultado</option>
                                    <option value="Positivado">Positivado</option>
                                    <option value="Negativado">Negativado</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="observacao" class="form-control" placeholder="Observação (opcional)" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="adicionar_relatorio" class="btn btn-primary px-5">Adicionar</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Formulário de editar -->
            <?php if ($editar) : ?>
                <h2 class="text-center mb-4">Editar Relatório</h2>
                <div class="d-flex justify-content-center">
                    <form method="POST" action="relatorio.php" style="max-width: 700px; width: 100%;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($editar_id) ?>" />
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" name="nome" class="form-control" placeholder="Nome do Paciente" required value="<?= htmlspecialchars($editar_nome) ?>" />
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="cpf" class="form-control" placeholder="CPF do Paciente" maxlength="11" pattern="\\d{11}" title="Digite 11 números" required value="<?= htmlspecialchars($editar_cpf) ?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <select name="tipo_exame" class="form-select" required>
                                    <option value="" disabled>Selecione o tipo de exame</option>
                                    <option value="Dengue" <?= $editar_tipo_exame == '
                                    Dengue' ? 'selected' : '' ?>>Dengue</option>
                                    <option value="ABO Tipo Sanguíneo" <?= $editar_tipo_exame == 'ABO Tipo Sanguíneo' ? 'selected' : '' ?>>ABO Tipo Sanguíneo</option>
                                    <option value="COVID-19" <?= $editar_tipo_exame == 'COVID-19' ? 'selected' : '' ?>>COVID-19</option>
                                    <option value="Outro" <?= $editar_tipo_exame == 'Outro' ? 'selected' : '' ?>>Outro</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="data_exame" class="form-control" required value="<?= htmlspecialchars($editar_data_exame) ?>" />
                            </div>
                            <div class="col-md-4">
                                <select name="resultado" class="form-select" required>
                                    <option value="" disabled>Resultado</option>
                                    <option value="Positivado" <?= $editar_resultado == 'Positivado' ? 'selected' : '' ?>>Positivado</option>
                                    <option value="Negativado" <?= $editar_resultado == 'Negativado' ? 'selected' : '' ?>>Negativado</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="observacao" class="form-control" placeholder="Observação (opcional)" rows="3"><?= htmlspecialchars($editar_observacao) ?></textarea>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <button type="submit" name="atualizar_relatorio" class="btn btn-success px-5">Salvar</button>
                            <a href="relatorio.php" class="btn btn-secondary px-5">Cancelar</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Formulário de Busca por CPF (API Node.js) -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Buscar Relatórios por CPF</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="relatorio.php">
                        <div class="input-group mb-3">
                            <input type="text" name="cpf_busca_api" class="form-control" placeholder="Digite o CPF do paciente" value="<?= htmlspecialchars($cpf_para_busca) ?>" required>
                            <button class="btn btn-primary" type="submit" name="buscar_dados_api">Buscar Dados</button>
                        </div>
                    </form>
                    <?php if ($mensagem_api) : ?>
                        <div class="alert alert-warning mt-2"><?= htmlspecialchars($mensagem_api) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tabela de Paciente e Agendamentos Combinados -->
            <?php if ($paciente_api) : ?>
                <div class="table-responsive mt-4">
                    <h3 class="text-center">Dados do Paciente e Agendamentos</h3>
                    <table class="table table-bordered table-hover text-center align-middle mt-4">
                        <thead class="table-primary">
                            <tr>
                                <th>ID Paciente</th>
                                <th>Nome Paciente</th>
                                <th>CPF Paciente</th>
                                <th>Data Nasc.</th>
                                <th>Telefone</th>
                                <th>Endereço</th>
                                <th>Observações Paciente</th>
                                <th>ID Agendamento</th>
                                <th>Data Consulta</th>
                                <th>Tipo Exame Agendamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agendamentos_api)) : ?>
                                <?php foreach ($agendamentos_api as $agendamento) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($paciente_api["id"]) ?></td>
                                        <td><?= htmlspecialchars($paciente_api["nome"]) ?></td>
                                        <td><?= htmlspecialchars(formatarCPF($paciente_api["CPF"])) ?></td>
                                        <td><?= htmlspecialchars(formatarData($paciente_api["data_nascimento"])) ?></td>
                                        <td><?= htmlspecialchars($paciente_api["telefone"] ?? "-") ?></td>
                                        <td><?= htmlspecialchars($paciente_api["endereco"] ?? "-") ?></td>
                                        <td><?= nl2br(htmlspecialchars($paciente_api["observacoes"] ?? "-")) ?></td>
                                        <td><?= htmlspecialchars($agendamento["id"]) ?></td>
                                        <td><?= htmlspecialchars(formatarData($agendamento["data_consulta"])) ?></td>
                                        <td><?= htmlspecialchars($agendamento["tipo_exame"]) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td><?= htmlspecialchars($paciente_api["id"]) ?></td>
                                    <td><?= htmlspecialchars($paciente_api["nome"]) ?></td>
                                    <td><?= htmlspecialchars(formatarCPF($paciente_api["CPF"])) ?></td>
                                    <td><?= htmlspecialchars(formatarData($paciente_api["data_nascimento"])) ?></td>
                                    <td><?= htmlspecialchars($paciente_api["telefone"] ?? "-") ?></td>
                                    <td><?= htmlspecialchars($paciente_api["endereco"] ?? "-") ?></td>
                                    <td><?= nl2br(htmlspecialchars($paciente_api["observacoes"] ?? "-")) ?></td>
                                    <td colspan="3">Nenhum agendamento encontrado para este paciente.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (isset($_GET["buscar_dados_api"])) : ?>
                <div class="alert alert-info mt-4">
                    Paciente não encontrado com o CPF informado.
                </div>
            <?php endif; ?>

            <!-- Tabela para exibir relatórios da API Node.js -->
            <?php if ($paciente_api && !empty($relatorios_api)) : ?>
                <div class="table-responsive mt-4">
                    <h3 class="text-center">Relatórios do Paciente</h3>
                    <table class="table table-bordered table-hover text-center align-middle mt-4">
                        <thead class="table-primary">
                            <tr>
                                <th>ID Relatório</th>
                                <th>Tipo de Exame</th>
                                <th>Data do Exame</th>
                                <th>Resultado</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($relatorios_api as $relatorio) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($relatorio["id"]) ?></td>
                                    <td><?= htmlspecialchars($relatorio["tipo_exame"]) ?></td>
                                    <td><?= htmlspecialchars(formatarData($relatorio["data_exame"])) ?></td>
                                    <td class="<?= $relatorio["resultado"] == 'Positivado' ? 'resultado-positivo' : 'resultado-negativo' ?>">
                                        <?= htmlspecialchars($relatorio["resultado"]) ?>
                                    </td>
                                    <td><?= nl2br(htmlspecialchars($relatorio["observacao"] ?? "-")) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (isset($_GET["buscar_dados_api"]) && $paciente_api && empty($relatorios_api)) : ?>
                <div class="alert alert-info mt-4">
                    Nenhum relatório encontrado para este paciente.
                </div>
            <?php endif; ?>

            <!-- Tabela de Relatórios do PHP (original) -->
            <div class="table-responsive mt-5">
                <h3 class="text-center">Relatórios Cadastrados no Sistema (Geral)</h3>
                <table class="table table-bordered table-hover text-center align-middle mt-4">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nome do Paciente</th>
                            <th>CPF</th>
                            <th>Tipo de Exame</th>
                            <th>Data do Exame</th>
                            <th>Resultado</th>
                            <th>Observação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($registros)) : ?>
                            <?php foreach ($registros as $registro) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($registro["id"]) ?></td>
                                    <td><?= htmlspecialchars($registro["nome_paciente"]) ?></td>
                                    <td><?= htmlspecialchars(formatarCPF($registro["cpf"])) ?></td>
                                    <td><?= htmlspecialchars($registro["tipo_exame"]) ?></td>
                                    <td><?= htmlspecialchars(formatarData($registro["data_exame"])) ?></td>
                                    <td class="<?= $registro["resultado"] == 'Positivado' ? 'resultado-positivo' : 'resultado-negativo' ?>">
                                        <?= htmlspecialchars($registro["resultado"]) ?>
                                    </td>
                                    <td><?= nl2br(htmlspecialchars($registro["observacao"] ?? "-")) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="relatorio.php?editar_id=<?= $registro["id"] ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <form method="POST" action="relatorio.php" onsubmit="return confirm('Tem certeza que deseja excluir este relatório?');">
                                                <input type="hidden" name="id" value="<?= $registro["id"] ?>" />
                                                <button type="submit" name="excluir_relatorio" class="btn btn-danger btn-sm">Excluir</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8">Nenhum relatório cadastrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?php include('../../modelo/footer.php'); ?>

</html>

