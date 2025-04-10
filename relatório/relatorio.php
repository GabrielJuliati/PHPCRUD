<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Relatórios</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema SUS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pacientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Agendamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#relatorio.php">Relatórios</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
</body>

</html>