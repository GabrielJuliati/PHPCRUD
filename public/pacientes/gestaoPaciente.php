<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/styleCP.css">
</head>
<body>

    <?php
        include('../../modelo/nav.php');
        require_once './controller/pacienteController.php';

        // Processo de exclusão via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
            $id = $_POST['excluir'];
            $pacienteDao = new PacienteDao();
            $pacienteDao->delete($id);

            header("Location: gestaoPaciente.php");
            exit;
        }
    ?>

    <div class="container mt-4">
        <h2>Gestão de Pacientes</h2>

        <!-- Formulário de busca por CPF -->
        <form method="get" class="row g-3 mb-4">
            <div class="col-auto">
                <input
                    type="text"
                    class="form-control"
                    name="cpf"
                    placeholder="Buscar por CPF"
                    value="<?= htmlspecialchars($_GET['cpf'] ?? '', ENT_QUOTES) ?>"
                >
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="gestaoPaciente.php" class="btn btn-secondary">Limpar</a>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Sempre que for GET ou POST, chamamos listar()
                    if ($_SERVER["REQUEST_METHOD"] === "GET" || $_SERVER["REQUEST_METHOD"] === "POST") {
                        listar();
                    }
                ?>
            </tbody>
        </table>
    </div>

    <?php include('../../modelo/footer.php'); ?>
</body>
</html>