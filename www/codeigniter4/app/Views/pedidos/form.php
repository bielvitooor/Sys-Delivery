<?php
$login = session()->get('login');
$usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
?>
<?= $this->extend($template) ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="border-bottom mb-4"><?= ucfirst($form ?? 'Cadastrar') ?> Pedido</h2>
    <form action="<?= base_url('pedidos/' . ($op ?? 'create')) ?>" method="post">
        <?php if (isset($pedido->pedido_id)): ?>
            <input type="hidden" name="pedido_id" value="<?= $pedido->pedido_id ?>">
        <?php endif ?>

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <?php if (isset($isCliente) && $isCliente): ?>
                <input type="text" class="form-control" value="<?= esc($cliente_nome) ?>" readonly>
                <input type="hidden" name="cliente_id" value="<?= esc($cliente_id) ?>">
            <?php else: ?>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="" disabled selected>Selecione um cliente</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?= $c->cliente_id ?>" <?= isset($pedido) && $pedido->cliente_id == $c->cliente_id ? 'selected' : '' ?>>
                            <?= esc($c->usuarios_nome . ' ' . $c->usuarios_sobrenome) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            <?php endif ?>
        </div>
        <label class="form-label">Produtos</label>
        <table class="table table-bordered" id="produtos-tabela">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody id="produtos-lista">
                <?php foreach ($itens as $i => $item): ?>
                    <?php
                        $produtoAtual = null;
                        foreach ($produtos as $p) {
                            if ($p->produtos_id == $item->produtos_produtos_id) {
                                $produtoAtual = $p;
                                break;
                            }
                        }
                        $estoqueAtual = $produtoAtual->estoque ?? 1;
                    ?>
                    <tr class="produto-item">
                        <td>
                            <select name="produtos[<?= $i ?>][produto_id]" class="produto-select form-control" required>
                                <option value="" disabled>Selecione um produto</option>
                                <?php foreach ($produtos as $p): ?>
                                    <option value="<?= $p->produtos_id ?>"
                                        data-preco="<?= number_format($p->produtos_preco_venda, 2, '.', '') ?>"
                                        data-estoque="<?= $p->estoque ?>"
                                        <?= $p->estoque == 0 ? 'disabled' : '' ?>
                                        <?= $item->produtos_produtos_id == $p->produtos_id ? 'selected' : '' ?>>
                                        <?= esc($p->produtos_nome) ?> <?= $p->estoque == 0 ? '(sem estoque)' : '(Estoque: ' . $p->estoque . ')' ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="produtos[<?= $i ?>][quantidade]"
                                class="quantidade-input form-control"
                                min="1"
                                max="<?= $estoqueAtual ?>"
                                value="<?= $item->quantidade ?>"
                                required readonly>
                        </td>
                        <td>
                            <input type="text" name="produtos[<?= $i ?>][preco_unitario]"
                                value="<?= number_format($item->preco_venda, 2, ',', '.') ?>"
                                class="form-control preco-input" required readonly>
                        </td>
                        <td class="subtotal">
                            <?= number_format($item->preco_venda * $item->quantidade, 2, ',', '.') ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-remove"
                                onclick="removerProduto(this)">-</button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th id="total"></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <button type="button" class="btn btn-primary mb-3" id="adicionar-produto">Adicionar Produto</button>

        <div class="mb-3">
            <label class="form-label">Endereço de Entrega</label>
            <select name="endereco_id" id="endereco_id" class="form-control" required>
                <?php if (isset($enderecos) && count($enderecos) > 0): ?>
                    <option value="" disabled selected>Selecione um endereço</option>
                    <?php foreach ($enderecos as $e): ?>
                        <option value="<?= $e->enderecos_id ?>" <?= isset($pedido) && $pedido->endereco_id == $e->enderecos_id ? 'selected' : '' ?>>
                            <?= esc($e->logradouro . ', ' . $e->numero . ' - ' . $e->bairro . ' (' . $e->cep . ')') ?>
                        </option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option value="" disabled selected>Nenhum endereço encontrado</option>
                <?php endif ?>
            </select>
        </div>
        <?php if (!isset($isCliente) || !$isCliente): ?>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="" disabled selected>Selecione o status</option>
                <option value="Aceito" <?= isset($pedido) && $pedido->status == 'Aceito' ? 'selected' : '' ?>>Aceito</option>
                <option value="Pendente" <?= isset($pedido) && $pedido->status == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="Em produção" <?= isset($pedido) && $pedido->status == 'Em produção' ? 'selected' : '' ?>>Em Produção</option>
                <option value="Concluido" <?= isset($pedido) && $pedido->status == 'Concluido' ? 'selected' : '' ?>>Concluído</option>
                <option value="Cancelado" <?= isset($pedido) && $pedido->status == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
            </select>
        </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-success"><?= ucfirst($form ?? 'Cadastrar') ?></button>
        <a href="<?= base_url('pedidos') ?>" class="btn btn-secondary">Voltar</a>
    </form>
</div>
<script>
    function atualizarSubtotalELinha(itemTr) {
        const preco = parseFloat(itemTr.querySelector('.preco-input').value.replace(',', '.')) || 0;
        const qtd = parseInt(itemTr.querySelector('.quantidade-input').value) || 0;
        const subtotal = preco * qtd;
        itemTr.querySelector('.subtotal').textContent = subtotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
    }

    function atualizarTotal() {
        let total = 0;
        document.querySelectorAll('.produto-item').forEach(function (itemTr) {
            const preco = parseFloat(itemTr.querySelector('.preco-input').value.replace(',', '.')) || 0;
            const qtd = parseInt(itemTr.querySelector('.quantidade-input').value) || 0;
            total += preco * qtd;
            atualizarSubtotalELinha(itemTr);
        });
        document.getElementById('total').textContent = total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
    }

    function removerProduto(btn) {
        const itemTr = btn.closest('.produto-item');
        if (document.querySelectorAll('.produto-item').length > 1) {
            itemTr.remove();
            atualizarTotal();
        }
    }

    // Atualiza o max da quantidade ao trocar o produto
    document.querySelectorAll('.produto-select').forEach(function (select) {
        select.addEventListener('change', function () {
            const preco = this.options[this.selectedIndex].getAttribute('data-preco') || '0.00';
            const estoque = this.options[this.selectedIndex].getAttribute('data-estoque') || '1';
            const tr = this.closest('.produto-item');
            tr.querySelector('.preco-input').value = parseFloat(preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            tr.querySelector('.quantidade-input').max = estoque;
            tr.querySelector('.quantidade-input').value = 1;
            atualizarTotal();
        });
    });
    document.querySelectorAll('.quantidade-input').forEach(function (input) {
        input.addEventListener('input', function() {
            const max = parseInt(this.max) || 1;
            if (parseInt(this.value) > max) this.value = max;
            atualizarTotal();
        });
    });

    document.getElementById('adicionar-produto').addEventListener('click', function () {
        let lista = document.getElementById('produtos-lista');
        let index = lista.querySelectorAll('tr').length;
        let produtosOptions = `<?php foreach ($produtos as $p): ?>
            <option value="<?= $p->produtos_id ?>" 
                data-preco="<?= number_format($p->produtos_preco_venda, 2, '.', '') ?>" 
                data-estoque="<?= $p->estoque ?>"
                <?= $p->estoque == 0 ? 'disabled' : '' ?>>
                <?= esc($p->produtos_nome) ?> <?= $p->estoque == 0 ? '(sem estoque)' : '(Estoque: ' . $p->estoque . ')' ?>
            </option>
        <?php endforeach ?>`;
        let row = document.createElement('tr');
        row.className = 'produto-item';
        row.innerHTML = `
        <td>
            <select name="produtos[${index}][produto_id]" class="produto-select form-control" required>
                <option value="" disabled selected>Selecione um produto</option>
                ${produtosOptions}
            </select>
        </td>
        <td>
            <input type="number" name="produtos[${index}][quantidade]" class="quantidade-input form-control" min="1" max="1" value="1" required>
        </td>
        <td>
            <input type="text" name="produtos[${index}][preco_unitario]" value="0,00" class="form-control preco-input" required readonly>
        </td>
        <td class="subtotal">0,00</td>
        <td>
            <button type="button" class="btn btn-danger btn-remove" onclick="removerProduto(this)">-</button>
        </td>
    `;
        lista.appendChild(row);

        row.querySelector('.produto-select').addEventListener('change', function () {
            const preco = this.options[this.selectedIndex].getAttribute('data-preco') || '0.00';
            const estoque = this.options[this.selectedIndex].getAttribute('data-estoque') || '1';
            row.querySelector('.preco-input').value = parseFloat(preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            row.querySelector('.quantidade-input').max = estoque;
            row.querySelector('.quantidade-input').value = 1;
            atualizarTotal();
        });
        row.querySelector('.quantidade-input').addEventListener('input', function() {
            const max = parseInt(this.max) || 1;
            if (parseInt(this.value) > max) this.value = max;
            atualizarTotal();
        });

        atualizarTotal();
    });

    window.onload = atualizarTotal;

    // AJAX para carregar endereços do cliente selecionado
    const clienteSelect = document.getElementById('cliente_id');
    if (clienteSelect) {
        clienteSelect.addEventListener('change', function () {
            var clienteId = this.value;
            var enderecoSelect = document.getElementById('endereco_id');
            enderecoSelect.innerHTML = '<option>Carregando...</option>';
            fetch('<?= base_url('pedidos/enderecos_cliente/') ?>' + clienteId)
                .then(response => response.json())
                .then(data => {
                    enderecoSelect.innerHTML = '';
                    if (data.length === 0) {
                        enderecoSelect.innerHTML = '<option value="">Nenhum endereço encontrado</option>';
                    } else {
                        enderecoSelect.innerHTML = '<option value="" disabled selected>Selecione um endereço</option>';
                        data.forEach(function (e) {
                            enderecoSelect.innerHTML += `<option value="${e.enderecos_id}">${e.logradouro}, ${e.numero} - ${e.bairro} (${e.cep})</option>`;
                        });
                    }
                });
        });
    }
</script>
<?= $this->endSection() ?>