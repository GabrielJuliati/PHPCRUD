<?php
session_start();

require __DIR__ . '../../../connection/Connection.php';
require __DIR__ . '/../../../modelo/usuario.php';
require __DIR__ . '/../dao/usuarioDao.php';

$usuario = new Usuario();

$usuarioDao = new UsuarioDao();

if (isset($_POST['cadastrar'])) {

    $senha = $_POST["password"];
    $confirmarSenha = $_POST["pyes"];
    $erro = "";

    if ($senha != $confirmarSenha) {
        echo "Error: Erro no recebimento de senha iguais!";
        exit;
    } else {
        $usuario->setName($_POST['nome']);
        $usuario->setEmailInstitucional($_POST['mail']);
        $usuario->setPassword($_POST['password']);
        $usuario->setRol($_POST['tipoUsuario']);
        $usuarioDao->inserir($usuario);
        header("Location: /PHPCRUD/public/cadastro/cadastro.php");
    }
}

function listar()
{

    /*$usuarioDao = new UsuarioDao();

    $lista = $usuarioDao->read();

    foreach ($lista as $l) {
        echo "<tr>
            <td> {$l->getId()} </td>
            <td> {$l->getNome()} </td>
            <td> {$l->getEndereco()} </td>
            <td> {$l->getDocumento()} </td>
            <td> 
                <a href='index.php?editar={$l->getId()}'> <i class='bi bi-pencil-square'></i>Editar</a> 
                <a href='#'> <i class='bi bi-trash3'></i>Excluir</a> 
            </td>
        </tr>";
    }*/
}

$connection = ConnectionFactory::getConnection();

if (isset($_POST['login'])) {
    // Obtenha os dados do formulário de login
    $email = $_POST["email"];
    $senha = $_POST["password"];

    $consulta = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";

    $stmt = $connection->prepare($consulta);
    $stmt->execute();

    // Verifique se a consulta retornou um resultado
    if ($stmt->rowCount() > 0) {
        // Compare a senha informada com a senha armazenada no banco de dados
        $linha = $stmt->fetch();
        if ($linha["senha"] == $senha) {
            // Libere o acesso ao sistema
            $_SESSION["nome"] = $linha["nome"];
            $_SESSION["rol"] = $linha["rol"];
            header("Location: ../../home/home.php");
            exit;
        }
    } else {
        $erro = "Usuário ou senha não encontrado.";
        header("Location: ../login.php?erro=$erro");
        exit;
    }
}
?>