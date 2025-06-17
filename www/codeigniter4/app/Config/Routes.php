<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->group('', ['filter' => 'authnivel:0,1,3'], function ($routes) {

$routes->get('/carrinho', 'Carrinho::index');
$routes->get('/carrinho/add/(:num)', 'Carrinho::add/$1');
$routes->get('/carrinho/remove/(:num)', 'Carrinho::remove/$1');
$routes->get('/carrinho/checkout', 'Carrinho::checkout');
});
$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {
    $routes->get('/cidades', 'Cidades::index');
    $routes->get('/cidades/index', 'Cidades::index');
    $routes->get('/cidades/new', 'Cidades::new');
    $routes->post('/cidades/create', 'Cidades::create');
    $routes->get('/cidades/edit/(:any)', 'Cidades::edit/$1');
    $routes->post('/cidades/update', 'Cidades::update');
    $routes->post('/cidades/search', 'Cidades::search');
    $routes->get('/cidades/delete/(:any)', 'Cidades::delete/$1');
});

$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {
    $routes->get('/estados', 'Estados::index');
    $routes->get('/estados/index', 'Estados::index');
    $routes->get('/estados/new', 'Estados::new');
    $routes->post('/estados/create', 'Estados::create');
    $routes->get('/estados/edit/(:any)', 'Estados::edit/$1');
    $routes->post('/estados/update', 'Estados::update');
    $routes->post('/estados/search', 'Estados::search');
    $routes->get('/estados/delete/(:any)', 'Estados::delete/$1');
});
$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {
    $routes->get('/categorias', 'Categorias::index');
    $routes->get('/categorias/index', 'Categorias::index');
    $routes->get('/categorias/new', 'Categorias::new');
    $routes->post('/categorias/create', 'Categorias::create');
    $routes->get('/categorias/edit/(:any)', 'Categorias::edit/$1');
    $routes->post('/categorias/update', 'Categorias::update');
    $routes->post('/categorias/search', 'Categorias::search');
    $routes->get('/categorias/delete/(:any)', 'Categorias::delete/$1');
});

$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {
    $routes->get('/produtos', 'Produtos::index');
    $routes->get('/produtos/index', 'Produtos::index');
    $routes->get('/produtos/new', 'Produtos::new');
    $routes->post('/produtos/create', 'Produtos::create');
    $routes->get('/produtos/edit/(:any)', 'Produtos::edit/$1');
    $routes->post('/produtos/update', 'Produtos::update');
    $routes->post('/produtos/search', 'Produtos::search');
    $routes->get('/produtos/delete/(:any)', 'Produtos::delete/$1');
});
$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {
    $routes->get('/usuarios/edit_nivel', 'Usuarios::edit_nivel');
    $routes->post('/usuarios/salvar_nivel', 'Usuarios::salvar_nivel');
    $routes->get('/usuarios', 'Usuarios::index');
    $routes->post('usuarios/salvar_endereco', 'Usuarios::salvar_endereco');
    $routes->get('/usuarios/index', 'Usuarios::index');
    $routes->get('/usuarios/new', 'Usuarios::new');
    $routes->post('/usuarios/create', 'Usuarios::create');
    $routes->post('/usuarios/search', 'Usuarios::search');
    $routes->get('/usuarios/delete/(:any)', 'Usuarios::delete/$1');
});
$routes->group('', ['filter' => 'authnivel:1,0,3'], function ($routes) {
    $routes->get('/usuarios/edit/(:any)', 'Usuarios::edit/$1');
    $routes->post('/usuarios/update', 'Usuarios::update');
    $routes->get('/usuarios/edit_senha', 'Usuarios::edit_senha');
    $routes->post('/usuarios/salvar_senha', 'Usuarios::salvar_senha');
    
});


$routes->get('/login', 'Login::index');
$routes->get('/login/index', 'Login::index');
$routes->post('/login/logar', 'Login::logar');
$routes->get('/login/logout', 'Login::logout');

$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {
    $routes->get('/admin', 'Admin::index');
    $routes->get('/admin/index', 'Admin::index');
});

$routes->get('/user', 'User::index');
$routes->get('/user/index', 'User::index');

$routes->get('/funcionario', 'Funcionario::index');
$routes->get('/funcionario/index', 'Funcionario::index');
$routes->group('',['filter'=>'authnivel:1'],function($routes){

    $routes->get('/imgprodutos', 'Imgprodutos::index');
    $routes->get('/imgprodutos/index', 'Imgprodutos::index');
    $routes->get('/imgprodutos/new', 'Imgprodutos::new');
    $routes->post('/imgprodutos/create', 'Imgprodutos::create');
    $routes->get('/imgprodutos/edit/(:any)', 'Imgprodutos::edit/$1');
    $routes->post('/imgprodutos/update', 'Imgprodutos::update');
    $routes->post('/imgprodutos/search', 'Imgprodutos::search');
    $routes->get('/imgprodutos/delete/(:any)', 'Imgprodutos::delete/$1');
    $routes->get('/relatorios', 'Relatorios::index');
    $routes->get('/relatorios/index', 'Relatorios::index');
    $routes->get('/relatorios/produtos', 'Relatorios::relatorioProdutos');
});
$routes->group('', ['filter' => 'authnivel:1,0'], function ($routes) {

    $routes->get('/enderecos', 'Enderecos::index');
    $routes->get('/enderecos/index', 'Enderecos::index');
    $routes->post('/enderecos/create', 'Enderecos::create');
    $routes->get('/enderecos/new', 'Enderecos::new');
    $routes->get('/enderecos/edit/(:any)', 'Enderecos::edit/$1');
    $routes->post('/enderecos/update', 'Enderecos::update');
    $routes->post('/enderecos/search', 'Enderecos::search');
    $routes->get('/enderecos/delete/(:any)', 'Enderecos::delete/$1');
});
// vendas

$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {

    $routes->get('/vendas', 'Vendas::index');
    $routes->get('/vendas/show/(:any)', 'Vendas::show/$1');
    //$routes->get('/vendas/index', 'Vendas::index');
    $routes->get('vendas/getPedidoInfo/(:num)', 'Vendas::getPedidoInfo/$1');
    $routes->get('/vendas/new', 'Vendas::new');
    $routes->post('/vendas/create', 'Vendas::create');
    $routes->get('/vendas/edit/(:any)', 'Vendas::edit/$1');
    $routes->post('/vendas/update', 'Vendas::update');
    $routes->post('/vendas/search', 'Vendas::search');
    $routes->get('/vendas/delete/(:any)', 'Vendas::delete/$1');
    $routes->get('vendas/show/(:num)', 'Vendas::show/$1');
});


$routes->group('', ['filter' => 'authnivel:1,3,0'], function ($routes) {
    $routes->get('/pedidos', 'Pedidos::index');
    $routes->get('/pedidos/show/(:any)', 'Pedidos::show/$1');
    $routes->get('/pedidos/index', 'Pedidos::index');
    $routes->get('/pedidos/new', 'Pedidos::new');
    $routes->post('/pedidos/create', 'Pedidos::create');
    $routes->get('/pedidos/edit/(:any)', 'Pedidos::edit/$1');
    $routes->post('/pedidos/update', 'Pedidos::update');
    $routes->post('/pedidos/search', 'Pedidos::search');
    $routes->get('/pedidos/delete/(:any)', 'Pedidos::delete/$1');
    $routes->get('pedidos/enderecos_cliente/(:num)', 'Pedidos::enderecos_cliente/$1');
});
//estoques
$routes->group('', ['filter' => 'authnivel:1,3'], function ($routes) {

$routes->get('/estoques', 'Estoques::index');
$routes->get('/estoques/index', 'Estoques::index');
$routes->get('/estoques/new', 'Estoques::new');
$routes->post('/estoques/create', 'Estoques::create');
$routes->get('/estoques/edit/(:any)', 'Estoques::edit/$1');
$routes->post('/estoques/update/(:any)', 'Estoques::update/$1');
$routes->post('/estoques/search', 'Estoques::search');
$routes->get('/estoques/delete/(:any)', 'Estoques::delete/$1');
});
$routes->group('', ['filter' => 'authnivel:1,3'], function ($routes) {

//entregas 
$routes->get('/entregas', 'Entregas::index');
$routes->get('/entregas/index', 'Entregas::index');
$routes->get('/entregas/new', 'Entregas::new');
$routes->post('/entregas/create', 'Entregas::create');
$routes->get('/entregas/edit/(:any)', 'Entregas::edit/$1');
$routes->post('/entregas/update', 'Entregas::update');
$routes->post('/entregas/search', 'Entregas::search');
$routes->get('/entregas/delete/(:any)', 'Entregas::delete/$1');
});
//clientes
$routes->group('', ['filter' => 'authnivel:1,3'], function ($routes) {
$routes->get('/clientes', 'Clientes::index');
$routes->get('/clientes/index', 'Clientes::index');
$routes->get('/clientes/new', 'Clientes::new');
$routes->post('/clientes/create', 'Clientes::create');
$routes->get('/clientes/edit/(:any)', 'Clientes::edit/$1');
$routes->post('/clientes/update', 'Clientes::update');
$routes->post('/clientes/search', 'Clientes::search');
$routes->get('/clientes/delete/(:any)', 'Clientes::delete/$1');
});
//funcionarios
$routes->group('', ['filter' => 'authnivel:1'], function ($routes) {
$routes->get('/funcionarios', 'Funcionarios::index');
$routes->get('/funcionarios/index', 'Funcionarios::index');
$routes->get('/funcionarios/new', 'Funcionarios::new');
$routes->post('/funcionarios/create', 'Funcionarios::create');
$routes->get('/funcionarios/edit/(:any)', 'Funcionarios::edit/$1');
$routes->post('/funcionarios/update', 'Funcionarios::update');
$routes->post('/funcionarios/search', 'Funcionarios::search');
$routes->get('/funcionarios/delete/(:any)', 'Funcionarios::delete/$1');
});








