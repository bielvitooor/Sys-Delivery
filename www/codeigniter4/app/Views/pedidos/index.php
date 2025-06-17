<?php
$login = session()->get('login');
$usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;

?>
<?= $this->extend($template) ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="border-bottom mb-4">Listagem de Pedidos</h2>
    <?php if (isset($usuario_nivel) && $usuario_nivel == 1 || $usuario_nivel == 3): ?>
        <a href="<?= base_url('pedidos/new') ?>" class="btn btn-success mb-3">Novo Pedido</a>
    <?php endif; ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <?php if (isset($usuario_nivel) && $usuario_nivel == 1): ?>
                    <th>ID</th>
                <?php endif; ?>

                <th>Cliente</th>
                <th>Data</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($pedidos as $ped): ?>
            <tr>
                <?php if (isset($usuario_nivel) && $usuario_nivel == 1): ?>
                    <td><?= $ped->pedido_id ?></td>
                <?php endif; ?>
                <td><?= $ped->usuarios_nome ?> <?= $ped->usuarios_sobrenome ?></td>
                <td><?= $ped->data_pedido ?></td>
                <td><?= number_format($ped->total, 2, ',', '.') ?></td>
                <td><?= $ped->status ?></td>
                <td>
                    <a href="<?= base_url('pedidos/show/'.$ped->pedido_id) ?>" class="btn btn-info btn-sm">Detalhes</a>
                    <?php if (isset($usuario_nivel) && $usuario_nivel == 1 || $usuario_nivel == 3): ?>
                        <a href="<?= base_url('pedidos/edit/'.$ped->pedido_id) ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="<?= base_url('pedidos/delete/'.$ped->pedido_id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este pedido?')">Excluir</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>