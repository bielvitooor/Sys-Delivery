<?php
namespace App\Controllers;
use App\Models\Produtos;
use App\Models\Imgprodutos;

class Carrinho extends BaseController
{
    public function add($produto_id)
    {
        $session = session();
        $carrinho = $session->get('carrinho') ?? [];

        // Busca produto
        $produto = (new Produtos())->find($produto_id);
        if (!$produto) {
            return redirect()->back()->with('msg', 'Produto não encontrado!');
        }

        // Busca imagem
        $img = (new Imgprodutos())->where('imgprodutos_produtos_id', $produto_id)->first();
        $imagem = $img ? $img->imgprodutos_link : 'sem-imagem.png';

        // Se já existe, soma quantidade
        if (isset($carrinho[$produto_id])) {
            $carrinho[$produto_id]['quantidade'] += 1;
        } else {
            $carrinho[$produto_id] = [
                'produto_id' => $produto->produtos_id,
                'nome' => $produto->produtos_nome,
                'preco' => $produto->produtos_preco_venda,
                'imagem' => $imagem,
                'quantidade' => 1
            ];
        }

        $session->set('carrinho', $carrinho);
        return redirect()->to('/carrinho');
    }

    public function index()
    {
        // Sempre pega o carrinho atualizado da sessão
        $carrinho = session()->get('carrinho') ?? [];
        return view('carrinho/index', ['carrinho' => $carrinho]);
    }

    public function remove($produto_id)
    {
        $carrinho = session()->get('carrinho') ?? [];
        unset($carrinho[$produto_id]);
        session()->set('carrinho', $carrinho);
        return redirect()->to('/carrinho');
    }

    public function update()
    {
        $session = session();
        $carrinho = $session->get('carrinho') ?? [];
        $data = json_decode($this->request->getBody(), true);

        if (isset($data['produto_id'], $data['quantidade'])) {
            foreach ($carrinho as &$item) {
                if ($item['produto_id'] == $data['produto_id']) {
                    $item['quantidade'] = (int) $data['quantidade'];
                    break;
                }
            }
            $session->set('carrinho', $carrinho);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }

    public function checkout()
    {
        $session = session();
        $login = $session->get('login');
        $carrinho = $session->get('carrinho') ?? [];
        // Atualiza quantidades se vierem via POST
        $quantidades = $this->request->getPost('quantidades');
        if ($quantidades) {
            foreach ($carrinho as &$item) {
                if (isset($quantidades[$item['produto_id']])) {
                    $item['quantidade'] = (int) $quantidades[$item['produto_id']];
                }
            }
            $session->set('carrinho', $carrinho);
        }

        if (empty($carrinho)) {
            return redirect()->to('/carrinho')->with('msg', 'Seu carrinho está vazio!');
        }

        // Busca cliente_id
        $cliente = (new \App\Models\Clientes())->where('usuario_id', $login->usuarios_id)->first();
        $cliente_id = $cliente ? $cliente->cliente_id : null;

        // Busca endereços do usuário
        $enderecos = (new \App\Models\Enderecos())->where('usuarios_id', $login->usuarios_id)->findAll();

        // Monta os itens para o form
        $itens = [];
        foreach ($carrinho as $item) {
            $itens[] = (object) [
                'produtos_produtos_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'preco_venda' => $item['preco'],
            ];
        }

        // Busca todos os produtos para o select (se necessário)
        $produtos = (new \App\Models\Produtos())->findAll();

        // Monta os dados para a view do form de pedido
        return view('pedidos/form', [
            'form' => 'Cadastrar',
            'op' => 'create',
            'isCliente' => true,
            'cliente_nome' => $login->usuarios_nome . ' ' . $login->usuarios_sobrenome,
            'cliente_id' => $cliente_id,
            'enderecos' => $enderecos,
            'itens' => $itens,
            'produtos' => $produtos,
            'usuario_nivel' => $login->usuarios_nivel,
        ]);
    }
}