<?php
namespace App\Controllers;
use App\Models\Estoque as EstoqueModel;
use App\Models\Produtos as ProdutoModelSingle;

class Estoques extends BaseController
{
    private $estoqueModel;
    private $produtoModelSingle;
    public function __construct()
    {
        $this->estoqueModel = new EstoqueModel();
        $this->produtoModelSingle = new ProdutoModelSingle();
        helper('functions');
    }
    public function index()
    {
        $estoque = $this->estoqueModel
            ->select('estoque.*, produtos.produtos_nome')
            ->join('produtos','produtos.produtos_id = estoque.produto_id')
            ->findAll();
        return view('estoques/index',['estoque'=>$estoque]);
    }

    public function new()
    {
        $data['produtos'] = (new ProdutoModelSingle())->findAll();
        $data['form']= 'Cadastrar'; // ou 'Novo', como preferir
        $data['op'] = 'create';
        $data['estoque'] = (object)[
            'estoque_id' => '',
            'produto_id' => '',
            'quantidade' => ''
        ];
        $data['vendas'] = (new \App\Models\Vendas())->findAll();
        return view('estoques/form', $data);
    }

    public function create()
    {
        $em = new EstoqueModel();
        $data['produtos'] = (new ProdutoModelSingle())->findAll();
        $em->insert([
            'produto_id'=> $this->request->getPost('produto_id'),
            'quantidade'=> $this->request->getPost('quantidade')
        ]);
        return redirect()->to('/estoques');
    }
    public function edit($id)
    {
        $data['produtos'] = (new ProdutoModelSingle())->findAll();
        $data['estoque'] = (new EstoqueModel())->find($id);
        $data['vendas'] = (new \App\Models\Vendas())->findAll();
        $data['form']= 'Editar'; // ou 'Novo', como preferir
        $data['op'] = 'update';
        return view('estoques/form', $data);
    }
    public function update($id)
    {
        $dataform = [
            'produto_id' => $this->request->getPost('produto_id'),
            'quantidade' => $this->request->getPost('quantidade')
        ];
        $this->estoqueModel->update($id, $dataform);
        $data['msg']=msg('Atualizado com Sucesso!','success');
        return redirect()->to('/estoques');
        

    }
}
?>