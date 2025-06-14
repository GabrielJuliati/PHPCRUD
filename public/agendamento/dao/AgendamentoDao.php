<?php 
class AgendamentoDao {

    public function inserir($agendamento) {
        $conn = ConnectionFactory::getConnection();
        $sql = "INSERT INTO agendamento (paciente_id, data_consulta, tipo_exame) VALUES (:paciente_id, :data_consulta, :tipo_exame)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":paciente_id", $agendamento->getPacienteId());
        $stmt->bindParam(":data_consulta", $agendamento->getDataConsulta());
        $stmt->bindParam(":tipo_exame", $agendamento->getTipoExame());
        return $stmt->execute();
    }

    public function atualizar(Agendamento $agd) {
        $conn = ConnectionFactory::getConnection();
        $sql = "UPDATE agendamento SET data_consulta = :data, paciente_id = :paciente_id, tipo_exame = :tipo_exame WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":data", $agd->getDataConsulta());
        $stmt->bindValue(":paciente_id", $agd->getPacienteId());
        $stmt->bindValue(":tipo_exame", $agd->getTipoExame());
        $stmt->bindValue(":id", $agd->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

  public function delete($id) {
    try {
        $conn = ConnectionFactory::getConnection();
        $sql = "DELETE FROM agendamento WHERE agendamento.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao excluir: " . $e->getMessage();
        return false;
    }
}

    public function read() {
        $sql = "SELECT a.id, a.data_consulta, a.tipo_exame, p.nome AS paciente_nome, p.cpf AS paciente_cpf 
                FROM agendamento a 
                JOIN paciente p ON a.paciente_id = p.id";
        $conn = ConnectionFactory::getConnection();
        $stmt = $conn->query($sql);
        $agendamentos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $agendamentos[] = $this->listaAgendamento($row);
        }   
        return $agendamentos;
    }

    public function listaAgendamento($row) {
        $agendamento = new Agendamento();
        $agendamento->setId($row['id']);
        $agendamento->setPacienteNome($row['paciente_nome']);
        $agendamento->setDataConsulta($row['data_consulta']);
        $agendamento->setPacienteCpf($row['paciente_cpf']);
        $agendamento->setTipoExame($row['tipo_exame']);
        return $agendamento; 
    }
    
public function buscarPorId($id) {
    $conn = ConnectionFactory::getConnection();
    $sql = "SELECT a.id, a.data_consulta, a.tipo_exame, 
                   a.paciente_id, p.nome AS paciente_nome, p.cpf AS paciente_cpf 
            FROM agendamento a 
            JOIN paciente p ON a.paciente_id = p.id 
            WHERE a.id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Use FETCH_ASSOC for consistency
        $agd = new Agendamento();
        $agd->setId($row["id"]);
        $agd->setDataConsulta($row["data_consulta"]);
        $agd->setPacienteId($row["paciente_id"]); // Set patient_id
        $agd->setPacienteNome($row["paciente_nome"]); // Set patient_name from join
        $agd->setPacienteCpf($row["paciente_cpf"]);   // Set patient_cpf from join
        $agd->setTipoExame($row["tipo_exame"]); // Set tipo_exame_string
        return $agd;
    }

    return null;
}


    public function buscarPorCpf($cpf) {
        $conn = ConnectionFactory::getConnection();
        $sql = "SELECT a.id, a.data_consulta, a.tipo_exame, p.nome AS paciente_nome, p.cpf AS paciente_cpf 
                FROM agendamento a 
                JOIN paciente p ON a.paciente_id = p.id 
                WHERE p.cpf LIKE :cpf";
        $stmt = $conn->prepare($sql);
        $searchTerm = '%' . $cpf . '%';

        $stmt->bindParam(":cpf", $searchTerm);
        $stmt->execute();
        $agendamentos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $agendamentos[] = $this->listaAgendamento($row);
        }
        return $agendamentos;
    }

}
?>