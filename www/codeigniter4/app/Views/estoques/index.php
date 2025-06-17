<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="border-bottom mb-4">Gestão de Estoque</h2>
    <a href="<?= base_url('estoques/new') ?>" class="btn btn-success mb-3">Novo Estoque</a>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Produto</th><th>Qtd</th><th>Ações</th></tr></thead>
        <tbody>
        <?php foreach($estoque as $est): ?>
            <tr>
                <td><?= $est->estoque_id ?></td>
                <td><?= $est->produtos_nome ?></td>
                <td><?= $est->quantidade ?></td>
                <td>
                    <a href="<?= base_url('estoques/edit/'.$est->estoque_id) ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="<?= base_url('estoques/delete/'.$est->estoque_id) ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>