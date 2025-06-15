<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__."../../../connection/Connection.php");
require_once(__DIR__."../../model/Exames.php");
require_once(__DIR__."../../dao/ExamesDao.php");

$exames = new Exames();

$examesDao = new ExamesDao();

if(isset($_POST['atualizar'])) { 
    $id = $_POST['id'];
    $exames->setId($id);
    $exames->setNomeExame($_POST['nome_exame']);
    $exames->setDescricao($_POST['descricao']);
    
    $resultado = $examesDao->atualizar($exames);
    header("Location: ../exames.php");
    exit();
}

if(isset($_POST['excluir?id'])) {
    $exames->setId($id);

    $resultado = $examesDao->delete($exames);
}

function listar() {
    $examesDao = new ExamesDao();
    $lista = $examesDao->read();

    foreach ($lista as $exm) {
        echo "<tr>
                <td>{$exm->getId()}</td>
                <td>{$exm->getNomeExame()}</td>
                <td>{$exm->getDescricao()}</td>
                <td>
                    <div class='d-flex gap-2'>
                        <a href='editar.php?editar={$exm->getId()}' class='btn btn-sm btn-warning'>
                            <i class='bi bi-pencil-square'></i> Editar
                        </a>
                        <form method='POST' action='exames.php' onsubmit=\"return confirm('Tem certeza que deseja excluir este exame?');\">
                            <input type='hidden' name='excluir' value=' {$exm->getId()} '>
                            <button type='submit' class='btn btn-sm btn-danger'>
                                <i class='bi bi-trash'></i> Excluir
                            </button>
                        </form>
                    </div>
                </td>
            </tr>";
    }
}
?>