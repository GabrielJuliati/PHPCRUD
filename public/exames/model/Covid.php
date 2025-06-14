<?php 
class Covid{
    private $id;
    private $nome;
    private $descricao;
    private $amostraDna;

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

    public function getAmostraDna() {
        return $this->amostraDna;
    }

    public function setAmostraDna($amostraDna) {
        $this->amostraDna = $amostraDna;
    }
}

?>