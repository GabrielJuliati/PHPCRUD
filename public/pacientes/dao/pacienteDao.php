<?php

require_once __DIR__ . '../../../connection/Connection.php';

class PacienteDao{
    private \PDO $conn;

    public function __construct() {
        $this->conn = ConnectionFactory::getConnection();
    }

    public function inserir($nome, $cpf, $telefone, $endereco, $observacoes, $dataNascimento) {
        $sql = "INSERT INTO paciente (nome, cpf, telefone, endereco, observacoes, data_nascimento) VALUES (:nome, :cpf, :telefone, :endereco, :observacoes, :dataNascimento)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindValue(':endereco', $endereco, PDO::PARAM_STR);
        $stmt->bindValue(':observacoes', $observacoes, PDO::PARAM_STR);
        $stmt->bindValue(':dataNascimento', $dataNascimento, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
