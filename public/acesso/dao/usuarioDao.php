<?php
class UsuarioDao{

    public function inserir(Usuario $usu){
        try{
            $sql = "INSERT INTO usuario (nome, email, senha, rol)
                VALUES (:nome, :email, :senha, :rol)";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":nome", $usu->getName());
            $conn->bindValue(":email", $usu->getEmailInstitucional());
            $conn->bindValue(":senha", $usu->getPassword());
            $conn->bindValue(":rol", $usu->getRol());
            return $conn->execute(); # executa o insert
        }catch(PDOException $ex){
            echo "<p> Erro </p> <p> $ex </p>";
        }
    }
}
?>