<?php
$login = session()->get('login');
?>
<?= $this->extend($template) ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Resumo do Pedido #<?= esc($pedido->pedido_id) ?></h2>
    <p><strong>Cliente:</strong> <?= esc($pedido->usuarios_nome . ' ' . $pedido->usuarios_sobrenome) ?></p>
    <p><strong>Endereço:</strong>
        <?= esc($endereco->logradouro ?? '') ?>,
        <?= esc($endereco->numero ?? '') ?>,
        <?= esc($endereco->bairro ?? '') ?>,
        <?= esc($endereco->cep ?? '') ?>
    </p>
    <p><strong>Status do Pedido:</strong> <?= esc($pedido->status) ?></p>
    <?php if ($entrega): ?>
        <p><strong>Status da Entrega:</strong> <?= esc($entrega->status) ?></p>
        <p><strong>Data saída para entrega:</strong> <?= esc($entrega->data_saiu_entrega) ?></p>
        <p><strong>Data entrega:</strong> <?= esc($entrega->data_entrega) ?></p>
    <?php else: ?>
        <p><strong>Entrega:</strong> Ainda não saiu para entrega</p>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Preço</th>
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
                <th>
                    <?= number_format(array_sum(array_column($itens, 'subtotal')), 2, ',', '.') ?>
                </th>
            </tr>
        </tfoot>
    </table>

    <?php if ($pedido->status  =='Pendente' ): ?>
        <a href="<?= base_url('pedidos/edit/'.$pedido->pedido_id) ?>" class="btn btn-primary mb-3">Editar Pedido</a>
        <a href="<?= base_url('pedidos/delete/'.$pedido->pedido_id) ?>" class="btn btn-danger mb-3">Cancelar Pedido</a>
    <?php else: ?>
        <div class="alert alert-info mt-3">Pedido aceito. Não é mais possível editar os produtos.</div>
    <?php endif; ?>
    <a href="<?= base_url('pedidos') ?>" class="btn btn-secondary mb-3">Voltar</a>

</div>
<?= $this->endSection() ?>