<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Editar Exame - COVID-19</title>
</head>
<body>
    
    <?php
      include('../../modelo/nav.php');
    ?>

    <?php
        require_once './modelo/ExameDao.php';

        $exameParaEditar = null;
        $pacienteInfo = null;
        $sintomasArray = [];
        
        if (isset($_GET['editar'])) {
            $id = $_GET['editar'];
            $exameCovidDao = new ExameCovidDao();
            $exameParaEditar = $exameCovidDao->buscarPorAgendamento($id);
            
            if ($exameParaEditar) {
                // Convert symptoms string to array for checkbox handling
                if ($exameParaEditar->getSintomas()) {
                    $sintomasArray = explode(', ', $exameParaEditar->getSintomas());
                }
                
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
            echo "<script>alert('Exame não encontrado.'); window.location.href = 'listar_exames_covid.php';</script>";
            exit();
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Editar Exame - COVID-19</h1>
                
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
                    <form method="POST" action="controller/ExameCovidController.php">
                        <input type="hidden" name="id" value="<?= $exameParaEditar->getId() ?>">
                        <input type="hidden" name="agendamento_id" value="<?= $exameParaEditar->getAgendamentoId() ?>">
                        <input type="hidden" name="paciente_id" value="<?= $exameParaEditar->getPacienteId() ?>">

                        <!-- Nome do Exame -->
                        <div class="mb-3 text-center">
                            <label for="nome" class="form-label">Nome do Exame:</label>
                            <input type="text" id="nome" name="nome" class="form-control" 
                                   value="<?= htmlspecialchars($exameParaEditar->getNome()) ?>" required>
                        </div>

                        <!-- Tipo de Teste -->
                        <div class="mb-3 text-center">
                            <label for="tipo_teste" class="form-label">Tipo de Teste:</label>
                            <select id="tipo_teste" name="tipo_teste" class="form-select" required>
                                <option value="">Selecione o tipo de teste</option>
                                <option value="RT-PCR" <?= ($exameParaEditar->getTipoTeste() == 'RT-PCR') ? 'selected' : '' ?>>RT-PCR</option>
                                <option value="Antígeno" <?= ($exameParaEditar->getTipoTeste() == 'Antígeno') ? 'selected' : '' ?>>Teste de Antígeno</option>
                                <option value="Sorológico" <?= ($exameParaEditar->getTipoTeste() == 'Sorológico') ? 'selected' : '' ?>>Teste Sorológico</option>
                                <option value="Autoteste" <?= ($exameParaEditar->getTipoTeste() == 'Autoteste') ? 'selected' : '' ?>>Autoteste</option>
                            </select>
                        </div>

                        <!-- Status da Amostra -->
                        <div class="mb-3 text-center">
                            <label for="status_amostra" class="form-label">Status da Amostra:</label>
                            <select id="status_amostra" name="status_amostra" class="form-select" required>
                                <option value="">Selecione o status da amostra</option>
                                <option value="Coletada" <?= ($exameParaEditar->getStatusAmostra() == 'Coletada') ? 'selected' : '' ?>>Coletada</option>
                                <option value="Não Coletada" <?= ($exameParaEditar->getStatusAmostra() == 'Não Coletada') ? 'selected' : '' ?>>Não Coletada</option>
                                <option value="Em Processamento" <?= ($exameParaEditar->getStatusAmostra() == 'Em Processamento') ? 'selected' : '' ?>>Em Processamento</option>
                                <option value="Processada" <?= ($exameParaEditar->getStatusAmostra() == 'Processada') ? 'selected' : '' ?>>Processada</option>
                                <option value="Resultado Disponível" <?= ($exameParaEditar->getStatusAmostra() == 'Resultado Disponível') ? 'selected' : '' ?>>Resultado Disponível</option>
                            </select>
                        </div>

                        <!-- Resultado -->
                        <div class="mb-3 text-center">
                            <label for="resultado" class="form-label">Resultado:</label>
                            <select id="resultado" name="resultado" class="form-select">
                                <option value="">Selecione o resultado (se disponível)</option>
                                <option value="Positivo" <?= ($exameParaEditar->getResultado() == 'Positivo') ? 'selected' : '' ?>>Positivo</option>
                                <option value="Negativo" <?= ($exameParaEditar->getResultado() == 'Negativo') ? 'selected' : '' ?>>Negativo</option>
                                <option value="Inconclusivo" <?= ($exameParaEditar->getResultado() == 'Inconclusivo') ? 'selected' : '' ?>>Inconclusivo</option>
                                <option value="Aguardando" <?= ($exameParaEditar->getResultado() == 'Aguardando') ? 'selected' : '' ?>>Aguardando Resultado</option>
                            </select>
                            <div class="form-text">Deixe em branco se o resultado ainda não estiver disponível</div>
                        </div>

                        <!-- Data de Início dos Sintomas -->
                        <div class="mb-3 text-center">
                            <label for="data_inicio_sintomas" class="form-label">Data de Início dos Sintomas:</label>
                            <input type="date" id="data_inicio_sintomas" name="data_inicio_sintomas" class="form-control" 
                                   value="<?= $exameParaEditar->getDataInicioSintomas() ?>">
                            <div class="form-text">Deixe em branco se o paciente for assintomático</div>
                        </div>

                        <!-- Sintomas -->
                        <div class="mb-3 text-center">
                            <label for="sintomas" class="form-label">Sintomas Relatados:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Febre" id="febre" 
                                               <?= in_array('Febre', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="febre">Febre</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Tosse" id="tosse" 
                                               <?= in_array('Tosse', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tosse">Tosse</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Dor de garganta" id="dor_garganta" 
                                               <?= in_array('Dor de garganta', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dor_garganta">Dor de garganta</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Dificuldade respiratória" id="dificuldade_respiratoria" 
                                               <?= in_array('Dificuldade respiratória', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dificuldade_respiratoria">Dificuldade respiratória</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Perda de olfato" id="perda_olfato" 
                                               <?= in_array('Perda de olfato', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perda_olfato">Perda de olfato</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Perda de paladar" id="perda_paladar" 
                                               <?= in_array('Perda de paladar', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perda_paladar">Perda de paladar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Dor de cabeça" id="dor_cabeca" 
                                               <?= in_array('Dor de cabeça', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dor_cabeca">Dor de cabeça</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Fadiga" id="fadiga" 
                                               <?= in_array('Fadiga', $sintomasArray) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="fadiga">Fadiga</label>
                                    </div>
                                </div>
                            </div>
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
                            <a href="listar_exames_covid.php" class="btn btn-secondary ms-2">
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

