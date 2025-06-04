<?php
require_once(__DIR__ . '/../dao/RelatorioDAO.php');

class RelatorioController {
    public static function handleRequest() {
        session_start();

        if (isset($_POST['adicionar_relatorio'])) {
            RelatorioDAO::adicionar(
                $_POST['nome'],
                $_POST['tipo_exame'],
                $_POST['data_exame'],
                $_POST['resultado'],
                $_POST['observacao']
            );
            $_SESSION['mensagem'] = "Relatório adicionado com sucesso!";
        } elseif (isset($_POST['atualizar_relatorio'])) {
            RelatorioDAO::atualizar(
                $_POST['id'],
                $_POST['nome'],
                $_POST['tipo_exame'],
                $_POST['data_exame'],
                $_POST['resultado'],
                $_POST['observacao']
            );
            $_SESSION['mensagem'] = "Relatório atualizado com sucesso!";
        } elseif (isset($_POST['excluir_relatorio'])) {
            RelatorioDAO::excluir($_POST['id']);
            $_SESSION['mensagem'] = "Relatório excluído com sucesso!";
        }
    }

    public static function getEdicao($id) {
        return RelatorioDAO::buscarPorId($id);
    }

    public static function listarTodos() {
        return RelatorioDAO::listarTodos();
    }
}
?>
