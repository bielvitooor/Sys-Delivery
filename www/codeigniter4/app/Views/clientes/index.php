<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>


<div class="container">
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"> <?= $title ?> </h2>

    <?php if (isset($msg)) { echo $msg; } ?>

    <form action="<?= base_url('clientes/search'); ?>" class="d-flex" role="search" method="post">
        <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar por nome ou CPF..." aria-label="Search">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">CPF</th>
                <th scope="col">Telefone</th>
                <th scope="col">Email</th>
                <th scope="col">
                    <a class="btn btn-success" href="<?= base_url('clientes/new'); ?>">
                        Novo
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <th scope="row"><?= $cliente->cliente_id; ?></th>
            <td><?= $cliente->usuarios_nome. ' '.$cliente->usuarios_sobrenome; ?></td>
            <td><?= $cliente->usuarios_cpf; ?></td>
            <td><?= $cliente->usuarios_fone; ?></td>
            <td><?= $cliente->usuarios_email; ?></td>

                    <td>
                        <a class="btn btn-primary" href="<?= base_url('usuarios/edit/'.$cliente->usuario_id); ?>">
                            Editar
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a class="btn btn-danger" href="<?= base_url('clientes/delete/'.$cliente->cliente_id); ?>">
                            Excluir
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
