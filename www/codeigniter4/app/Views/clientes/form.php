<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($form).' '.$title ?>
    </h2>

    <form action="<?= base_url('clientes/'.$op); ?>" method="post">
        <input type="hidden" name="cliente_id" value="<?= $clientes->clientes_id ?? ''; ?>">
        <input type="hidden" name="usuario_id" value="<?= $clientes->usuario_id ?? ''; ?>">

        <div class="mb-3">
           <label for="clientes_usuario" class="form-label">Usuário</label>
           <select class="form-select" name="clientes_usuario" id="clientes_usuario" required>
               <option value="">Selecione um usuário</option>
               <?php foreach ($usuarios as $usuario): ?>
                   <option value="<?= $usuario->usuarios_id; ?>"
                       <?= isset($clientes->usuario_id) && $clientes->usuario_id == $usuario->usuarios_id ? 'selected' : ''; ?>>
                       <?= $usuario->usuarios_nome . ' ' . $usuario->usuarios_sobrenome; ?>
                   </option>
               <?php endforeach; ?>
           </select>
        </div>
        <div class="mb-3">
            <button class="btn btn-success" type="submit">
                <?= ucfirst($form) ?> <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
