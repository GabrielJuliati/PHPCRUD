<?php 
class AgendamentoDao {

    public function inserir(Agendamento $agendamento) {
        try {
            $sql = "INSERT INTO agendamento (nome, data_consulta, tipo_exame)
                    VALUES (:nome, :dataConsulta, :tipoExame)";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":nome", $agendamento->getNome());
            $conn->bindValue(":dataConsulta", $agendamento->getDataConsulta());
            $conn->bindValue(":tipoExame", $agendamento->getTipoExame());
            return $conn->execute();
        } catch(PDOException $ex) {
            echo "<p> Erro </p> <p> $ex </p>";
        }
    }

    public function atualizar(Agendamento $agd) {
        $conn = ConnectionFactory::getConnection();
        $sql = "UPDATE agendamento SET nome = :nome, data_consulta = :data, tipo_exame = :exame WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":nome", $agd->getNome());
        $stmt->bindValue(":data", $agd->getDataConsulta());
        $stmt->bindValue(":exame", $agd->getTipoExame());
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
        try {
            $sql = "SELECT * FROM agendamento";
            $conn = ConnectionFactory::getConnection()->query($sql);
            $lista = $conn->fetchAll(PDO::FETCH_ASSOC);
            $agdList = array();
            foreach($lista as $agd) {
                $agdList[] = $this->listaAgendamento($agd);
            }
            return $agdList;
        } catch (PDOException $ex) {
            echo "<p>Ocorreu um erro ao executar a consulta </p> {$ex}";
        }
    }

    public function listaAgendamento($row) {
        $agendamento = new Agendamento();
        $agendamento->setId($row['id']);
        $agendamento->setNome($row['nome']);
        $agendamento->setDataConsulta($row['data_consulta']);
        $agendamento->setTipoExame($row['tipo_exame']);
        return $agendamento; 
    }

    public function buscarPorId($id) {
        $conn = ConnectionFactory::getConnection();
        $sql = "SELECT * FROM agendamento WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch()) {
            $agd = new Agendamento();
            $agd->setId($row['id']);
            $agd->setNome($row['nome']);
            $agd->setDataConsulta($row['data_consulta']);
            $agd->setTipoExame($row['tipo_exame']);
            return $agd;
        }

        return null;
    }
}
?>