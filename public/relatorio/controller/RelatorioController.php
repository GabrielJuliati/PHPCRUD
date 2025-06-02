<?php
require_once(__DIR__ . '/../dao/AgendamentoDAO.php');

class RelatorioController {
    public static function handleRequest() {

        if (isset($_POST['adicionar_relatorio'])) {
            AgendamentoDAO::adicionar($_POST['nome'], $_POST['tipo_exame'], $_POST['data_exame']);
            $_SESSION['mensagem'] = "Registro adicionado com sucesso!";
        } elseif (isset($_POST['atualizar_relatorio'])) {
            AgendamentoDAO::atualizar($_POST['id'], $_POST['nome'], $_POST['tipo_exame'], $_POST['data_exame']);
            $_SESSION['mensagem'] = "Registro atualizado com sucesso!";
        } elseif (isset($_POST['excluir_relatorio'])) {
            AgendamentoDAO::excluir($_POST['id']);
            $_SESSION['mensagem'] = "Registro excluído com sucesso!";
        }

    }

    public static function getEdicao($id) {
        return AgendamentoDAO::buscarPorId($id);
    }

    public static function listarTodos() {
        return AgendamentoDAO::listarTodos();
    }
}
?>
