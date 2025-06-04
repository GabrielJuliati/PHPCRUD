<?php
require_once __DIR__ . '/../../connection/Connection.php';

class PacienteDao {

    public function inserir($nome, $cpf, $telefone, $endereco, $observacoes, $dataNascimento) {
        try {
            $sql = "INSERT INTO paciente (nome, cpf, telefone, endereco, observacoes, data_nascimento)
                    VALUES (:nome, :cpf, :telefone, :endereco, :observacoes, :dataNascimento)";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(':nome', $nome, PDO::PARAM_STR);
            $conn->bindValue(':cpf', $cpf, PDO::PARAM_STR);
            $conn->bindValue(':telefone', $telefone, PDO::PARAM_STR);
            $conn->bindValue(':endereco', $endereco, PDO::PARAM_STR);
            $conn->bindValue(':observacoes', $observacoes, PDO::PARAM_STR);
            $conn->bindValue(':dataNascimento', $dataNascimento, PDO::PARAM_STR);
            return $conn->execute();
        } catch (PDOException $ex) {
            echo "<p> Erro </p> <p> $ex </p>";
        }
    }

    public function listarTodos() {
        try {
            $sql = "SELECT * FROM paciente";
            $conn = ConnectionFactory::getConnection()->query($sql);
            return $conn->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo "<p>Ocorreu um erro ao executar a consulta </p> {$ex}";
        }
    }

    public function atualizar($id, $nome, $cpf, $telefone, $endereco, $observacoes, $dataNascimento) {
        try {
            $sql = "UPDATE paciente 
                    SET nome = :nome, cpf = :cpf, telefone = :telefone, endereco = :endereco,
                        observacoes = :observacoes, data_nascimento = :dataNascimento
                    WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(':nome', $nome);
            $conn->bindValue(':cpf', $cpf);
            $conn->bindValue(':telefone', $telefone);
            $conn->bindValue(':endereco', $endereco);
            $conn->bindValue(':observacoes', $observacoes);
            $conn->bindValue(':dataNascimento', $dataNascimento);
            $conn->bindValue(':id', $id, PDO::PARAM_INT);
            return $conn->execute();
        } catch (PDOException $ex) {
            echo "<p> Erro </p> <p> $ex </p>";
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM paciente WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(':id', $id, PDO::PARAM_INT);
            return $conn->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir: " . $e->getMessage();
            return false;
        }
    }

    public function buscarPorCpf($cpf) {
        try {
            $sql = "SELECT * FROM paciente WHERE cpf LIKE :cpf";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(':cpf', "%$cpf%", PDO::PARAM_STR);
            $conn->execute();
            return $conn->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo "<p> Erro </p> <p> $ex </p>";
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM paciente WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(':id', $id, PDO::PARAM_INT);
            $conn->execute();
            return $conn->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo "<p> Erro </p> <p> $ex </p>";
        }
    }
}
