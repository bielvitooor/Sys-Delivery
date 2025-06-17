<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="border-bottom mb-4"><?= ucfirst($form) ?> Estoque</h2>
    <form action="<?= base_url('estoques/'.$op. (isset($estoque->estoque_id) ? '/'.$estoque->estoque_id : '')) ?>" method="post">
        <?php if(isset($estoque->estoque_id) && $estoque->estoque_id): ?>
            <input type="hidden" name="estoque_id" value="<?= $estoque->estoque_id ?>">
        <?php endif ?>
        <div class="mb-3">
            <label class="form-label">Produto</label>
            <select name="produto_id" id="produto_id" class="form-control" required>
                <option value="">Selecione</option>
                <?php foreach($produtos as $p): ?>
                    <option value="<?= $p->produtos_id ?>"
                        data-preco="<?= $p->produtos_preco_venda ?>"
                        <?= isset($estoque->produto_id) && $estoque->produto_id == $p->produtos_id ? 'selected' : '' ?>>
                        <?= $p->produtos_nome ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Preço de Venda</label>
            <input type="text" id="produtos_preco_venda" class="form-control" value="" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" value="<?= $estoque->quantidade ?? '' ?>" required>
        </div>
        <button class="btn btn-success" type="submit"><?= ucfirst($form) ?></button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var select = document.getElementById('produto_id');
    var precoInput = document.getElementById('produtos_preco_venda');

    function atualizarPreco() {
        var preco = select.options[select.selectedIndex]?.getAttribute('data-preco');
        precoInput.value = preco ? preco : '';
    }

    select.addEventListener('change', atualizarPreco);

    // Atualiza o preço ao carregar a página se já houver produto selecionado
    atualizarPreco();
});
</script>
<?= $this->endSection() ?>