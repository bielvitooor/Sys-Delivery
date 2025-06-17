<?php
helper('functions');
$login = session()->get('login');
$template = (isset($login->usuarios_nivel) && $login->usuarios_nivel == 1) ? 'Templates_admin' : 'Templates_user';
?>
<?= $this->extend($template) ?>
<?= $this->section('content') ?>


<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($form) . ' ' . $title ?>
    </h2>

    <form action="<?= base_url('usuarios/' . $op); ?>" method="post">
        <div class="mb-3">
            <label for="usuarios_nome" class="form-label"> Nome </label>
            <input type="text" class="form-control" name="usuarios_nome" value="<?= $usuarios->usuarios_nome; ?>"
                id="usuarios_nome">
        </div>

        <div class="mb-3">
            <label for="usuarios_sobrenome" class="form-label"> Sobrenome </label>
            <input type="text" class="form-control" name="usuarios_sobrenome"
                value="<?= $usuarios->usuarios_sobrenome; ?>" id="usuarios_sobrenome">
        </div>
        <div class="mb-3">
            <label for="usuarios_cpf" class="form-label"> CPF </label>
            <input type="text" class="form-control" name="usuarios_cpf" value="<?= $usuarios->usuarios_cpf; ?>"
                id="usuarios_cpf">
        </div>

        <div class="mb-3">
            <label for="usuarios_email" class="form-label"> E-mail </label>
            <input type="email" class="form-control" name="usuarios_email" value="<?= $usuarios->usuarios_email; ?>"
                id="usuarios_email">
        </div>
        <?php if (isset($login->usuarios_nivel) && $login->usuarios_nivel == 1): ?>
            <div class="mb-3">
                <label for="usuarios_senha" class="form-label"> Senha </label>
                <input type="password" class="form-control" name="usuarios_senha" value="<?= $usuarios->usuarios_senha; ?>"
                    id="usuarios_senha">
            </div>
        <?php endif; ?>


        <div class="mb-3">
            <label for="usuarios_fone" class="form-label"> Fone </label>
            <input type="tel" class="form-control" name="usuarios_fone" value="<?= $usuarios->usuarios_fone; ?>"
                id="usuarios_fone">
        </div>

        <div class="mb-3">
            <label for="usuarios_data_nasc" class="form-label"> Data Nasc. </label>
            <input type="date" class="form-control" name="usuarios_data_nasc"
                value="<?= $usuarios->usuarios_data_nasc; ?>" id="usuarios_data_nasc">

        </div>
        <?php if (isset($login->usuarios_nivel) && $login->usuarios_nivel == 1): ?>
            <div class="mb-3">
                <label for="usuarios_nivel" class="form-label"> Tipo de Usuário </label>
                <select class="form-control" name="usuarios_nivel" id="usuarios_nivel">
                    <option value="0" <?= (isset($usuarios->usuarios_nivel) && $usuarios->usuarios_nivel == 0) ? 'selected' : '' ?>>Cliente</option>
                    <option value="3" <?= (isset($usuarios->usuarios_nivel) && $usuarios->usuarios_nivel == 3) ? 'selected' : '' ?>>Funcionário</option>
                    <option value="1" <?= (isset($usuarios->usuarios_nivel) && $usuarios->usuarios_nivel == 1) ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
        <?php endif; ?>
        <input type="hidden" name="usuarios_id" value="<?= $usuarios->usuarios_id; ?>">
        <div class="mb-3">
            <label for="usuarios_logradouro" class="form-label">Logradouro</label>
            <input type="text" class="form-control" name="usuarios_logradouro" id="usuarios_logradouro"
                value="<?= $usuarios->usuarios_logradouro; ?>">
        </div>
        <div class="mb-3">
            <label for="usuarios_numero" class="form-label">Número</label>
            <input type="text" class="form-control" name="usuarios_numero" id="usuarios_numero"
                value="<?= $usuarios->usuarios_numero; ?>">
        </div>
        <div class="mb-3">
            <label for="usuarios_complemento" class="form-label">Complemento</label>
            <input type="text" class="form-control" name="usuarios_complemento" id="usuarios_complemento"
                value="<?= $usuarios->usuarios_complemento; ?>">
        </div>
        <div class="mb-3">
            <label for="usuarios_bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" name="usuarios_bairro" id="usuarios_bairro"
                value="<?= $usuarios->usuarios_bairro; ?>">
        </div>
        <div class="mb-3">
            <label for="usuarios_cep" class="form-label">CEP</label>
            <input type="text" class="form-control" name="usuarios_cep" id="usuarios_cep"
                value="<?= $usuarios->usuarios_cep; ?>">
        </div>
        <div class="mb-3">
            <label for="usuarios_cidades_id" class="form-label">Cidade</label>
            <select class="form-control" name="usuarios_cidades_id" id="usuarios_cidades_id">
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?= $cidade->cidades_id ?>" <?= ($cidade->cidades_id == $usuarios->usuarios_cidades_id) ? 'selected' : '' ?>><?= $cidade->cidades_nome ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <button class="btn btn-success" type="submit"> <?= ucfirst($form) ?> <i class="bi bi-floppy"></i></button>
        </div>

    </form>

</div>

<?= $this->endSection() ?>

<?php
//     }else{

//         $data['msg'] = msg("Sem permissão de acesso!","danger");
//         echo view('login',$data);
//     }
// }else{

//     $data['msg'] = msg("O usuário não está logado!","danger");
//     echo view('login',$data);
// }

?>