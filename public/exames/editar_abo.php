<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Editar Exame - ABO (Tipo Sanguíneo)</title>
</head>
<body>
    
    <?php
      include('../../modelo/nav.php');
    ?>

    <?php
        require_once './modelo/ExameDao.php';

        $exameParaEditar = null;
        $pacienteInfo = null;
        
        if (isset($_GET['editar'])) {
            $id = $_GET['editar'];
            $exameABODao = new ExameABODao();
            $exameParaEditar = $exameABODao->buscarPorAgendamento($id);
            
            if ($exameParaEditar) {
                // Buscar informações do paciente e agendamento
                try {
                    $conn = ConnectionFactory::getConnection();
                    $sql = "SELECT p.nome as paciente_nome, p.cpf as paciente_cpf, 
                                   a.data_consulta, a.tipo_exame
                            FROM paciente p 
                            JOIN agendamento a ON p.id = a.paciente_id 
                            WHERE a.id = :agendamento_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':agendamento_id', $exameParaEditar->getAgendamentoId());
                    $stmt->execute();
                    $info = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($info) {
                        $pacienteInfo = $info;
                    }
                } catch (PDOException $e) {
                    echo "Erro ao buscar informações: " . $e->getMessage();
                }
            }
        }
        
        if (!$exameParaEditar) {
            echo "<script>alert('Exame não encontrado.'); window.location.href = 'listar_exames_abo.php';</script>";
            exit();
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Editar Exame - ABO (Tipo Sanguíneo)</h1>
                
                <!-- Informações do Paciente e Agendamento -->
                <?php if ($pacienteInfo): ?>
                <div class="mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Informações do Agendamento</h5>
                            <p><strong>Paciente:</strong> <?= htmlspecialchars($pacienteInfo['paciente_nome']) ?></p>
                            <p><strong>CPF:</strong> <?= htmlspecialchars($pacienteInfo['paciente_cpf']) ?></p>
                            <p><strong>Data da Consulta:</strong> <?= date('d/m/Y', strtotime($pacienteInfo['data_consulta'])) ?></p>
                            <p><strong>Tipo de Exame:</strong> <?= htmlspecialchars($pacienteInfo['tipo_exame']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div>
                    <form method="POST" action="controller/ExameABOController.php">
                        <input type="hidden" name="id" value="<?= $exameParaEditar->getId() ?>">
                        <input type="hidden" name="agendamento_id" value="<?= $exameParaEditar->getAgendamentoId() ?>">
                        <input type="hidden" name="paciente_id" value="<?= $exameParaEditar->getPacienteId() ?>">

                        <!-- Nome do Exame -->
                        <div class="mb-3 text-center">
                            <label for="nome" class="form-label">Nome do Exame:</label>
                            <input type="text" id="nome" name="nome" class="form-control" 
                                   value="<?= htmlspecialchars($exameParaEditar->getNome()) ?>" required>
                        </div>

                        <!-- Amostra de DNA -->
                        <div class="mb-3 text-center">
                            <label for="amostra_dna" class="form-label">Amostra de DNA:</label>
                            <select id="amostra_dna" name="amostra_dna" class="form-select" required>
                                <option value="">Selecione o status da amostra</option>
                                <option value="Coletada" <?= ($exameParaEditar->getAmostraDna() == 'Coletada') ? 'selected' : '' ?>>Coletada</option>
                                <option value="Não Coletada" <?= ($exameParaEditar->getAmostraDna() == 'Não Coletada') ? 'selected' : '' ?>>Não Coletada</option>
                                <option value="Em Processamento" <?= ($exameParaEditar->getAmostraDna() == 'Em Processamento') ? 'selected' : '' ?>>Em Processamento</option>
                                <option value="Processada" <?= ($exameParaEditar->getAmostraDna() == 'Processada') ? 'selected' : '' ?>>Processada</option>
                                <option value="Resultado Disponível" <?= ($exameParaEditar->getAmostraDna() == 'Resultado Disponível') ? 'selected' : '' ?>>Resultado Disponível</option>
                            </select>
                        </div>

                        <!-- Tipo Sanguíneo (Resultado) -->
                        <div class="mb-3 text-center">
                            <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo (Resultado):</label>
                            <select id="tipo_sanguineo" name="tipo_sanguineo" class="form-select">
                                <option value="">Selecione o tipo sanguíneo (se disponível)</option>
                                <option value="A+" <?= ($exameParaEditar->getTipoSanguineo() == 'A+') ? 'selected' : '' ?>>A+</option>
                                <option value="A-" <?= ($exameParaEditar->getTipoSanguineo() == 'A-') ? 'selected' : '' ?>>A-</option>
                                <option value="B+" <?= ($exameParaEditar->getTipoSanguineo() == 'B+') ? 'selected' : '' ?>>B+</option>
                                <option value="B-" <?= ($exameParaEditar->getTipoSanguineo() == 'B-') ? 'selected' : '' ?>>B-</option>
                                <option value="AB+" <?= ($exameParaEditar->getTipoSanguineo() == 'AB+') ? 'selected' : '' ?>>AB+</option>
                                <option value="AB-" <?= ($exameParaEditar->getTipoSanguineo() == 'AB-') ? 'selected' : '' ?>>AB-</option>
                                <option value="O+" <?= ($exameParaEditar->getTipoSanguineo() == 'O+') ? 'selected' : '' ?>>O+</option>
                                <option value="O-" <?= ($exameParaEditar->getTipoSanguineo() == 'O-') ? 'selected' : '' ?>>O-</option>
                            </select>
                            <div class="form-text">Deixe em branco se o resultado ainda não estiver disponível</div>
                        </div>

                        <!-- Observações -->
                        <div class="mb-3 text-center">
                            <label for="observacoes" class="form-label">Observações:</label>
                            <textarea id="observacoes" name="observacoes" class="form-control" rows="3" 
                                      placeholder="Observações adicionais sobre o exame (opcional)"><?= htmlspecialchars($exameParaEditar->getObservacoes() ?? '') ?></textarea>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" name="atualizar" class="btn btn-success">
                                Atualizar Exame
                            </button>
                            <a href="listar_exames_abo.php" class="btn btn-secondary ms-2">
                                Cancelar
                            </a>
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

