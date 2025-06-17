<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>
<div class="container ">
    <h2 class="border-bottom border-2 border-primary mt-3 mb-4">Listagem de Vendas</h2>
    <a href="<?= base_url('vendas/new') ?>" class="btn btn-success mb-3">Nova Venda</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pedido ID</th>
                <th>Cliente</th>
                <th>Data Venda</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($vendas as $venda): ?>
            <tr>
                <td><?= $venda->venda_id ?></td>
                <td><?= $venda->pedido_id ?></td>
                <td><?= esc($venda->usuarios_nome. ' ' . $venda->usuarios_sobrenome) ?></td>
                <td><?= $venda->data_venda ?></td>
                <td>
                    <a href="<?= base_url('vendas/show/'.$venda->venda_id) ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="<?= base_url('vendas/delete/'.$venda->venda_id) ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>