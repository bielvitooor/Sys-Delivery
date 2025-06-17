<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($form).' '.$title ?>
    </h2>

    <form action="<?= base_url('funcionarios/'.$op); ?>" method="post">
        <input type="hidden" name="usuarios_id" value="<?= $funcionario->usuarios_id ?? '' ?>">
        <div class="mb-3">
            <label for="Usuário" class="form-label">Usuário</label>
            <select class="form-control" name="usuario_id" required>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario->usuarios_id ?>" <?= isset($funcionario) && $funcionario->usuario_id == $usuario->usuarios_id ? 'selected' : '' ?>>
                        <?= $usuario->usuarios_nome . ' ' . $usuario->usuarios_sobrenome ?>
                    </option>
                <?php endforeach; ?>
            </select>   
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" name="cargo" value="<?= $funcionario->cargo ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" name="status">
                <option value="ativo" <?= ($funcionario->status ?? '') == 'ativo' ? 'selected' : '' ?>>Ativo</option>
                <option value="inativo" <?= ($funcionario->status ?? '') == 'inativo' ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>
        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= ucfirst($form) ?>
                <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
