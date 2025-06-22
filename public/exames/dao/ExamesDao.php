<?php

require_once(__DIR__ . '/../../connection/Connection.php');
require_once(__DIR__ . '/../model/Exames.php');

class ExameDengueDao {
    
    private $apiUrl = 'http://localhost:3000/api/exames-dengue';

    private function makeApiRequest($url, $method = 'GET', $data = null) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response === false) {
            throw new Exception('Erro ao conectar com a API Node.js');
        }
        
        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 400) {
            $errorMessage = isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Erro na API';
            throw new Exception($errorMessage);
        }
        
        return $decodedResponse;
    }

    public function inserir(ExameDengue $exame) {
        try {
            $data = [
                'agendamento_id' => $exame->getAgendamentoId(),
                'paciente_id' => $exame->getPacienteId(),
                'nome' => $exame->getNome(),
                'amostra_sangue' => $exame->getAmostraSangue(),
                'data_inicio_sintomas' => $exame->getDataInicioSintomas()
            ];
            
            $response = $this->makeApiRequest($this->apiUrl, 'POST', $data);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir exame de Dengue: " . $e->getMessage());
        }
    }

    public function buscarPorId($id) {
        try {
            $url = $this->apiUrl . '/' . $id;
            $response = $this->makeApiRequest($url);
            
            if (isset($response['data'])) {
                return $this->mapRowToExame($response['data']);
            }
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar exame de Dengue: " . $e->getMessage());
        }
    }

    public function buscarPorAgendamento($agendamentoId) {
        try {
            $url = $this->apiUrl . '/agendamento/' . $agendamentoId;
            $response = $this->makeApiRequest($url);
            
            $exames = [];
            if (isset($response['data']) && is_array($response['data'])) {
                foreach ($response['data'] as $row) {
                    $exames[] = $this->mapRowToExame($row);
                }
            }
            return $exames;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar exames de Dengue por agendamento: " . $e->getMessage());
        }
    }

    public function buscarTodos() {
    try {
        $response = $this->makeApiRequest($this->apiUrl);
        
        // Verifica se a resposta da API é válida
        if (!isset($response['success'])) {
            throw new Exception("Resposta da API inválida");
        }

        // Se a API retornou erro, lança exceção com a mensagem
        if ($response['success'] === false) {
            $errorMessage = $response['message'] ?? 'Erro desconhecido na API';
            throw new Exception($errorMessage);
        }

        $exames = [];
        
        // Verifica se existem dados na resposta
        if (isset($response['data'])) {
            // Garante que data é um array
            $dadosExames = is_array($response['data']) ? $response['data'] : [];
            
            foreach ($dadosExames as $row) {
                try {
                    // Valida os dados mínimos necessários
                    if (empty($row['id'])) {
                        continue; // Pula registros inválidos
                    }

                    $exame = $this->mapRowToExame($row);
                    
                    // Adiciona informações extras se disponíveis
                    $exame->dataConsulta = $row['data_consulta'] ?? null;
                    $exame->pacienteNome = $row['paciente_nome'] ?? 'Não informado';
                    $exame->pacienteCpf = $row['paciente_cpf'] ?? 'Não informado';
                    $exame->tipoExame = 'Dengue';
                    
                    $exames[] = $exame;
                } catch (Exception $e) {
                    // Loga o erro mas continua processando outros registros
                    error_log("Erro ao processar exame: " . $e->getMessage());
                    continue;
                }
            }
        }
        
        return $exames;
        
    } catch (Exception $e) {
        // Log detalhado do erro para administradores
        error_log("ERRO NA API - " . date('Y-m-d H:i:s') . " - " . $e->getMessage());
        
        // Mensagem amigável para o usuário
        throw new Exception("Erro ao buscar exames de Dengue. Por favor, tente novamente mais tarde.");
    }
}

    public function atualizar(ExameDengue $exame) {
        try {
            $data = [
                'nome' => $exame->getNome(),
                'amostra_sangue' => $exame->getAmostraSangue(),
                'data_inicio_sintomas' => $exame->getDataInicioSintomas()
            ];
            
            $url = $this->apiUrl . '/' . $exame->getId();
            $response = $this->makeApiRequest($url, 'PUT', $data);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar exame de Dengue: " . $e->getMessage());
        }
    }

    public function deletar($id) {
        try {
            $url = $this->apiUrl . '/' . $id;
            $response = $this->makeApiRequest($url, 'DELETE');
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao deletar exame de Dengue: " . $e->getMessage());
        }
    }

    private function mapRowToExame($row) {
        $exame = new ExameDengue();
        $exame->setId($row["id"]);
        $exame->setAgendamentoId($row["agendamento_id"]);
        $exame->setPacienteId($row["paciente_id"]);
        $exame->setNome($row["nome"]);
        $exame->setAmostraSangue($row["amostra_sangue"]);
        $exame->setDataInicioSintomas($row["data_inicio_sintomas"]);
        return $exame;
    }
}

class ExameABODao {
    
    private $apiUrl = 'http://localhost:3000/api/exames-abo';

    private function makeApiRequest($url, $method = 'GET', $data = null) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response === false) {
            throw new Exception('Erro ao conectar com a API Node.js');
        }
        
        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 400) {
            $errorMessage = isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Erro na API';
            throw new Exception($errorMessage);
        }
        
        return $decodedResponse;
    }

    public function inserir(ExameABO $exame) {
        try {
            $data = [
                'agendamento_id' => $exame->getAgendamentoId(),
                'paciente_id' => $exame->getPacienteId(),
                'nome' => $exame->getNome(),
                'amostra_dna' => $exame->getAmostraDna(),
                'tipo_sanguineo' => $exame->getTipoSanguineo(),
                'observacoes' => $exame->getObservacoes()
            ];
            
            $response = $this->makeApiRequest($this->apiUrl, 'POST', $data);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir exame ABO: " . $e->getMessage());
        }
    }

    public function buscarPorId($id) {
        try {
            $url = $this->apiUrl . '/' . $id;
            $response = $this->makeApiRequest($url);
            
            if (isset($response['data'])) {
                return $this->mapRowToExame($response['data']);
            }
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar exame ABO: " . $e->getMessage());
        }
    }

    public function buscarPorAgendamento($agendamentoId) {
        try {
            $url = $this->apiUrl . '/agendamento/' . $agendamentoId;
            $response = $this->makeApiRequest($url);
            
            $exames = [];
            if (isset($response['data']) && is_array($response['data'])) {
                foreach ($response['data'] as $row) {
                    $exames[] = $this->mapRowToExame($row);
                }
            }
            return $exames;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar exames ABO por agendamento: " . $e->getMessage());
        }
    }

    public function buscarTodos() {
        try {
            $response = $this->makeApiRequest($this->apiUrl);
            
            $exames = [];
            if (isset($response['data']) && is_array($response['data'])) {
                foreach ($response['data'] as $row) {
                    $exame = $this->mapRowToExame($row);
                    if (isset($row['data_consulta'])) $exame->dataConsulta = $row['data_consulta'];
                    if (isset($row['paciente_nome'])) $exame->pacienteNome = $row['paciente_nome'];
                    if (isset($row['paciente_cpf'])) $exame->pacienteCpf = $row['paciente_cpf'];
                    $exame->tipoExame = 'ABO';
                    $exames[] = $exame;
                }
            }
            return $exames;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar todos os exames ABO: " . $e->getMessage());
        }
    }

    public function atualizar(ExameABO $exame) {
        try {
            $data = [
                'nome' => $exame->getNome(),
                'amostra_dna' => $exame->getAmostraDna(),
                'tipo_sanguineo' => $exame->getTipoSanguineo(),
                'observacoes' => $exame->getObservacoes()
            ];
            
            $url = $this->apiUrl . '/' . $exame->getId();
            $response = $this->makeApiRequest($url, 'PUT', $data);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar exame ABO: " . $e->getMessage());
        }
    }

    public function deletar($id) {
        try {
            $url = $this->apiUrl . '/' . $id;
            $response = $this->makeApiRequest($url, 'DELETE');
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao deletar exame ABO: " . $e->getMessage());
        }
    }

    private function mapRowToExame($row) {
        $exame = new ExameABO();
        $exame->setId($row["id"]);
        $exame->setAgendamentoId($row["agendamento_id"]);
        $exame->setPacienteId($row["paciente_id"]);
        $exame->setNome($row["nome"]);
        $exame->setAmostraDna($row["amostra_dna"]);
        $exame->setTipoSanguineo($row["tipo_sanguineo"]);
        $exame->setObservacoes($row["observacoes"]);
        return $exame;
    }
}

class ExameCovidDao {
    
    private $apiUrl = 'http://localhost:3000/api/exames-covid';

    private function makeApiRequest($url, $method = 'GET', $data = null) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response === false) {
            throw new Exception('Erro ao conectar com a API Node.js');
        }
        
        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 400) {
            $errorMessage = isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Erro na API';
            throw new Exception($errorMessage);
        }
        
        return $decodedResponse;
    }

    public function inserir(ExameCovid $exame) {
        try {
            $data = [
                'agendamento_id' => $exame->getAgendamentoId(),
                'paciente_id' => $exame->getPacienteId(),
                'nome' => $exame->getNome(),
                'tipo_teste' => $exame->getTipoTeste(),
                'status_amostra' => $exame->getStatusAmostra(),
                'resultado' => $exame->getResultado(),
                'data_inicio_sintomas' => $exame->getDataInicioSintomas(),
                'sintomas' => $exame->getSintomas(),
                'observacoes' => $exame->getObservacoes()
            ];
            
            $response = $this->makeApiRequest($this->apiUrl, 'POST', $data);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir exame COVID-19: " . $e->getMessage());
        }
    }

    public function buscarPorId($id) {
        try {
            $url = $this->apiUrl . '/' . $id;
            $response = $this->makeApiRequest($url);
            
            if (isset($response['data'])) {
                return $this->mapRowToExame($response['data']);
            }
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar exame COVID-19: " . $e->getMessage());
        }
    }

    public function buscarPorAgendamento($agendamentoId) {
        try {
            $url = $this->apiUrl . '/agendamento/' . $agendamentoId;
            $response = $this->makeApiRequest($url);
            
            $exames = [];
            if (isset($response['data']) && is_array($response['data'])) {
                foreach ($response['data'] as $row) {
                    $exames[] = $this->mapRowToExame($row);
                }
            }
            return $exames;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar exames COVID-19 por agendamento: " . $e->getMessage());
        }
    }

    public function buscarTodos() {
        try {
            $response = $this->makeApiRequest($this->apiUrl);
            
            $exames = [];
            if (isset($response['data']) && is_array($response['data'])) {
                foreach ($response['data'] as $row) {
                    $exame = $this->mapRowToExame($row);
                    if (isset($row['data_consulta'])) $exame->dataConsulta = $row['data_consulta'];
                    if (isset($row['paciente_nome'])) $exame->pacienteNome = $row['paciente_nome'];
                    if (isset($row['paciente_cpf'])) $exame->pacienteCpf = $row['paciente_cpf'];
                    $exame->tipoExame = 'COVID-19';
                    $exames[] = $exame;
                }
            }
            return $exames;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar todos os exames COVID-19: " . $e->getMessage());
        }
    }

    public function atualizar(ExameCovid $exame) {
        try {
            $data = [
                'nome' => $exame->getNome(),
                'tipo_teste' => $exame->getTipoTeste(),
                'status_amostra' => $exame->getStatusAmostra(),
                'resultado' => $exame->getResultado(),
                'data_inicio_sintomas' => $exame->getDataInicioSintomas(),
                'sintomas' => $exame->getSintomas(),
                'observacoes' => $exame->getObservacoes()
            ];
            
            $url = $this->apiUrl . '/' . $exame->getId();
            $response = $this->makeApiRequest($url, 'PUT', $data);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar exame COVID-19: " . $e->getMessage());
        }
    }

    public function deletar($id) {
        try {
            $url = $this->apiUrl . '/' . $id;
            $response = $this->makeApiRequest($url, 'DELETE');
            return $response['success'] ?? false;
        } catch (Exception $e) {
            throw new Exception("Erro ao deletar exame COVID-19: " . $e->getMessage());
        }
    }

    private function mapRowToExame($row) {
        $exame = new ExameCovid();
        $exame->setId($row["id"]);
        $exame->setAgendamentoId($row["agendamento_id"]);
        $exame->setPacienteId($row["paciente_id"]);
        $exame->setNome($row["nome"]);
        $exame->setTipoTeste($row["tipo_teste"]);
        $exame->setStatusAmostra($row["status_amostra"]);
        $exame->setResultado($row["resultado"]);
        $exame->setDataInicioSintomas($row["data_inicio_sintomas"]);
        $exame->setSintomas($row["sintomas"]);
        $exame->setObservacoes($row["observacoes"]);
        return $exame;
    }
}

?>