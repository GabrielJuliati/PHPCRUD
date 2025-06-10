<?php 
class ExamesDao{

    public function atualizar(Exames $exm) {
        $conn = ConnectionFactory::getConnection();
        $sql = "UPDATE exames SET nome_exame = :nome, descricao = :descricao WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":nome", $exm->getNomeExame());
        $stmt->bindValue(":descricao", $exm->getDescricao());
        $stmt->bindValue(":id", $exm->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        try {
            $conn = ConnectionFactory::getConnection();
            $sql = "DELETE FROM exames WHERE exames.id = :id";
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
            $sql = "SELECT * FROM exames";
            $conn = ConnectionFactory::getConnection()->query($sql);
            $lista = $conn->fetchAll(PDO::FETCH_ASSOC);
            $exList = array();
            foreach($lista as $exm) {
                $exList[] = $this->listaExames($exm);
            }
            return $exList;
        } catch (PDOException $ex) {
            echo "<p>Ocorreu um erro ao executar a consulta </p> {$ex}";
        }
    }

    public function listaExames($row) {
        $exames = new Exames();
        $exames->setId($row['id']);
        $exames->setNomeExame($row['nome_exame']);
        $exames->setDescricao($row['descricao']);
        return $exames; 
    }

    public function buscarPorId($id) {
        $conn = ConnectionFactory::getConnection();
        $sql = "SELECT * FROM exames WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch()) {
            $exm = new Exames();
            $exm->setId($row['id']);
            $exm->setNomeExame($row['nome_exame']);
            $exm->setDescricao($row['descricao']);
            return $exm;
        }

        return null;
    }

}
?>