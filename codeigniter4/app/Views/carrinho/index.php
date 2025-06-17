<?= $this->extend('Templates_user') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4">Meu Carrinho</h2>

    <?php if (empty($carrinho)): ?>
        <div class="alert alert-info">Seu carrinho está vazio.</div>
        <a href="<?= base_url('/home') ?>" class="btn btn-primary">Ver Produtos</a>
    <?php else: ?>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Qtd</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($carrinho as $item): 
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td style="width:80px">
                        <img src="<?= base_url('assets/' . esc($item['imagem'])) ?>" alt="<?= esc($item['nome']) ?>" style="width:60px; height:60px; object-fit:cover;">
                    </td>
                    <td><?= esc($item['nome']) ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td style="width:110px;">
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-minus" data-id="<?= $item['produto_id'] ?>">-</button>
                            <input type="text" name="quantidades[<?= $item['produto_id'] ?>]" value="<?= $item['quantidade'] ?>" class="form-control text-center input-qtd" style="width:40px;" data-id="<?= $item['produto_id'] ?>" readonly>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-plus" data-id="<?= $item['produto_id'] ?>">+</button>
                        </div>
                    </td>
                    <td>R$ <span class="subtotal" data-id="<?= $item['produto_id'] ?>"><?= number_format($subtotal, 2, ',', '.') ?></span></td>
                    <td>
                        <a href="<?= base_url('carrinho/remove/' . $item['produto_id']) ?>" class="btn btn-danger btn-sm" title="Remover">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total:</th>
                    <th colspan="2" id="total-carrinho">R$ <?= number_format($total, 2, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
        <div class="text-end">
            <a href="<?= base_url('carrinho/checkout') ?>" class="btn btn-success">Finalizar Compra</a>
        </div>
    <?php endif; ?>
</div>

<script>
function atualizarCarrinhoNoServidor(produto_id, quantidade) {
    fetch('<?= base_url('carrinho/update') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({produto_id: produto_id, quantidade: quantidade})
    }).then(() => {
        location.reload(); // Recarrega a página para garantir que a sessão está atualizada
    });
}

document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let input = document.querySelector('.input-qtd[data-id="'+id+'"]');
        input.value = parseInt(input.value) + 1;
        atualizarSubtotal(id);
        atualizarCarrinhoNoServidor(id, input.value);
    });
});
document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let input = document.querySelector('.input-qtd[data-id="'+id+'"]');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            atualizarSubtotal(id);
            atualizarCarrinhoNoServidor(id, input.value);
        }
    });
});

function atualizarSubtotal(id) {
    let input = document.querySelector('.input-qtd[data-id="'+id+'"]');
    let preco = parseFloat(document.querySelector('input[name="quantidades['+id+']"]').closest('tr').querySelectorAll('td')[2].innerText.replace('R$','').replace('.','').replace(',','.'));
    let subtotal = preco * parseInt(input.value);
    document.querySelector('.subtotal[data-id="'+id+'"]').innerText = subtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    atualizarTotal();
}

function atualizarTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(function(span){
        total += parseFloat(span.innerText.replace('.','').replace(',','.'));
    });
    document.getElementById('total-carrinho').innerText = 'R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}
</script>

<?= $this->endSection() ?>