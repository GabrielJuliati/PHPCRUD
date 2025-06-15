<?php

require_once("ConnectionFactory.php");

class ExameDengueDao {
    private $conn;

    public function __construct() {
        $this->conn = ConnectionFactory::getConnection();
    }

    public function inserir($exameDengue) {
        $sql = "INSERT INTO EXAME_DENGUE (nome, amostra_sangue, data_inicio_sintomas, agendamento_id, paciente_id) 
                VALUES (:nome, :amostra_sangue, :data_inicio_sintomas, :agendamento_id, :paciente_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $exameDengue->getNome());
        $stmt->bindParam(":amostra_sangue", $exameDengue->getAmostraSangue());
        $stmt->bindParam(":data_inicio_sintomas", $exameDengue->getDataInicioSintomas());
        $stmt->bindParam(":agendamento_id", $exameDengue->getAgendamentoId());
        $stmt->bindParam(":paciente_id", $exameDengue->getPacienteId());
        return $stmt->execute();
    }

    public function buscarPorAgendamento($agendamentoId) {
        $sql = "SELECT * FROM EXAME_DENGUE WHERE agendamento_id = :agendamento_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":agendamento_id", $agendamentoId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class ExameAboDao {
    private $conn;

    public function __construct() {
        $this->conn = ConnectionFactory::getConnection();
    }

    public function inserir($exameAbo) {
        $sql = "INSERT INTO EXAME_ABO (nome, amostra_sangue, agendamento_id, paciente_id) 
                VALUES (:nome, :amostra_sangue, :agendamento_id, :paciente_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $exameAbo->getNome());
        $stmt->bindParam(":amostra_sangue", $exameAbo->getAmostraSangue());
        $stmt->bindParam(":agendamento_id", $exameAbo->getAgendamentoId());
        $stmt->bindParam(":paciente_id", $exameAbo->getPacienteId());
        return $stmt->execute();
    }

    public function buscarPorAgendamento($agendamentoId) {
        $sql = "SELECT * FROM EXAME_ABO WHERE agendamento_id = :agendamento_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":agendamento_id", $agendamentoId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class ExameCovidDao {
    private $conn;

    public function __construct() {
        $this->conn = ConnectionFactory::getConnection();
    }

    public function inserir($exameCovid) {
        $sql = "INSERT INTO EXAME_COVID_19 (nome, amostra_dna, agendamento_id, paciente_id) 
                VALUES (:nome, :amostra_dna, :agendamento_id, :paciente_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $exameCovid->getNome());
        $stmt->bindParam(":amostra_dna", $exameCovid->getAmostraDna());
        $stmt->bindParam(":agendamento_id", $exameCovid->getAgendamentoId());
        $stmt->bindParam(":paciente_id", $exameCovid->getPacienteId());
        return $stmt->execute();
    }

    public function buscarPorAgendamento($agendamentoId) {
        $sql = "SELECT * FROM EXAME_COVID_19 WHERE agendamento_id = :agendamento_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":agendamento_id", $agendamentoId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>

