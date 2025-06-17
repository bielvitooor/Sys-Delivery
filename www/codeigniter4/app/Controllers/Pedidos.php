<?php
namespace App\Controllers;
use App\Models\Pedidos as PedidoModel;
use App\Models\Vendas as VendasModel;
use App\Models\Produtos as ProdutoModel;
use App\Models\Itens_pedido as ItensPedidos;
use App\Controllers\BaseController;
use App\Models\Clientes;

class Pedidos extends BaseController
{
    public function index()
    {

        $login = session()->get('login');

        switch ($login->usuarios_nivel ?? null) {
            case 1:
                $template = 'Templates_admin';
                break;
            case 3:
                $template = 'Templates_funcionario';
                break;
            case 0:
                $template = 'Templates_user';
                break;
            default:
                $template = 'Templates';
        }
        $data['template'] = $template;
        $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;

        $cliente_id_logado = isset($login->usuarios_id) ? $login->usuarios_id : null;

        $pedidoModel = new PedidoModel();
        $pedidoModel->select('pedidos.*, pedidos.status, clientes.cliente_id, usuarios.usuarios_nome, usuarios.usuarios_sobrenome')
            ->join('clientes', 'clientes.cliente_id = pedidos.cliente_id')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id');

        // Se não for admin, mostra só os pedidos do usuário logado
        if ($usuario_nivel != 1 && $usuario_nivel != 3) {
            // Busca o cliente_id correspondente ao usuario_id logado
            $cliente = (new Clientes())->where('usuario_id', $cliente_id_logado)->first();
            if ($cliente) {
                $pedidoModel->where('pedidos.cliente_id', $cliente->cliente_id);
            } else {
                // Não encontrou cliente, retorna lista vazia
                $data['pedidos'] = [];
                return view('pedidos/index', $data);
            }
        }

        $data['pedidos'] = $pedidoModel->findAll();
        return view('pedidos/index', $data);
    }

    public function new()
    {
        $data['form'] = 'Cadastrar';
        $data['op'] = 'create';
        $data['clientes'] = (new Clientes())
            ->select('clientes.*, usuarios.usuarios_nome, usuarios.usuarios_sobrenome')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
            ->findAll();
        $data['produtos'] = (new ProdutoModel())
            ->select('produtos.*, estoque.quantidade as estoque')
            ->join('estoque', 'estoque.produto_id = produtos.produtos_id', 'left')
            ->findAll();
        $data['itens'] = [];

        $login = session()->get('login');
        $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
        $data['usuario_nivel'] = $usuario_nivel;
        $data['isCliente'] = ($usuario_nivel == 0);
        $data['cliente_nome'] = isset($login->usuarios_nome) && isset($login->usuarios_sobrenome) ? $login->usuarios_nome . ' ' . $login->usuarios_sobrenome : '';
        $data['cliente_id'] = isset($login->usuarios_id) ? $login->usuarios_id : '';
        $login = session()->get('login');
        switch ($login->usuarios_nivel ?? null) {
            case 1:
                $template = 'Templates_admin';
                break;
            case 3:
                $template = 'Templates_funcionario';
                break;
            case 0:
                $template = 'Templates_user';
                break;
            default:
                $template = 'Templates';
        }
        $data['template'] = $template;
        if ($data['isCliente']) {
            // Busca o cliente_id pelo usuario_id logado
            $cliente = (new Clientes())->where('usuario_id', $login->usuarios_id)->first();
            $data['cliente_id'] = $cliente ? $cliente->cliente_id : '';
            $data['enderecos'] = (new \App\Models\Enderecos())
                ->where('usuarios_id', $login->usuarios_id)
                ->findAll();
        } else {
            $data['enderecos'] = [];
        }

        return view('pedidos/form', $data);
    }

    public function create()
    {
        $login = session()->get('login');
        $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
        $usuario_id_logado = isset($login->usuarios_id) ? $login->usuarios_id : null;

        if ($usuario_nivel != 1) {
            // Busca o cliente_id pelo usuario_id logado
            $cliente = (new Clientes())->where('usuario_id', $usuario_id_logado)->first();
            $cliente_id = $cliente ? $cliente->cliente_id : null;
        } else {
            $cliente_id = $this->request->getPost('cliente_id');
        }

        $endereco_id = $this->request->getPost('endereco_id');
        $produtos = $this->request->getPost('produtos');
        $status = $this->request->getPost('status', FILTER_SANITIZE_STRING);
        if (!$status) {
            $status = 'Pendente'; // Define um status padrão se não for enviado
        }

        $total = 0;
        foreach ($produtos as $item) {
            $total += floatval($item['preco_unitario']) * intval($item['quantidade']);
        }

        $pedidoModel = new PedidoModel();
        $pedido_id = $pedidoModel->insert([
            'cliente_id' => $cliente_id,
            'data_pedido' => date('Y-m-d H:i:s'),
            'total' => $total,
            'endereco_id' => $endereco_id,
            'status' => $status
        ]);

        $itensPedidoModel = new ItensPedidos();
        foreach ($produtos as $item) {
            $itensPedidoModel->insert([
                'pedidos_pedido_id' => $pedido_id,
                'produtos_produtos_id' => $item['produto_id'],
                'preco_venda' => $item['preco_unitario'],
                'quantidade' => $item['quantidade']
            ]);
        }

        return redirect()->to('/pedidos');
    }

    public function enderecos_cliente($cliente_id)
    {
        $cliente = (new Clientes())->find($cliente_id);
        if (!$cliente) {
            return $this->response->setJSON(['error' => 'Cliente não encontrado']);
        }

        $enderecos = (new \App\Models\Enderecos())
            ->where('usuarios_id', $cliente->usuario_id)
            ->findAll();
        return $this->response->setJSON($enderecos);
    }

    public function edit($id)
    {
        $pedidoModel = new PedidoModel();
        $data['form'] = 'Editar';
        $data['op'] = 'update';
        $data['pedido'] = $pedidoModel->find($id);

        $login = session()->get('login');

        $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
        $login = session()->get('login');
        switch ($login->usuarios_nivel ?? null) {
            case 1:
                $template = 'Templates_admin';
                break;
            case 3:
                $template = 'Templates_funcionario';
                break;
            case 0:
                $template = 'Templates_user';
                break;
            default:
                $template = 'Templates';
        }
        $data['template'] = $template;
        $data['usuario_nivel'] = $usuario_nivel;
        $data['isCliente'] = ($usuario_nivel == 0);
        $data['cliente_nome'] = isset($login->usuarios_nome) && isset($login->usuarios_sobrenome) ? $login->usuarios_nome . ' ' . $login->usuarios_sobrenome : '';
        $data['cliente_id'] = isset($login->usuarios_id) ? $login->usuarios_id : '';
        if ($usuario_nivel != 1 && $usuario_nivel != 3) { // Se não for admin
            // Busca o cliente_id pelo usuario_id logado
            $cliente = (new Clientes())->where('usuario_id', $login->usuarios_id)->first();
            $cliente_id = $cliente ? $cliente->cliente_id : '';

            if (!$data['pedido'] || $data['pedido']->cliente_id != $cliente_id) {
                // Redireciona para página de erro personalizada
                return service('response')
                    ->setStatusCode(403)
                    ->setBody(view('errors/html/error_400', [
                        'title' => 'Acesso Negado',
                        'message' => 'Você não tem permissão para editar este pedido.'
                    ]));
            }
        }
        if ($data['isCliente']) {
            // Busca o cliente_id pelo usuario_id logado
            $cliente = (new Clientes())->where('usuario_id', $login->usuarios_id)->first();
            $data['cliente_id'] = $cliente ? $cliente->cliente_id : '';
            $data['enderecos'] = (new \App\Models\Enderecos())
                ->where('usuarios_id', $login->usuarios_id)
                ->findAll();
        } else {
            // Admin pode editar qualquer pedido
            if ($data['pedido']) {
                $cliente_id = $data['pedido']->cliente_id;
                $cliente = (new \App\Models\Clientes())->find($cliente_id);
                if ($cliente) {
                    $data['enderecos'] = (new \App\Models\Enderecos())
                        ->where('usuarios_id', $cliente->usuario_id)
                        ->findAll();
                } else {
                    $data['enderecos'] = [];
                }
            } else {
                $data['enderecos'] = [];
            }
        }

        $data['clientes'] = (new Clientes())
            ->select('clientes.*, usuarios.usuarios_nome, usuarios.usuarios_sobrenome')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
            ->findAll();
        $data['itens'] = (new ItensPedidos())
            ->select('itens_pedido.*, produtos.produtos_nome, produtos.produtos_id')
            ->join('produtos', 'produtos.produtos_id = itens_pedido.produtos_produtos_id')
            ->where('itens_pedido.pedidos_pedido_id', $id)
            ->findAll();

        $data['produtos'] = (new ProdutoModel())
            ->select('produtos.*, estoque.quantidade as estoque')
            ->join('estoque', 'estoque.produto_id = produtos.produtos_id', 'left')
            ->findAll();

        return view('pedidos/form', $data);
    }

    public function update()
    {
        $login = session()->get('login');
        $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
        $usuario_id_logado = isset($login->usuarios_id) ? $login->usuarios_id : null;
        $pedido_id = $this->request->getPost('pedido_id');

        if ($usuario_nivel != 1 && $usuario_nivel != 3) { // Se não for admin
            // Busca o cliente_id pelo usuario_id logado
            $cliente = (new Clientes())->where('usuario_id', $usuario_id_logado)->first();
            $cliente_id = $cliente ? $cliente->cliente_id : null;
        } else {
            $cliente_id = $this->request->getPost('cliente_id');
        }

        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($pedido_id);

        // Proteção: só deixa alterar se for admin ou dono do pedido
        if ($usuario_nivel != 1 && $pedido && $pedido->cliente_id != $cliente_id) {
            return redirect()->to('/pedidos')->with('error', 'Você não pode alterar este pedido!');
        }

        $produtos = $this->request->getPost('produtos');
        $total = 0;
        foreach ($produtos as $item) {
            $preco_unitario = isset($item['preco_unitario']) ? floatval($item['preco_unitario']) : 0;
            $total += floatval($preco_unitario) * intval($item['quantidade']);
        }

        $pedidoModel->update($pedido_id, [
            'cliente_id' => $cliente_id,
            'endereco_id' => $this->request->getPost('endereco_id'),
            'total' => $total,
            'data_pedido' => date('Y-m-d H:i:s'),
            'status' => $this->request->getPost('status')
        ]);

        $itensPedidoModel = new ItensPedidos();
        $itensPedidoModel->where('pedidos_pedido_id', $pedido_id)->delete();
        foreach ($produtos as $item) {
            $itensPedidoModel->insert([
                'pedidos_pedido_id' => $pedido_id,
                'produtos_produtos_id' => $item['produto_id'],
                'preco_venda' => $item['preco_unitario'],
                'quantidade' => $item['quantidade']
            ]);
        }
        if ($status = $this->request->getPost('status') == 'Aceito') {
            // Se o status for Aceito, cria uma venda
            $vendaModel = new VendasModel();
            $vendaModel->insert([
                'pedido_id' => $pedido_id,
                'data_venda' => date('Y-m-d H:i:s'),
            ]);
            $itensVendaModel = new \App\Models\Itens_Venda();
            foreach ($produtos as $item) {
                $itensVendaModel->insert([
                    'vendas_venda_id' => $vendaModel->insertID(),
                    'produtos_produtos_id' => $item['produto_id'],
                    'preco_venda' => $item['preco_unitario'],
                    'quantidade' => $item['quantidade']
                ]);
            }
        }

        return redirect()->to('/pedidos');
    }

    public function show($pedido_id)
    {
        $pedidoModel = new \App\Models\Pedidos();
        $itensPedidoModel = new \App\Models\Itens_Pedido();
        $produtosModel = new \App\Models\Produtos();
        $clientesModel = new \App\Models\Clientes();
        $usuariosModel = new \App\Models\Usuarios();
        $enderecosModel = new \App\Models\Enderecos();
        $entregaModel = new \App\Models\Entrega();

        $pedido = $pedidoModel
            ->select('pedidos.*, clientes.usuario_id, usuarios.usuarios_nome, usuarios.usuarios_sobrenome')
            ->join('clientes', 'clientes.cliente_id = pedidos.cliente_id')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
            ->where('pedidos.pedido_id', $pedido_id)
            ->first();

        $login = session()->get('login');
        switch ($login->usuarios_nivel ?? null) {
            case 1:
                $template = 'Templates_admin';
                break;
            case 3:
                $template = 'Templates_funcionario';
                break;
            case 0:
                $template = 'Templates_user';
                break;
            default:
                $template = 'Templates';
        }
        $data['template'] = $template;

        $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;

        if ($usuario_nivel != 1 && $usuario_nivel != 3) { // Se não for admin
            // Busca o cliente_id pelo usuario_id logado
            $cliente = (new \App\Models\Clientes())->where('usuario_id', $login->usuarios_id)->first();
            $cliente_id = $cliente ? $cliente->cliente_id : '';

            if (!$pedido || $pedido->cliente_id != $cliente_id) {
                // Redireciona para página de erro personalizada
                return service('response')
                    ->setStatusCode(400)
                    ->setBody(view('errors/html/error_400', [
                        'title' => 'Acesso Negado',
                        'message' => 'Você não tem permissão para visualizar este pedido.'
                    ]));
            }
        }

        $endereco = $enderecosModel->find($pedido->endereco_id ?? null);

        $itens = $itensPedidoModel->where('pedidos_pedido_id', $pedido_id)->findAll();
        foreach ($itens as &$item) {
            $produto = $produtosModel->find($item->produtos_produtos_id);
            $item->produto_nome = $produto ? $produto->produtos_nome : '';
            $item->subtotal = $item->preco_venda * $item->quantidade;
        }

        $entrega = $entregaModel->where('venda_id', function ($builder) use ($pedido_id) {
            $builder->select('venda_id')->from('vendas')->where('pedido_id', $pedido_id);
        })->first();

        return view('pedidos/show', [
            'pedido' => $pedido,
            'endereco' => $endereco,
            'itens' => $itens,
            'entrega' => $entrega,
            'template' => $template,
            'usuario_nivel' => $usuario_nivel,
        ]);
    }

    public function delete($id)
    {
        $pedidoModel = new PedidoModel();
        $vendaModel = new VendasModel();
        $itensPedidoModel = new ItensPedidos();
        $entregaModel = new \App\Models\Entrega();
        $itensVendaModel = new \App\Models\Itens_Venda();

        $venda = $vendaModel->where('pedido_id', $id)->first();

        if ($venda) {
            $entregaModel->where('venda_id', $venda->venda_id)->delete();
            if (class_exists('\App\Models\Itens_Venda')) {
                $itensVendaModel->where('vendas_venda_id', $venda->venda_id)->delete();
            }
            $vendaModel->delete($venda->venda_id);
        }

        $itensPedidoModel->where('pedidos_pedido_id', $id)->delete();
        $pedidoModel->delete($id);

        return redirect()->to('/pedidos');
    }
}