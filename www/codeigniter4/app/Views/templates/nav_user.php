<!-- Abre o menu de navegação -->
<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <!--Logo do Projeto-->
            <img src="<?= base_url('assets/images/sd_logo.png') ?>" alt="SysDelivery" width="180">
        </a>
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
            id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Link Home-->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="<?= base_url('user') ?>">
                        <i class="bi bi-house-fill"></i>
                        Home
                    </a>
                </li>
                
                <!-- Link produtos -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('home') ?>">
                        <i class="bi bi-basket"></i>
                        Produtos
                    </a>
                </li>
                
                
                                <!-- Link pedidos -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('pedidos') ?>">
                                            <i class="bi bi-table"></i>
                                            Pedidos
                                        </a>
                                </li>
                <div class="nav-item">
                    <a class="nav-link" href="<?= base_url('carrinho') ?>">
                        <i class="bi bi-cart-fill"></i>
                        Carrinho
                    </a>
                </div>
            </ul>
            <!-- Exibe o carrinho -->

            <?php
            $login = session()->get('login');
            $nome_usuario = isset($login->usuarios_nome) ? $login->usuarios_nome : 'Usuário';
            $id_usuario = isset($login->usuarios_id) ? $login->usuarios_id : '';
            ?>
            <div class="d-flex">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?= esc($nome_usuario) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUserMenu">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('usuarios/edit/' . $id_usuario) ?>">
                                <i class="bi bi-pencil"></i> Editar Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('usuarios/edit_senha') ?>">
                                <i class="bi bi-key"></i> Alterar Senha
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= base_url('login/logout') ?>">
                                <i class="bi bi-unlock"></i> Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Fecha o menu de navegação -->