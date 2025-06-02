<?php
require_once(__DIR__ . '/../../connection/Connection.php');
require_once(__DIR__ . '/../model/Agendamento.php');

class AgendamentoDAO {
    public static function listarTodos() {
        $conn = ConnectionFactory::getConnection();
        $stmt = $conn->query("SELECT * FROM AGENDAMENTO ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId($id) {
        $conn = ConnectionFactory::getConnection();
        $stmt = $conn->prepare("SELECT * FROM AGENDAMENTO WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function adicionar($nome, $tipo_exame, $data_exame) {
        $conn = ConnectionFactory::getConnection();
        $stmt = $conn->prepare("INSERT INTO AGENDAMENTO (nome_paciente, tipo_exame, data_exame) VALUES (:nome, :tipo_exame, :data_exame)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':tipo_exame', $tipo_exame);
        $stmt->bindParam(':data_exame', $data_exame);
        $stmt->execute();
    }

    public static function atualizar($id, $nome, $tipo_exame, $data_exame) {
        $conn = ConnectionFactory::getConnection();
        $stmt = $conn->prepare("UPDATE AGENDAMENTO SET nome_paciente = :nome, tipo_exame = :tipo_exame, data_exame = :data_exame WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':tipo_exame', $tipo_exame);
        $stmt->bindParam(':data_exame', $data_exame);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function excluir($id) {
        $conn = ConnectionFactory::getConnection();
        $stmt = $conn->prepare("DELETE FROM AGENDAMENTO WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
