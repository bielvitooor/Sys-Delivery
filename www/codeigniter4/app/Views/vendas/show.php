<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Detalhes da Venda #<?= esc($venda->venda_id) ?></h2>
    <p><strong>Cliente:</strong> <?= esc($venda->usuarios_nome . ' ' . $venda->usuarios_sobrenome) ?></p>
    <p><strong>Endereço de Entrega:</strong>
        <?= esc($endereco->logradouro ?? '') ?>,
        <?= esc($endereco->numero ?? '') ?>,
        <?= esc($endereco->bairro ?? '') ?>,
        <?= esc($endereco->cep ?? '') ?>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($itens as $item): ?>
            <tr>
                <td><?= esc($item->produto_nome) ?></td>
                <td><?= esc($item->quantidade) ?></td>
                <td><?= number_format($item->preco_venda, 2, ',', '.') ?></td>
                <td><?= number_format($item->subtotal, 2, ',', '.') ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th><?= number_format($total, 2, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
    <a href="<?= base_url('vendas') ?>" class="btn btn-secondary">Voltar</a>
</div>
<?= $this->endSection() ?>