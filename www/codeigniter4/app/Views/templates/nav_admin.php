
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-5">
    <div class="container-fluid">

        <a class="navbar-brand" href="<?php echo base_url('/') ?>">
            <img src="<?php echo base_url('assets/images/sd_logo.png') ?>" alt="SysDelivery" width="180">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo base_url('admin') ?>">
                        <i class="bi bi-house-fill"></i>
                        Home
                    </a>
                </li>

                <!-- Usuários -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('usuarios') ?>">
                        <i class="bi bi-person"></i>
                        Usuários
                    </a>
                </li>

                <!-- Cadastros Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="cadastrosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-folder"></i>
                        Cadastros
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="cadastrosDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('categorias') ?>">
                                <i class="bi bi-file-earmark-text"></i> Categorias
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('produtos') ?>">
                                <i class="bi bi-basket"></i> Produtos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('imgprodutos') ?>">
                                <i class="bi bi-images"></i> IMG Produtos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('estoques') ?>">
                                <i class="bi bi-archive"></i> Estoques
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('cidades') ?>">
                                <i class="bi bi-bank"></i> Cidades
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('clientes') ?>">
                                <i class="bi bi-person-x"></i> Clientes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('enderecos') ?>">
                                <i class="bi bi-house-add"></i> Endereços
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('funcionarios') ?>">
                                <i class="bi bi-file-person"></i> Funcionários
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Operações Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="operacoesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear"></i>
                        Operações
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="operacoesDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('pedidos') ?>">
                                <i class="bi bi-table"></i> Pedidos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('vendas') ?>">
                                <i class="bi bi-receipt-cutoff"></i> Vendas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('entregas') ?>">
                                <i class="bi bi-truck"></i> Entregas
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Conta Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="contaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-gear"></i>
                        Conta
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="contaDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('usuarios/edit_senha') ?>">
                                <i class="bi bi-key"></i> Alterar Senha
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('usuarios/edit_nivel') ?>">
                                <i class="bi bi-bar-chart-steps"></i> Alterar Nível
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

        <div class="d-flex">
            <a class="btn btn-outline-primary me-2" href="<?php echo base_url('login/logout') ?>">
                <i class="bi bi-unlock"></i>
                sair
            </a>
        </div>
    </div>
</nav>