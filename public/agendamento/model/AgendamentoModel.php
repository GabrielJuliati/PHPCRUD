<?php 
    class Agendamento {
        
        private $nome;
        private $dataConsulta;
        private $tipoExame;
    
        function __construct($nome, $dataConsulta, $tipoExame) {
            $this->nome = $nome;
            $this->dataConsulta = $dataConsulta;
            $this->tipoExame = $tipoExame;
        }
        
    }
?>