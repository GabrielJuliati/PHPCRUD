<?php 
session_start();

require("../../connection/Connection.php");
require("../model/Agendamento.php");
require("../dao/AgendamentoDAO.php");

$agendamento = new Agendamento();

$agendamentoDao = new AgendamentoDao();

if(isset($_POST['cadastrar-agendamento'])) {
    
}
?>