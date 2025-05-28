<?php 
class Exames{
    private $id;
    private $nomeExame;
    
    function __construct($id, $nome){
        $this->id = $id;
        $this->nomeExame = $nome;
    }
}
?>