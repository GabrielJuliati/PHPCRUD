<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Cadastro de Exame - COVID-19</title>
</head>
<body>
    
    <?php
      include('../../modelo/nav.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Cadastro de Exame - COVID-19</h1>
                <div>
                    <form method="POST" action="controller/ExameCovidController.php">
                        
                        <!-- Buscar Agendamento por ID -->
                        <div class="mb-3 text-center">
                            <label for="agendamento_search" class="form-label">Buscar Agendamento por ID:</label>
                            <div class="input-group">
                                <input type="text" id="agendamento_search" class="form-control" placeholder="Digite o ID do agendamento">
                                <button type="button" id="buscar_agendamento" class="btn btn-primary">Buscar</button>
                            </div>
                            <div id="agendamento_info" class="mt-2" style="display: none;">
                                <div class="card">
                                    <div class="card-body">
                                        <p><strong>Paciente:</strong> <span id="paciente_nome"></span></p>
                                        <p><strong>CPF:</strong> <span id="paciente_cpf"></span></p>
                                        <p><strong>Data da Consulta:</strong> <span id="data_consulta"></span></p>
                                        <p><strong>Tipo de Exame:</strong> <span id="tipo_exame"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for agendamento_id and paciente_id -->
                        <input type="hidden" id="agendamento_id" name="agendamento_id" required>
                        <input type="hidden" id="paciente_id" name="paciente_id" required>

                        <!-- Nome do Exame -->
                        <div class="mb-3 text-center">
                            <label for="nome" class="form-label">Nome do Exame:</label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Teste COVID-19 - Paciente Ana" required>
                        </div>

                        <!-- Tipo de Teste -->
                        <div class="mb-3 text-center">
                            <label for="tipo_teste" class="form-label">Tipo de Teste:</label>
                            <select id="tipo_teste" name="tipo_teste" class="form-select" required>
                                <option value="">Selecione o tipo de teste</option>
                                <option value="RT-PCR">RT-PCR</option>
                                <option value="Antígeno">Teste de Antígeno</option>
                                <option value="Sorológico">Teste Sorológico</option>
                                <option value="Autoteste">Autoteste</option>
                            </select>
                        </div>

                        <!-- Status da Amostra -->
                        <div class="mb-3 text-center">
                            <label for="status_amostra" class="form-label">Status da Amostra:</label>
                            <select id="status_amostra" name="status_amostra" class="form-select" required>
                                <option value="">Selecione o status da amostra</option>
                                <option value="Coletada">Coletada</option>
                                <option value="Não Coletada">Não Coletada</option>
                                <option value="Em Processamento">Em Processamento</option>
                                <option value="Processada">Processada</option>
                                <option value="Resultado Disponível">Resultado Disponível</option>
                            </select>
                        </div>

                        <!-- Resultado -->
                        <div class="mb-3 text-center">
                            <label for="resultado" class="form-label">Resultado:</label>
                            <select id="resultado" name="resultado" class="form-select">
                                <option value="">Selecione o resultado (se disponível)</option>
                                <option value="Positivo">Positivo</option>
                                <option value="Negativo">Negativo</option>
                                <option value="Inconclusivo">Inconclusivo</option>
                                <option value="Aguardando">Aguardando Resultado</option>
                            </select>
                            <div class="form-text">Deixe em branco se o resultado ainda não estiver disponível</div>
                        </div>

                        <!-- Data de Início dos Sintomas -->
                        <div class="mb-3 text-center">
                            <label for="data_inicio_sintomas" class="form-label">Data de Início dos Sintomas:</label>
                            <input type="date" id="data_inicio_sintomas" name="data_inicio_sintomas" class="form-control">
                            <div class="form-text">Deixe em branco se o paciente for assintomático</div>
                        </div>

                        <!-- Sintomas -->
                        <div class="mb-3 text-center">
                            <label for="sintomas" class="form-label">Sintomas Relatados:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Febre" id="febre">
                                        <label class="form-check-label" for="febre">Febre</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Tosse" id="tosse">
                                        <label class="form-check-label" for="tosse">Tosse</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Dor de garganta" id="dor_garganta">
                                        <label class="form-check-label" for="dor_garganta">Dor de garganta</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Dificuldade respiratória" id="dificuldade_respiratoria">
                                        <label class="form-check-label" for="dificuldade_respiratoria">Dificuldade respiratória</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Perda de olfato" id="perda_olfato">
                                        <label class="form-check-label" for="perda_olfato">Perda de olfato</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Perda de paladar" id="perda_paladar">
                                        <label class="form-check-label" for="perda_paladar">Perda de paladar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Dor de cabeça" id="dor_cabeca">
                                        <label class="form-check-label" for="dor_cabeca">Dor de cabeça</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sintomas[]" value="Fadiga" id="fadiga">
                                        <label class="form-check-label" for="fadiga">Fadiga</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="mb-3 text-center">
                            <label for="observacoes" class="form-label">Observações:</label>
                            <textarea id="observacoes" name="observacoes" class="form-control" rows="3" placeholder="Observações adicionais sobre o exame (opcional)"></textarea>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" name="cadastrar" class="btn btn-success">
                                Cadastrar Exame
                            </button>
                            <a href="agendamentos.php" class="btn btn-secondary ms-2">
                                Voltar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <script>
        document.getElementById('buscar_agendamento').addEventListener('click', function() {
            const agendamentoId = document.getElementById('agendamento_search').value;
            
            if (!agendamentoId) {
                alert('Por favor, digite o ID do agendamento.');
                return;
            }

            // AJAX request to search for appointment
            fetch('controller/buscar_agendamento.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'agendamento_id=' + encodeURIComponent(agendamentoId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display appointment information
                    document.getElementById('paciente_nome').textContent = data.paciente_nome;
                    document.getElementById('paciente_cpf').textContent = data.paciente_cpf;
                    document.getElementById('data_consulta').textContent = data.data_consulta;
                    document.getElementById('tipo_exame').textContent = data.tipo_exame;
                    
                    // Set hidden fields
                    document.getElementById('agendamento_id').value = data.agendamento_id;
                    document.getElementById('paciente_id').value = data.paciente_id;
                    
                    // Show appointment info card
                    document.getElementById('agendamento_info').style.display = 'block';
                } else {
                    alert('Agendamento não encontrado: ' + data.message);
                    document.getElementById('agendamento_info').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao buscar agendamento.');
            });
        });
    </script>

    <?php
        include('../../modelo/footer.php');
    ?>

</body>
</html>

