<?php 
    class Agendamento {
        
        private $nome;
        private $dataConsulta;
        private $tipoExame;

        public function getNome() {
            return $this->nome;
        }

        public function setNome($nome) {
            return $this->nome = $nome;
        }

        public function getDataConsulta() {
            return $this->dataConsulta;
        }

        public function setDataConsulta($dataConsulta) {
            return $this->dataConsulta = $dataConsulta;
        }

        public function getTipoExame() {
            return $this->tipoExame;
        }

        public function setTipoExame($tipoExame) {
            return $this->tipoExame = $tipoExame;
        }

    }
?>