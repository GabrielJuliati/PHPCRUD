<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__."../../../connection/Connection.php");
require_once(__DIR__."../../model/Agendamento.php");
require_once(__DIR__."../../dao/AgendamentoDAO.php");

$agendamento = new Agendamento();

$agendamentoDao = new AgendamentoDao();

//Cadastro agendamento
if(isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $dataConsulta = $_POST['data_consulta'];
    $tipoExame = $_POST['tipo_exame'];

    $agendamento->setNome($_POST['nome']);
    $agendamento->setDataConsulta($_POST['data_consulta']);
    $agendamento->setTipoExame($_POST['tipo_exame']);
    $agendamentoDao->inserir($agendamento);
    header("Location: ../agendamentos.php");
}

if(isset($_POST['editar?id'])) { 
    $agendamento->setId($id);
    $agendamento->setNome($_POST['nome']);
    $agendamento->setDataConsulta($_POST['dataConsulta']);
    $agendamento->setTipoExame($_POST['tipoExame']);
    
    $resultado = $agendamentoDao->atualizar($agendamento);
}

if(isset($_POST['excluir?id'])) {
    $agendamento->setId($id);

    $resultado = $agendamentoDao->delete($agendamento);
}


function listar() {
    $agendamentoDao = new AgendamentoDao();
    $lista = $agendamentoDao->read();

    foreach ($lista as $agd) {
        echo "<tr>
                <td>{$agd->getId()}</td>
                <td>{$agd->getNome()}</td>
                <td>{$agd->getDataConsulta()}</td>
                <td>{$agd->getTipoExame()}</td>
                <td>
                    <div class='d-flex gap-2'>
                        <a href='editar.php?editar={$agd->getId()}' class='btn btn-sm btn-warning'>
                            <i class='bi bi-pencil-square'></i> Editar
                        </a>
                        <form method='POST' action='agendamentos.php' onsubmit=\"return confirm('Tem certeza que deseja excluir este agendamento?');\">
                            <input type='hidden' name='excluir' value=' {$agd->getId()} '>
                            <button type='submit' class='btn btn-sm btn-danger'>
                                <i class='bi bi-trash'></i> Excluir
                            </button>
                        </form>
                    </div>
                </td>
            </tr>";
    }
}


?>