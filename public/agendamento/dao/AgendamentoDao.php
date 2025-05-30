<?php 
class AgendamentoDao {

    public function inserir(Agendamento $agendamento) {
        try {
            $sql = "INSERT INTO agendamento (nome, dataConsulta, tipoExame)
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

    public function read() {
        try {
            $sql = "SELECT * FROM agendamento";
            $conn = ConnectionFactory::getConnection()->query($sql);
            $lista = $conn->fetchAll(PDO::FETCH_ASSOC);
            $agdList = array();
            foreach($lista as $agd) {
                $agdList[] = $this->listaAgendamento($agd);
            }
            echo "Temos ". count($agdList) . " cadastros no banco.";
            return $agdList;
        } catch (PDOException $ex) {
            echo "<p>Ocorreu um erro ao executar a consulta </p> {$ex}";
        }
    }

    public function listaAgendamento($row) {
        $agendamento = new Agendamento();
        $agendamento->setNome($row['nome']);
        $agendamento->setDataConsulta($row['dataConsulta']);
        $agendamento->setTipoExame($row['tipoExame']);
        return $agendamento; 
    }
}
?>