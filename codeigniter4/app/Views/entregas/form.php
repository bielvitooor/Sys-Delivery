<?= $this->extend($template) ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="border-bottom mb-4"><?= ucfirst($form) ?> Entrega</h2>
    <form action="<?= base_url('entregas/'.$op) ?>" method="post">
        <?php if(isset($entrega->entrega_id)): ?>
            <input type="hidden" name="entrega_id" value="<?= $entrega->entrega_id ?>">
        <?php endif ?>
        <div class="mb-3">
            <label class="form-label">Venda</label>
            <select name="venda_id" class="form-control" required>
                <?php foreach($vendas as $v): ?>
                    <option value="<?= $v->venda_id ?>" <?= isset($entrega)&&$entrega->venda_id==$v->venda_id?'selected':'' ?>>Venda #<?= $v->venda_id ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Funcionário</label>
            <select name="funcionario_id" class="form-control" required>
                <?php foreach($funcionarios as $f): ?>
                  <option value="<?= $f->funcionario_id ?>" <?= isset($entrega)&&$entrega->funcionario_id==$f->funcionario_id?'selected':'' ?>>
    <?= $f->usuarios_nome ?>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Data Saída</label>
            <input type="datetime-local" name="data_saiu_entrega" class="form-control" value="<?= isset($entrega->data_saiu_entrega) ? date('Y-m-d\TH:i', strtotime($entrega->data_saiu_entrega)) : '' ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Data Entrega</label>
            <input type="datetime-local" name="data_entrega" class="form-control" value="<?= isset($entrega->data_entrega) ? date('Y-m-d\TH:i', strtotime($entrega->data_entrega)) : '' ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Pendente" <?= isset($entrega->status) && $entrega->status == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="Entregue" <?= isset($entrega->status) && $entrega->status == 'Entregue' ? 'selected' : '' ?>>Entregue</option>
                <option value="Cancelada" <?= isset($entrega->status) && $entrega->status == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                <option value ="Saiu para Entrega" <?= isset($entrega->status) && $entrega->status == 'Saiu para Entrega' ? 'selected' : '' ?>>Saiu para Entrega</option>
            </select>
        </div>
        <button class="btn btn-success" type="submit"><?= ucfirst($form) ?></button>
    </form>
</div>
<?= $this->endSection() ?>