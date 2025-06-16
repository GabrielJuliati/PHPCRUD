<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../modelo/ConnectionFactory.php');

if (isset($_POST['cadastrar'])) {
    $agendamento_id = $_POST['agendamento_id'];
    $paciente_id = $_POST['paciente_id'];
    $nome = $_POST['nome'];
    $amostra_sangue = $_POST['amostra_sangue'];
    $data_inicio_sintomas = $_POST['data_inicio_sintomas'];

    try {
        $conn = ConnectionFactory::getConnection();

        // Verify that the agendamento exists
        $stmt_agendamento = $conn->prepare("SELECT id FROM agendamento WHERE id = :agendamento_id");
        $stmt_agendamento->bindParam(':agendamento_id', $agendamento_id);
        $stmt_agendamento->execute();
        $agendamento = $stmt_agendamento->fetch(PDO::FETCH_ASSOC);

        if ($agendamento) {
            // Insert Dengue exam data
            $stmt_exame = $conn->prepare("INSERT INTO EXAME_DENGUE (agendamento_id, paciente_id, nome, amostra_sangue, data_inicio_sintomas) VALUES (:agendamento_id, :paciente_id, :nome, :amostra_sangue, :data_inicio_sintomas)");
            $stmt_exame->bindParam(':agendamento_id', $agendamento_id);
            $stmt_exame->bindParam(':paciente_id', $paciente_id);
            $stmt_exame->bindParam(':nome', $nome);
            $stmt_exame->bindParam(':amostra_sangue', $amostra_sangue);
            $stmt_exame->bindParam(':data_inicio_sintomas', $data_inicio_sintomas);

            if ($stmt_exame->execute()) {
                echo "<script>alert('Exame de Dengue cadastrado com sucesso!'); window.location.href = '../agendamentos.php';</script>";
                exit();
            } else {
                echo "<script>alert('Erro ao cadastrar exame de Dengue.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Agendamento não encontrado. Por favor, verifique o ID do agendamento.'); window.history.back();</script>";
        }

    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Acesso inválido.'); window.history.back();</script>";
}
?>

