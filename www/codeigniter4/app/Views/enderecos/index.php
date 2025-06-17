<?php
    helper('functions');
    session();
?>

<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"> <?= $title ?> </h2>

    <?php if (isset($msg)) { echo $msg; } ?>

    <form action="<?= base_url('enderecos/search'); ?>" class="d-flex" role="search" method="post">
        <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">logradouro</th>
                <th scope="col">Número</th>
                <th scope="col">Complemento</th>
                <th scope="col">CEP</th>
                <th scope="col">Cidade</th>
                <th scope="col">Usuário</th>
                <th scope="col">Status</th>
                <th scope="col">
                    <a class="btn btn-success" href="<?= base_url('enderecos/new'); ?>">
                        Novo
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php foreach ($enderecos as $endereco): ?>
                <tr>
                    <th scope="row"><?= $endereco->enderecos_id; ?></th>
                    <td><?= $endereco->logradouro; ?></td>
                    <td><?= $endereco->numero; ?></td>
                    <td><?= $endereco->complemento; ?></td>
                    <td><?= $endereco->cep; ?></td>
                    <td><?= $endereco->cidade_nome; ?></td>
                    <td><?= $endereco->usuario_nome; ?></td> 
                    <td><?= $endereco->status; ?></td>
                    <td>
                        <a class="btn btn-primary" href="<?= base_url('enderecos/edit/'.$endereco->enderecos_id); ?>">
                            Editar
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a class="btn btn-danger" href="<?= base_url('enderecos/delete/'.$endereco->enderecos_id); ?>">
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
