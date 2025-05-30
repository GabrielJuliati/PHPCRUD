<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../home/home.php">SPS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../pacientes/escolhaPaciente.php">Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../agendamento/agendamento.php">Agendamentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../relatorio/relatorio.php">Relatórios</a>
                </li>

                <?php
                if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 'ADM') {
                    include('admNav.php');
                }
                ?>
            </ul>
            <ul class="navbar-nav ms-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle btn btn-primary text-white" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION["nome"]; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="nav-link btn btn-info btn-sm px-4 py-1 mx-2" style="color: black" href="../acesso/resetPassword.php">Alterar Senha</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger btn-sm px-4 py-1 mx-2" style="color: black" href="../../public/logout/logout.php">Sair</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>