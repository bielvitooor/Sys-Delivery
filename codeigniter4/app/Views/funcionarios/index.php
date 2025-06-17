<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4"> <?= $title ?> </h2>

    <?php if (isset($msg)) { echo $msg; } ?>

    <form action="<?= base_url('funcionarios/search'); ?>" class="d-flex" role="search" method="post">
        <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Cargo</th>
                <th>Ações</th>
                <th>
                    <a class="btn btn-success" href="<?= base_url('funcionarios/new'); ?>">
                        Novo
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($funcionarios as $funcionario): ?>
                <tr>
                    <td><?= $funcionario->usuarios_id; ?></td>
                    <td><?= $funcionario->usuarios_nome. ' '.$funcionario->usuarios_sobrenome; ?></td>
                    <td><?= $funcionario->usuarios_email; ?></td>
                    <td><?= $funcionario->cpf; ?></td>
                    <td><?= $funcionario->cargo; ?></td>

                    <td>
                        <a class="btn btn-primary" href="<?= base_url('funcionarios/edit/'.$funcionario->usuarios_id); ?>">
                            Editar
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a class="btn btn-danger" href="<?= base_url('funcionarios/delete/'.$funcionario->usuarios_id); ?>">
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
