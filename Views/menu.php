<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href='<?php echo BASE_URL; ?>'>
        Banco De Horas
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbar1" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href='<?php echo BASE_URL; ?>'>
                    Home
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="relatorios" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Relatórios
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="relatorios">
                    <a class="dropdown-item modal-ajax" href="<?php echo BASE_URL."/relatorio/saldo";?>">
                        Saldos por funcionario
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="operacoesNavbar" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Operações
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="operacoesNavbar">
                    <a class="dropdown-item modal-ajax" href="<?php echo BASE_URL."/funcionario"?>">
                        Cadastrar colaborador
                    </a>

                    <a class="dropdown-item modal-ajax" href="<?php echo BASE_URL."/funcionarios/listar"?>">
                        Listar colaboradores
                    </a>
                </div>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo BASE_URL . "/sair"; ?>" id="sair">Sair</a>
            </li>
        </ul>
    </div>
</nav>
