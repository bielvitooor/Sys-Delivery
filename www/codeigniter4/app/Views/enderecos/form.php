
<?php
    helper('functions');
    session();
    // if(isset($_SESSION['login'])){
    //     $login = $_SESSION['login'];
    //     print_r($login);
    //     if($login->usuarios_nivel == 1){
    
?>
<?= $this->extend('Templates_admin') ?>
<?= $this->section('content') ?>


    <div class="container pt-4 pb-5 bg-light">
        <h2 class="border-bottom border-2 border-primary">
            <?= ucfirst($form).' '.$title ?>
        </h2>

        <form action="<?= base_url('enderecos/'.$op); ?>" method="post">

        <input type="hidden" name="enderecos_id" value="<?= $enderecos->enderecos_id ?>">
        
            <div class="mb-3">
                <label for="logradouro" class="form-label"> logradouro </label>
                <input type="text" class="form-control" name="logradouro" value="<?= $enderecos->logradouro; ?>"  id="logradouro">
            </div>

            <div class="mb-3">
                <label for="numero" class="form-label"> Numero </label>
                <input type="text" class="form-control" name="numero" value="<?= $enderecos->numero; ?>"  id="numero">
            </div>

            <div class="mb-3">
                <label for="complemento" class="form-label"> Complemento </label>
                <input type="text" class="form-control" name="complemento" value="<?= $enderecos->complemento; ?>"  id="complemento">
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label"> Bairro </label>
                <input type="text" class="form-control" name="bairro" value="<?= $enderecos->bairro; ?>"  id="bairro">
            <div class="mb-3">
                <label for="cep" class="form-label"> CEP </label>
                <input type="text" class="form-control" name="cep" value="<?= $enderecos->cep; ?>"  id="cep">
            </div>

            <div class="mb-3">
    <label for="cidades_id" class="form-label"> Cidade </label>
    <select class="form-control" name="cidades_id" id="cidades_id">
        <?php foreach ($cidades as $cidade): ?>
            <option value="<?= $cidade->cidades_id ?>" 
                <?= $cidade->cidades_id == $enderecos->cidades_id ? 'selected' : '' ?>>
                <?= $cidade->cidades_nome ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

    
            <div class="mb-3">
                <label for="status" class="form-label"> Status </label>
                <input type="text" class="form-control" name="status" value="<?= $enderecos->status; ?>"  id="status">
            </div>

                <div class="mb-3">
        <label for="usuarios_id" class="form-label"> Usuário </label>
        <select class="form-control" name="usuarios_id" id="usuarios_id">
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= $usuario->usuarios_id ?>" 
                    <?= $usuario->usuarios_id == $enderecos->usuarios_id ? 'selected' : '' ?>>
                    <?= $usuario->usuarios_nome ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>  



            <div class="mb-3">
                <button class="btn btn-success" type="submit"> <?= ucfirst($form)  ?> <i class="bi bi-floppy"></i></button>
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