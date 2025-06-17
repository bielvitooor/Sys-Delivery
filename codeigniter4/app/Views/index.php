<!DOCTYPE html>
<html lang="pt-br">
<?php include('templates/header.php'); ?>
<body class="site-publico">

<?php
$login = session()->get('login');
if ($login) {
    if ($login->usuarios_nivel == 'admin') {
        include('templates/nav_admin.php');
    } else {
        include('templates/nav_user.php');
    }
} else {
    include('templates/nav.php'); // nav padrão para visitante
}
?>

<main>
    <?php include('templates/produtos.php'); ?>
    <?php include('templates/sobre.php'); ?>
    <?php include('templates/contato.php'); ?>
</main>

<?php include('templates/footer.php'); ?>
<?php include('templates/end.php'); ?>

</body>
</html>