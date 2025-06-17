<?php
namespace App\Controllers;
use App\Models\Itens_venda as ItensVendaModel;
use App\Models\Produtos;

class ItensVenda extends BaseController
{
    
    public function index($venda_id)
    {
        $itensModel = new ItensVendaModel();
        $produtosModel = new Produtos();

        $itens = $itensModel
            ->where('vendas_venda_id', $venda_id)
            ->findAll();

        // Busca os dados dos produtos para exibir nome, etc.
        foreach ($itens as &$item) {
            $produto = $produtosModel->find($item['produtos_produtos_id']);
            $item['produto_nome'] = $produto ? $produto['produtos_nome'] : '';
        }

        return view('itens_venda/index', [
            'itens' => $itens,
            'venda_id' => $venda_id
        ]);
    }
    public function new($venda_id)
    {
        $produtos = (new Produtos())->findAll();
        return view('itens_venda/form', [
            'venda_id' => $venda_id,
            'produtos' => $produtos,
            'form' => 'Cadastrar',
            'op' => 'create'
        ]);
    }
    public function create()
    {
        $venda_id = $this->request->getPost('venda_id');
        $produtos_produtos_id = $this->request->getPost('produtos_produtos_id');
        $preco_venda = $this->request->getPost('preco_venda');
        $quantidade = $this->request->getPost('quantidade');

        (new ItensVendaModel())->insert([
            'vendas_venda_id' => $venda_id,
            'produtos_produtos_id' => $produtos_produtos_id,
            'preco_venda' => $preco_venda,
            'quantidade' => $quantidade
        ]);

        return redirect()->to("/itens_venda/index/$venda_id");
    }
    public function edit($id)
    {
        $itensVendaModel = new ItensVendaModel();
        $item = $itensVendaModel->find($id);
        if (!$item) {
            return redirect()->to('/itens_venda')->with('msg', 'Item não encontrado.');
        }

        $produtos = (new Produtos())->findAll();
        return view('itens_venda/form', [
            'item' => $item,
            'produtos' => $produtos,
            'form' => 'Editar',
            'op' => 'update'
        ]);
    }
    
}