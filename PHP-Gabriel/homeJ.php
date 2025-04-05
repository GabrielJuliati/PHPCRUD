<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Home</title>
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
                <a class="nav-link" href="#">Relatórios</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    
      <div class="container mt-5">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1>Bem-vindo ao Sistema Clínico SUS</h1>
            <p class="lead">Gerencie pacientes, agendamentos e relatórios de forma eficiente.</p>
          </div>
        </div>
    
        <div class="row mt-4">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Pacientes</h5>
                <p class="card-text">Gerencie o cadastro de pacientes.</p>
                <a href="#" class="btn btn-primary">Acessar</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Agendamentos</h5>
                <p class="card-text">Agende consultas e procedimentos.</p>
                <a href="#" class="btn btn-primary">Acessar</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Relatórios</h5>
                <p class="card-text">Gere relatórios de atendimentos.</p>
                <a href="#" class="btn btn-primary">Acessar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>