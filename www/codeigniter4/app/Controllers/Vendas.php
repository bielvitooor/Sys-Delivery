<?php

namespace App\Controllers;
use App\Models\Vendas as VendaModel;
use App\Controllers\BaseController;

class Vendas extends BaseController
{
    public function index()
    {
        $data['vendas'] = (new VendaModel())
            ->select('vendas.*, pedidos.pedido_id, pedidos.total, usuarios.usuarios_nome, usuarios.usuarios_sobrenome')
            ->join('pedidos', 'pedidos.pedido_id = vendas.pedido_id')
            ->join('clientes', 'clientes.cliente_id = pedidos.cliente_id')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
            ->findAll();
        return view('vendas/index', $data);
    }

    public function new()
    {
        $data['form'] = 'Cadastrar';
        $data['op'] = 'create';

        // Só pedidos que ainda não viraram venda
        $data['pedidos'] = (new \App\Models\Pedidos())
            ->select('pedidos.*, usuarios.usuarios_nome, usuarios.usuarios_sobrenome')
            ->join('clientes', 'clientes.cliente_id = pedidos.cliente_id')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
            ->where('pedidos.pedido_id NOT IN (SELECT pedido_id FROM vendas)')

            ->findAll();

        $data['itens'] = []; // Inicialmente vazio
        $data['total'] = 0;
        return view('vendas/form', $data);
    }

    public function getPedidoInfo($pedido_id)
    {
        $itensPedidoModel = new \App\Models\Itens_Pedido();
        $produtosModel = new \App\Models\Produtos();
        $pedidosModel = new \App\Models\Pedidos();
        $enderecosModel = new \App\Models\Enderecos();

        $pedido = $pedidosModel->find($pedido_id);
        $endereco = null;
        if ($pedido && isset($pedido->endereco_id)) {
            $endereco = $enderecosModel->find($pedido->endereco_id);
        }

        $itens = $itensPedidoModel->where('pedidos_pedido_id', $pedido_id)->findAll();
        $total = 0;
        foreach ($itens as &$item) {
            $produto = $produtosModel->find($item->produtos_produtos_id);
            $item->produto_nome = $produto ? $produto->produtos_nome : '';
            $item->preco_venda = isset($item->preco_venda) ? $item->preco_venda : ($produto ? $produto->produtos_preco_venda : 0);
            $item->subtotal = $item->preco_venda * $item->quantidade;
            $total += $item->subtotal;
        }

        return $this->response->setJSON([
            'itens' => $itens,
            'total' => $total,
            'endereco' => $endereco
        ]);
    }

    public function create()
    {

        $pedido_id = (int) $this->request->getPost('pedido_id');




        $vendaModel = new VendaModel();
        $itenspedidoModel = new \App\Models\Itens_Pedido();
        $itensVendaModel = new \App\Models\Itens_Venda();
        $estoqueModel = new \App\Models\Estoque();

        // Salva a venda
        $venda_id = $vendaModel->insert([
            'pedido_id' => $pedido_id,
            'data_venda' => date('Y-m-d H:i:s'),
        ], true);

        // Salva os itens e dá baixa no estoque
        $itens = $itenspedidoModel->where('pedidos_pedido_id', $pedido_id)->findAll();
        foreach ($itens as $item) {
            $itensVendaModel->insert([
                'vendas_venda_id' => $venda_id,
                'produtos_produtos_id' => $item->produtos_produtos_id,
                'preco_venda' => $item->preco_venda,
                'quantidade' => $item->quantidade
            ]);

            // Dá baixa no estoque
            $estoqueAtual = $estoqueModel->where('produto_id', $item->produtos_produtos_id)->first();
            if ($estoqueAtual) {
                $novaQuantidade = $estoqueAtual->quantidade - $item->quantidade;
                if ($novaQuantidade < 0)
                    $novaQuantidade = 0;
                $estoqueModel->update($estoqueAtual->estoque_id, ['quantidade' => $novaQuantidade]);
            }
        }

        return redirect()->to('/vendas');
    }

    public function show($venda_id)
    {
        $vendaModel = new VendaModel();
        $itensVendaModel = new \App\Models\Itens_Venda();
        $produtosModel = new \App\Models\Produtos();
        $clientesModel = new \App\Models\Clientes();
        $usuariosModel = new \App\Models\Usuarios();
        $enderecosModel = new \App\Models\Enderecos();

        // JOIN correto para trazer nome do usuário
        $data['venda'] = $vendaModel
            ->select('vendas.*, pedidos.pedido_id, pedidos.cliente_id, usuarios.usuarios_nome, usuarios.usuarios_sobrenome')
            ->join('pedidos', 'pedidos.pedido_id = vendas.pedido_id')
            ->join('clientes', 'clientes.cliente_id = pedidos.cliente_id')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
            ->where('vendas.venda_id', $venda_id)
            ->first();

        $data['cliente'] = $clientesModel->find($data['venda']->cliente_id);
        $data['usuario'] = $usuariosModel->find($data['cliente']->usuario_id ?? null);

        // Endereço do usuário
        $data['endereco'] = null;
        if ($data['venda'] && isset($data['cliente']->usuario_id)) {
            $data['endereco'] = $enderecosModel->where('usuarios_id', $data['cliente']->usuario_id)->first();
        }

        // Itens e total
        $data['itens'] = $itensVendaModel->where('vendas_venda_id', $venda_id)->findAll();
        $data['total'] = 0;
        foreach ($data['itens'] as &$item) {
            $produto = $produtosModel->find($item->produtos_produtos_id);
            $item->produto_nome = $produto ? $produto->produtos_nome : '';
            $item->subtotal = $item->preco_venda * $item->quantidade;
            $data['total'] += $item->subtotal;
        }

        return view('vendas/show', $data);
    }

    public function delete($id)
    {
        $itensVendaModel = new \App\Models\Itens_Venda();
        $itensVendaModel->where('vendas_venda_id', $id)->delete();

        $entregaModel = new \App\Models\Entrega();
        $entregaModel->where('venda_id', $id)->delete();

        $vendaModel = new VendaModel();
        $vendaModel->delete($id);
        return redirect()->to('/vendas')->with('msg', 'Venda deletada com sucesso!');
    }
}