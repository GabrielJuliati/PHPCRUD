<?php 
class Exames{
    private $id;
    private $nomeExame;
    private $descricao;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNomeExame() {
        return $this->nomeExame;
    }

    public function setNomeExame($nomeExame) {
        $this->nomeExame = $nomeExame;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}
?>