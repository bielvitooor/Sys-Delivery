<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="border-bottom mb-4"><?= ucfirst($form) ?> Venda</h2>
    <form action="<?= base_url('vendas/' . $op) ?>" method="post">
        <div class="mb-3">
            <label for="pedido_id" class="form-label" >Pedido</label>
            <select name="pedido_id" id="pedido_id" class="form-control" required>
                <option value="" disabled selected>Selecione um pedido</option>
                <?php foreach ($pedidos as $p): ?>
                    <option value="<?= $p->pedido_id ?>">
                        <?= esc($p->pedido_id . ' - ' . $p->usuarios_nome . ' ' . $p->usuarios_sobrenome) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Endereço de Entrega</label>
            <div id="endereco-entrega" class="form-control-plaintext text-muted">Selecione um pedido...</div>
        </div>

        <label class="form-label">Produtos do Pedido</label>
        <table class="table table-bordered" id="produtos-tabela">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="produtos-lista">
                <!-- Preenchido via JS -->
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th id="total">0,00</th>
                </tr>
            </tfoot>
        </table>

        <button type="submit" class="btn btn-success">Salvar Venda</button>
    </form>
</div>

<script>
document.getElementById('pedido_id').addEventListener('change', function() {
    let pedidoId = this.value;
    let tbody = document.getElementById('produtos-lista');
    let totalEl = document.getElementById('total');
    let enderecoDiv = document.getElementById('endereco-entrega');
    tbody.innerHTML = '<tr><td colspan="4">Carregando...</td></tr>';
    enderecoDiv.textContent = 'Carregando...';
    fetch('<?= base_url('vendas/getPedidoInfo/') ?>' + pedidoId)
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = '';
            if (data.itens && data.itens.length > 0) {
                data.itens.forEach(function(item) {
                    tbody.innerHTML += `
                        <tr>
                            <td>${item.produto_nome}</td>
                            <td>${item.quantidade}</td>
                            <td>${parseFloat(item.preco_venda).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>
                            <td>${parseFloat(item.subtotal).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4">Nenhum produto encontrado para este pedido.</td></tr>';
            }
            totalEl.textContent = parseFloat(data.total).toLocaleString('pt-BR', {minimumFractionDigits: 2});
            if (data.endereco) {
                enderecoDiv.textContent = `${data.endereco.logradouro}, ${data.endereco.numero} - ${data.endereco.bairro} (${data.endereco.cep})`;
            } else {
                enderecoDiv.textContent = 'Endereço não cadastrado';
            }
        });
});
</script>
<?= $this->endSection() ?>