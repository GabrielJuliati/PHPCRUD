<?php
    class Paciente{
        private $id;
        private $nome;
        private $dataNascimento;
        private $endereco;
        private $telefone;
        private $cpf;
        private $observacoes;

        public function getId() {
            return $this->id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getDataNascimento() {
            return $this->dataNascimento;
        }

        public function getEndereco() {
            return $this->endereco;
        }

        public function getTelefone() {
            return $this->telefone;
        }

        public function getCpf() {
            return $this->cpf;
        }

        public function getObservacoes() {
            return $this->observacoes;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setDataNascimento($dataNascimento) {
            $this->dataNascimento = $dataNascimento;
        }

        public function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        public function setCpf($cpf) {
            $this->cpf = $cpf;
        }

        public function setObservacoes($observacoes) {
            $this->observacoes = $observacoes;
        }

        public function __toString(){
            return "Paciente - Id: {$this->id} - Nome: {$this->nome} - Data de nascimento: {$this->dataNascimento} - Endereço: {$this->endereco} - Telefone: {$this->telefone} - CPF: {$this->cpf} - Observações: {$this->observacoes}";
        }
    }
?>