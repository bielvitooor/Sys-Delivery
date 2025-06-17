<?= $this->extend($template) ?>
<?= $this->section('content') ?>

<div id="produtos" class="container">
    <h1 class="col mt-3">Produtos</h1>

    <div class="col mt-3 mb-3">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <?php if (!empty($produtosPorCategoria)): ?>
        <?php foreach ($produtosPorCategoria as $categoria => $produtos): ?>
            <h3 class="mt-4 mb-3"><?= esc($categoria) ?></h3>
            <div class="row">
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-sm-3 mb-3 pb-4 mb-sm-0">
                        <div class="card">
                            <img src="<?= base_url('assets/' . esc($produto->imagem ?? 'sem-imagem.png')) ?>" class="card-img-top"
                                alt="<?= esc($produto->produtos_nome) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($produto->produtos_nome) ?></h5>
                                <h5 class="card-title"><b class="text-danger">R$
                                        <?= number_format($produto->produtos_preco_venda, 2, ',', '.') ?></b></h5>
                                <p class="card-text"><?= esc($produto->produtos_descricao ?? '') ?></p>
                                <p class="text-center">
                                    <a href="<?= base_url('carrinho/add/' . $produto->produtos_id) ?>"
                                        class="btn btn-primary">Comprar <i class="bi bi-basket2-fill"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endforeach ?>
    <?php else: ?>
        <div class="alert alert-info">Nenhum produto disponível no momento.</div>
    <?php endif; ?>
</div>

<?= $this->endSection('content') ?>