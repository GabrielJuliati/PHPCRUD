<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="row">
        <div class="col">
            <?php 
                include "menu.php"; 
            ?>
        </div>
        <div class="col">
                <form action="formulario.php" method="post">
                    <button type="submit" class="btn btn-danger">Solicitar formulario.php via POST </button>
                </form>
        <div class="col">

        </div>
    </div>
</body>
</html>