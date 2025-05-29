<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Relatórios</title>
</head>

<body>
    <?php
    include('../../modelo/nav.php');
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Bem vindo a tela dos relatórios</h1>

                <div class="d-flex center bg-white rounded mt-5">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome Completo</th>
                                <th scope="col">Tipo de Exame</th>
                                <th scope="col">Data do Exame</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark Otto</td>
                                <td>Respostas vacinais</td>
                                <td>30/02/25</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob Thornton</td>
                                <td>Hemograma completo</td>
                                <td>14/03/25</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>
                                    <?php
                                        foreach($_GET as $chave => $valor){
                                            echo "<p>$chave: $valor </p>";
                                        }
                                    ?>
                                </td>
                                <td>Análise de linfócitos</td>
                                <td>20/03/25</td>
                            </tr>
                        </tbody>
                    </table>

                        </tbody> 
                    </table>

                </div>

            </div>
        </div>
    </div>

    <?php
        include('../../modelo/footer.php');
    ?>
</body>

</html>