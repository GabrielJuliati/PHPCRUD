<?php
session_start();

require __DIR__ . '../../../connection/Connection.php';
require __DIR__ . '/../../../modelo/paciente.php';
require __DIR__ . '/../dao/pacienteDao.php';

$paciente = new Paciente();
$pacienteDao = new PacienteDao();

if (isset($_POST['cadastrar'])) {
    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);
    $telefone = trim($_POST['telefone']);
    $endereco = trim($_POST['endereco']);
    $observacoes = trim($_POST['observacoes']);
    $dataNascimento = trim($_POST['nascimento']);

    $sucesso = $pacienteDao->inserir($nome, $cpf, $telefone, $endereco, $observacoes, $dataNascimento);
    if ($sucesso) {
        $_SESSION['sucesso'] = "Paciente cadastrado com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao cadastrar paciente.";
    }
    header("Location: ../cadastroPaciente.php");
    exit;
}
?>