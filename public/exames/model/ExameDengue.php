<?php 
class ExameDengue{
    private $id;
    private $tipoExame;
    private $amostraSangue;
    private $dataInicioSintomas;

    function __construct($id, $tipo, $amostraSangue, $dataInicio){
        $this->id = $id;
        $this->tipoExame = $tipo;
        $this->amostraSangue = $amostraSangue;
        $this->dataInicioSintomas = $dataInicio;
    }
}
?>