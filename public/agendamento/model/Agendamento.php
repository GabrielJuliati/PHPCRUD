<?php 
    class Agendamento {
        
        private $id;
        private $nome;
        private $dataConsulta;
        private $cpf;
        private $tipoExame;

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            return $this->id = $id;
        }

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

        public function getCpf() {
            return $this->cpf;
        }

        public function setCpf($cpf) {
            return $this->cpf = $cpf;
        }

        public function getTipoExame() {
            return $this->tipoExame;
        }

        public function setTipoExame($tipoExame) {
            return $this->tipoExame = $tipoExame;
        }

    }
?>