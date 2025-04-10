<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
<?php 
    include('../modelo/nav.php');
?>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h1 class="text-center m-5">Agendamento</h1>
                <div>
                    <form action="">
                        <div class="mb-3 text-center">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="m-3 text-center">
                            <label for="date" class="form-label">Data do Exame:</label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>
                        <div class="mb-3 text-center">
                            <label for="type" class="form-label">Tipo do Exame:</label>
                            <select id="type" name="type" class="form-select">
                                <option value="exame1">ex1</option>
                                <option value="exame2">ex2</option>
                                <option value="exame3">ex3</option>
                                <option value="exame4">ex4</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <input type="submit" value="Enviar" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

</body>
</html>