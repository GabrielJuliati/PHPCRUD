<?php
session_start();

require __DIR__ . '../../../connection/Connection.php';
require __DIR__ . '/../../../modelo/usuario.php';
require __DIR__ . '/../dao/usuarioDao.php';
require __DIR__ . '../../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$usuario = new Usuario();

$usuarioDao = new UsuarioDao();

if (isset($_POST['cadastrar'])) {

    $senha = $_POST["password"];
    $confirmarSenha = $_POST["pyes"];

    if ($senha != $confirmarSenha) {
        $_SESSION['erro'] = "As senhas não são iguais.";
        header("Location: /PHPCRUD/public/cadastro/cadastro.php");
        exit;
    } else {
        $usuario->setName($_POST['nome']);
        $usuario->setEmailInstitucional($_POST['mail']);

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $usuario->setPassword($senha_hash);

        $usuario->setRol($_POST['tipoUsuario']);
        $usuarioDao->inserir($usuario);

        $_SESSION['sucesso'] = "Usuário cadastrado com sucesso!";
        header("Location: /PHPCRUD/public/cadastro/cadastro.php");
        exit;
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

    $consulta = "SELECT * FROM usuario WHERE email = :email";

    $stmt = $connection->prepare($consulta);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Verifique se a consulta retornou um resultado
    if ($stmt->rowCount() > 0) {

        $linha = $stmt->fetch();
        if (!password_verify($senha, $linha["senha"])) {
        $_SESSION['erro'] = "Usuário ou senha incorretos.";
        header("Location: ../login.php");
        exit;
    }

        // Se chegou aqui, senha é correta
        $_SESSION["nome"] = $linha["nome"];
        $_SESSION["rol"] = $linha["rol"];
        $_SESSION["email"] = $linha["email"];

        header("Location: ../../home/home.php");
        exit;
    } else {
        $_SESSION['erro'] = "Usuário ou senha incorretos.";
        header("Location: ../login.php");
        exit;
    }
}

if (isset($_POST['reset'])) {

    $email = $_POST["email"];

    $consulta = "SELECT * FROM usuario WHERE email = :email";

    $stmt = $connection->prepare($consulta);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch();

        $nome = $usuario['nome'];
        $senha_provisoria = "SPPUB@" . $nome;

        // Hash da senha provisória
        $senha_hash = password_hash($senha_provisoria, PASSWORD_DEFAULT);

        // Atualiza a senha no banco
        $update = "UPDATE usuario SET senha = :senha WHERE email = :email";
        $stmt_update = $connection->prepare($update);
        $stmt_update->bindValue(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt_update->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt_update->execute();

        // Envia o e-mail com PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sps.ti.no.reply@gmail.com';  // SEU EMAIL
            $mail->Password = 'xdop biyy tpbx wheu';      // SUA APP PASSWORD
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Remetente e destinatário
            $mail->setFrom('sps.ti.no.reply@gmail.com', 'Sistema SPS');
            $mail->addAddress($email, $nome);

            // Conteúdo
            $mail->isHTML(false);
            $mail->Subject = "Recuperação de Senha - Sistema Positivo de Saúde";
            $mail->Body = "Olá $nome,\n\nSua nova senha provisória é: $senha_provisoria\n\nPor favor, altere sua senha após o login.";

            $mail->send();

            $_SESSION['sucesso'] = "Senha provisória enviada para o e-mail institucional.";
            header("Location: ../forgotPassword.php");
            exit;

        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro ao enviar e-mail: {$mail->ErrorInfo}";
            header("Location: ../forgotPassword.php");
            exit;
        }

    } else {
        $_SESSION['erro'] = "E-mail não cadastrado.";
        header("Location: ../forgotPassword.php");
        exit;
    }
}

if (isset($_POST['alterar'])) {

    $email = $_SESSION["email"];  // Ajuste se armazenar email na sessão!
    $senha_atual = $_POST['passwordAtual'];
    $nova_senha = $_POST['password'];
    $confirmar_senha = $_POST['pyes'];

    if ($nova_senha !== $confirmar_senha) {
        $_SESSION['erro'] = "As senhas não coincidem.";
        header("Location: ../resetPassword.php");
        exit;
    }

    // Pega senha atual
    $consulta = "SELECT senha FROM usuario WHERE email = :email";
    $stmt = $connection->prepare($consulta);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch();

        if (!password_verify($senha_atual, $usuario['senha'])) {
            $_SESSION['erro'] = "Senha atual incorreta.";
            header("Location: ../resetPassword.php");
            exit;
        }

        // Atualiza nova senha
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $update = "UPDATE usuario SET senha = :senha WHERE email = :email";

        $stmt_update = $connection->prepare($update);
        
        $stmt_update->bindValue(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt_update->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt_update->execute();

        $_SESSION['sucesso'] = "Senha alterada com sucesso!";
        header("Location: ../resetPassword.php");
        exit;

    } else {
        $_SESSION['erro'] = "Erro de seção.";
        header("Location: ../login.php");
        exit;
    }
}
?>