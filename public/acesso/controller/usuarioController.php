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
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['password'];
    $confirmar = $_POST['pyes'];
    $rol = $_POST['tipoUsuario'];

    if ($senha !== $confirmar) {
        $_SESSION['erro'] = "As senhas não são iguais.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sucesso = $usuarioDao->inserir($nome, $email, $senhaHash, $rol);
        if ($sucesso) {
            $_SESSION['sucesso'] = "Usuário cadastrado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar usuário.";
        }
    }
    header("Location: ../../cadastro/cadastro.php");
    exit;
}

if (isset($_POST['excluir'])) {
    $idExcluir = (int) $_POST['excluir'];

    // Garante que não pode excluir a si mesmo
    if ($idExcluir === $_SESSION['id']) {
        $_SESSION['erro'] = "Você não pode excluir a si mesmo.";
        header("Location: ../../cadastro/cadastro.php");
        exit;
    }

    if ($usuarioDao->deleteById($idExcluir)) {
        $_SESSION['sucesso'] = "Usuário excluído com sucesso!";
    } else {
        $_SESSION['erro'] = "Falha ao excluir usuário.";
    }
    header("Location: ../../cadastro/cadastro.php");
    exit;
}

if (isset($_POST['atualizar'])) {
    $id       = (int) $_POST['id'];
    $nome     = trim($_POST['nome']);
    $email    = trim($_POST['email']);
    $rol      = $_POST['tipoUsuario'];

    // Só atualiza nome, email e rol. Não mexe em senha aqui.
    $sucesso = $usuarioDao->update($id, $nome, $email, $rol);
    if ($sucesso) {
        $_SESSION['sucesso'] = "Usuário atualizado com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao atualizar usuário.";
    }
    header("Location: ../../cadastro/cadastro.php");
    exit;
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $usuario = $usuarioDao->findByEmail($email);
    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        $_SESSION['erro'] = "Usuário ou senha incorretos.";
        header("Location: ../login.php");
        exit;
    }

    $_SESSION["id"] = $usuario["id"];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['rol']  = $usuario['rol'];
    $_SESSION['email'] = $usuario['email'];

    header("Location: ../../home/home.php");
    exit;
}


if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $usuario = $usuarioDao->findByEmail($email);

    if (!$usuario) {
        $_SESSION['erro'] = "E-mail não cadastrado.";
        header("Location: ../forgotPassword.php");
        exit;
    }

    $nome = $usuario['nome'];
    $senha_provisoria = "SPPUB@" . $nome;
    $senha_hash = password_hash($senha_provisoria, PASSWORD_DEFAULT);

    $usuarioDao->updatePassword($email, $senha_hash);

    // Envio de e-mail
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sps.ti.no.reply@gmail.com';
        $mail->Password = 'rhjm pakk gtfg cukg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('sps.ti.no.reply@gmail.com', 'Sistema SPS');
        $mail->addAddress($email, $nome);
        $mail->isHTML(false);
        $mail->Subject = "Recuperação de Senha - Sistema Positivo de Saúde";
        $mail->Body = "Olá $nome,\n\nSua nova senha provisória é: $senha_provisoria\n\nPor favor, altere sua senha após o login.";

        $mail->send();
        $_SESSION['sucesso'] = "Senha provisória enviada para o e-mail institucional.";
    } catch (Exception $e) {
        $_SESSION['erro'] = "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
    header("Location: ../forgotPassword.php");
    exit;
}

if (isset($_POST['alterar'])) {
    $email = $_SESSION['email'];
    $senha_atual = $_POST['passwordAtual'];
    $nova = $_POST['password'];
    $confirmar = $_POST['pyes'];

    if ($nova !== $confirmar) {
        $_SESSION['erro'] = "As senhas não coincidem.";
    } else {
        $usuario = $usuarioDao->findByEmail($email);
        if (!$usuario || !password_verify($senha_atual, $usuario['senha'])) {
            $_SESSION['erro'] = "Senha atual incorreta.";
        } else {
            $hash = password_hash($nova, PASSWORD_DEFAULT);
            $usuarioDao->updatePassword($email, $hash);
            $_SESSION['sucesso'] = "Senha alterada com sucesso!";
        }
    }
    header("Location: ../resetPassword.php");
    exit;
}
?>