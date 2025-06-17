<?php
?>
<?= $this->extend($template) ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="border-bottom mb-4">Listagem de Entregas</h2>
    <a href="<?= base_url('entregas/new') ?>" class="btn btn-success mb-3">Nova Entrega</a>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Venda</th><th>Funcionário</th><th>Data Saída</th><th>Data Entrega</th><th>Status</th><th>Ações</th></tr></thead>
        <tbody>
        <?php foreach($entregas as $ent): ?>
            <tr>
                <td><?= $ent->entrega_id ?></td>
                <td><?= $ent->venda_id ?></td>
                <td><?= $ent->usuarios_nome ?> <?= $ent->usuarios_sobrenome ?></td>
                <td><?= $ent->data_saiu_entrega ?></td>
                <td><?= $ent->data_entrega ?></td>
                <td><?= $ent->status ?></td>
                <td>
                    <a href="<?= base_url('entregas/edit/'.$ent->entrega_id) ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="<?= base_url('entregas/delete/'.$ent->entrega_id) ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>