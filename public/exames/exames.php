<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleCP.css">
    <title>Home</title>
</head>

<body>
    <?php
      include('../../modelo/nav.php');
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Genrencie os exames disponiveis para escolha.</h1>

                <div class="d-flex center bg-white rounded mt-5">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nome do Exame</th>
                                <th scope="col">Disponivel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>ABO</td>
                                <td>
                                    <input type="checkbox" class="" id="1" name="ABO">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Teste de sorologia (IgM e IgG) ou Teste de antígeno NS1 e RT-PCR</td>
                                <td>
                                    <input type="checkbox" class="" id="2" name="IgM">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>RT-PCR ou teste rápido de antígeno</td>
                                <td>
                                    <input type="checkbox" class="" id="3" name="RT">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td></td>
                                <td>
                                    <input type="checkbox" class="" id="4" name="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td></td>
                                <td>
                                    <input type="checkbox" class="" id="5" name="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
        include('../../modelo/footer.php');
    ?>
</body>

</html>