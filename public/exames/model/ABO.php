<?php

class ABO{
    private $id;
    private $nome;
    private $descricao;
    private $amostraSangue;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNomeExame() {
        return $this->nome;
    }

    public function setNomeExame($nomeExame) {
        $this->nome = $nomeExame;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getAmostraSangue() {
        return $this->amostraSangue;
    }

    public function setAmostraSangue($amostraSangue) {
        $this->amostraSangue = $amostraSangue;
    }
}

?>