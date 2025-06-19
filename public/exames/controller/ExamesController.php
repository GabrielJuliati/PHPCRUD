<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../modelo/ExameDao.php';
require_once '../modelo/ExameModels.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    switch ($acao) {
        case 'cadastrar':
            cadastrarExame();
            break;
        case 'atualizar':
            atualizarExame();
            break;
        default:
            echo "<script>
                alert('Ação não reconhecida.');
                window.history.back();
            </script>";
            break;
    }
} else {
    echo "<script>
        alert('Método de requisição inválido.');
        window.history.back();
    </script>";
}

function cadastrarExame() {
    try {
        $tipoExame = $_POST['tipo_exame'] ?? '';
        $agendamentoId = $_POST['agendamento_id'] ?? '';
        $pacienteId = $_POST['paciente_id'] ?? '';
        $nomeExame = $_POST['nome_exame'] ?? '';
        
        // Validação básica
        if (empty($tipoExame) || empty($agendamentoId) || empty($pacienteId) || empty($nomeExame)) {
            throw new Exception('Todos os campos obrigatórios devem ser preenchidos.');
        }
        
        $resultado = false;
        
        switch ($tipoExame) {
            case 'dengue':
                $resultado = cadastrarExameDengue($agendamentoId, $pacienteId, $nomeExame);
                break;
            case 'abo':
                $resultado = cadastrarExameABO($agendamentoId, $pacienteId, $nomeExame);
                break;
            case 'covid':
                $resultado = cadastrarExameCovid($agendamentoId, $pacienteId, $nomeExame);
                break;
            default:
                throw new Exception('Tipo de exame inválido.');
        }
        
        if ($resultado) {
            echo "<script>
                alert('Exame cadastrado com sucesso!');
                window.location.href = '../gestaoAgendamento.php';
            </script>";
        } else {
            throw new Exception('Erro ao cadastrar exame. Tente novamente.');
        }
        
    } catch (Exception $e) {
        echo "<script>
            alert('Erro: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}

function atualizarExame() {
    try {
        $tipoExame = $_POST['tipo_exame'] ?? '';
        $exameId = $_POST['exame_id'] ?? '';
        $agendamentoId = $_POST['agendamento_id'] ?? '';
        $pacienteId = $_POST['paciente_id'] ?? '';
        $nomeExame = $_POST['nome_exame'] ?? '';
        
        // Validação básica
        if (empty($tipoExame) || empty($exameId) || empty($agendamentoId) || empty($pacienteId) || empty($nomeExame)) {
            throw new Exception('Todos os campos obrigatórios devem ser preenchidos.');
        }
        
        $resultado = false;
        
        switch ($tipoExame) {
            case 'dengue':
                $resultado = atualizarExameDengue($exameId, $agendamentoId, $pacienteId, $nomeExame);
                break;
            case 'abo':
                $resultado = atualizarExameABO($exameId, $agendamentoId, $pacienteId, $nomeExame);
                break;
            case 'covid':
                $resultado = atualizarExameCovid($exameId, $agendamentoId, $pacienteId, $nomeExame);
                break;
            default:
                throw new Exception('Tipo de exame inválido.');
        }
        
        if ($resultado) {
            echo "<script>
                alert('Exame atualizado com sucesso!');
                window.location.href = '../gestaoAgendamento.php';
            </script>";
        } else {
            throw new Exception('Erro ao atualizar exame. Verifique se o exame existe.');
        }
        
    } catch (Exception $e) {
        echo "<script>
            alert('Erro: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}

function cadastrarExameDengue($agendamentoId, $pacienteId, $nomeExame) {
    $amostraSangue = $_POST['amostra_sangue'] ?? '';
    $dataInicioSintomas = $_POST['data_inicio_sintomas'] ?? null;
    
    if (empty($amostraSangue)) {
        throw new Exception('Amostra de sangue é obrigatória para exame de Dengue.');
    }
    
    $exame = new ExameDengue();
    $exame->setAgendamentoId($agendamentoId);
    $exame->setPacienteId($pacienteId);
    $exame->setNome($nomeExame);
    $exame->setAmostraSangue($amostraSangue);
    $exame->setDataInicioSintomas($dataInicioSintomas ?: null);
    
    $dao = new ExameDengueDao();
    return $dao->inserir($exame);
}

function cadastrarExameABO($agendamentoId, $pacienteId, $nomeExame) {
    $amostraDna = $_POST['amostra_dna'] ?? '';
    $tipoSanguineo = $_POST['tipo_sanguineo'] ?? null;
    $observacoes = $_POST['observacoes'] ?? null;
    
    if (empty($amostraDna)) {
        throw new Exception('Amostra de DNA é obrigatória para exame ABO.');
    }
    
    $exame = new ExameABO();
    $exame->setAgendamentoId($agendamentoId);
    $exame->setPacienteId($pacienteId);
    $exame->setNome($nomeExame);
    $exame->setAmostraDna($amostraDna);
    $exame->setTipoSanguineo($tipoSanguineo ?: null);
    $exame->setObservacoes($observacoes ?: null);
    
    $dao = new ExameABODao();
    return $dao->inserir($exame);
}

function cadastrarExameCovid($agendamentoId, $pacienteId, $nomeExame) {
    $tipoTeste = $_POST['tipo_teste'] ?? '';
    $statusAmostra = $_POST['status_amostra'] ?? '';
    $resultado = $_POST['resultado'] ?? null;
    $dataInicioSintomas = $_POST['data_inicio_sintomas'] ?? null;
    $sintomas = $_POST['sintomas'] ?? [];
    $observacoes = $_POST['observacoes'] ?? null;
    
    if (empty($tipoTeste) || empty($statusAmostra)) {
        throw new Exception('Tipo de teste e status da amostra são obrigatórios para exame COVID-19.');
    }
    
    // Convert symptoms array to string
    $sintomasString = is_array($sintomas) ? implode(',', $sintomas) : '';
    
    $exame = new ExameCovid();
    $exame->setAgendamentoId($agendamentoId);
    $exame->setPacienteId($pacienteId);
    $exame->setNome($nomeExame);
    $exame->setTipoTeste($tipoTeste);
    $exame->setStatusAmostra($statusAmostra);
    $exame->setResultado($resultado ?: null);
    $exame->setDataInicioSintomas($dataInicioSintomas ?: null);
    $exame->setSintomas($sintomasString);
    $exame->setObservacoes($observacoes ?: null);
    
    $dao = new ExameCovidDao();
    return $dao->inserir($exame);
}

function atualizarExameDengue($exameId, $agendamentoId, $pacienteId, $nomeExame) {
    $amostraSangue = $_POST['amostra_sangue'] ?? '';
    $dataInicioSintomas = $_POST['data_inicio_sintomas'] ?? null;
    
    if (empty($amostraSangue)) {
        throw new Exception('Amostra de sangue é obrigatória para exame de Dengue.');
    }
    
    $exame = new ExameDengue();
    $exame->setId($exameId);
    $exame->setAgendamentoId($agendamentoId);
    $exame->setPacienteId($pacienteId);
    $exame->setNome($nomeExame);
    $exame->setAmostraSangue($amostraSangue);
    $exame->setDataInicioSintomas($dataInicioSintomas ?: null);
    
    $dao = new ExameDengueDao();
    return $dao->atualizar($exame);
}

function atualizarExameABO($exameId, $agendamentoId, $pacienteId, $nomeExame) {
    $amostraDna = $_POST['amostra_dna'] ?? '';
    $tipoSanguineo = $_POST['tipo_sanguineo'] ?? null;
    $observacoes = $_POST['observacoes'] ?? null;
    
    if (empty($amostraDna)) {
        throw new Exception('Amostra de DNA é obrigatória para exame ABO.');
    }
    
    $exame = new ExameABO();
    $exame->setId($exameId);
    $exame->setAgendamentoId($agendamentoId);
    $exame->setPacienteId($pacienteId);
    $exame->setNome($nomeExame);
    $exame->setAmostraDna($amostraDna);
    $exame->setTipoSanguineo($tipoSanguineo ?: null);
    $exame->setObservacoes($observacoes ?: null);
    
    $dao = new ExameABODao();
    return $dao->atualizar($exame);
}

function atualizarExameCovid($exameId, $agendamentoId, $pacienteId, $nomeExame) {
    $tipoTeste = $_POST['tipo_teste'] ?? '';
    $statusAmostra = $_POST['status_amostra'] ?? '';
    $resultado = $_POST['resultado'] ?? null;
    $dataInicioSintomas = $_POST['data_inicio_sintomas'] ?? null;
    $sintomas = $_POST['sintomas'] ?? [];
    $observacoes = $_POST['observacoes'] ?? null;
    
    if (empty($tipoTeste) || empty($statusAmostra)) {
        throw new Exception('Tipo de teste e status da amostra são obrigatórios para exame COVID-19.');
    }
    
    // Convert symptoms array to string
    $sintomasString = is_array($sintomas) ? implode(',', $sintomas) : '';
    
    $exame = new ExameCovid();
    $exame->setId($exameId);
    $exame->setAgendamentoId($agendamentoId);
    $exame->setPacienteId($pacienteId);
    $exame->setNome($nomeExame);
    $exame->setTipoTeste($tipoTeste);
    $exame->setStatusAmostra($statusAmostra);
    $exame->setResultado($resultado ?: null);
    $exame->setDataInicioSintomas($dataInicioSintomas ?: null);
    $exame->setSintomas($sintomasString);
    $exame->setObservacoes($observacoes ?: null);
    
    $dao = new ExameCovidDao();
    return $dao->atualizar($exame);
}

class ExamesController {
    
    public function listarTodosExames($filtroTipo = '') {
        $todosExames = [];
        
        try {
            // Get Dengue exams
            if (empty($filtroTipo) || $filtroTipo === 'dengue') {
                $dengueDao = new ExameDengueDao();
                $examesDengue = $dengueDao->buscarTodos();
                $todosExames = array_merge($todosExames, $examesDengue);
            }
            
            // Get ABO exams
            if (empty($filtroTipo) || $filtroTipo === 'abo') {
                $aboDao = new ExameABODao();
                $examesABO = $aboDao->buscarTodos();
                $todosExames = array_merge($todosExames, $examesABO);
            }
            
            // Get COVID exams
            if (empty($filtroTipo) || $filtroTipo === 'covid') {
                $covidDao = new ExameCovidDao();
                $examesCovid = $covidDao->buscarTodos();
                $todosExames = array_merge($todosExames, $examesCovid);
            }
            
            // Sort by ID descending (most recent first)
            usort($todosExames, function($a, $b) {
                return $b->getId() - $a->getId();
            });
            
            return $todosExames;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao listar exames: " . $e->getMessage());
        }
    }
    
    public function excluirExame($tipo, $id) {
        try {
            switch ($tipo) {
                case 'dengue':
                    $dao = new ExameDengueDao();
                    return $dao->deletar($id);
                case 'abo':
                    $dao = new ExameABODao();
                    return $dao->deletar($id);
                case 'covid':
                    $dao = new ExameCovidDao();
                    return $dao->deletar($id);
                default:
                    throw new Exception('Tipo de exame inválido para exclusão.');
            }
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir exame: " . $e->getMessage());
        }
    }
    
    public function contarExamesPorTipo() {
        try {
            $contadores = [
                'dengue' => 0,
                'abo' => 0,
                'covid' => 0,
                'total' => 0
            ];
            
            // Count Dengue exams
            $dengueDao = new ExameDengueDao();
            $examesDengue = $dengueDao->buscarTodos();
            $contadores['dengue'] = count($examesDengue);
            
            // Count ABO exams
            $aboDao = new ExameABODao();
            $examesABO = $aboDao->buscarTodos();
            $contadores['abo'] = count($examesABO);
            
            // Count COVID exams
            $covidDao = new ExameCovidDao();
            $examesCovid = $covidDao->buscarTodos();
            $contadores['covid'] = count($examesCovid);
            
            // Total count
            $contadores['total'] = $contadores['dengue'] + $contadores['abo'] + $contadores['covid'];
            
            return $contadores;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao contar exames: " . $e->getMessage());
        }
    }
}

// Handle AJAX requests or direct calls
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ExamesController();
    
    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'excluir':
                $tipo = $_POST['tipo'] ?? '';
                $id = $_POST['id'] ?? '';
                
                if (empty($tipo) || empty($id)) {
                    echo "<script>
                        alert('Dados insuficientes para exclusão.');
                        window.history.back();
                    </script>";
                    exit;
                }
                
                try {
                    $resultado = $controller->excluirExame($tipo, $id);
                    if ($resultado) {
                        echo "<script>
                            alert('Exame excluído com sucesso!');
                            window.location.href = '../gestaoExames.php';
                        </script>";
                    } else {
                        echo "<script>
                            alert('Erro ao excluir exame. Tente novamente.');
                            window.history.back();
                        </script>";
                    }
                } catch (Exception $e) {
                    echo "<script>
                        alert('Erro: " . addslashes($e->getMessage()) . "');
                        window.history.back();
                    </script>";
                }
                break;
                
            default:
                echo "<script>
                    alert('Ação não reconhecida.');
                    window.history.back();
                </script>";
                break;
        }
    }
}

?>

