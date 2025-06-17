<?php

namespace App\Controllers;
use App\Models\Produtos;
use App\Models\Imgprodutos;

class Home extends BaseController
{
    public function index()
    {
        $login = session()->get('login');
        if ($login) {
            if ($login->usuarios_nivel == 1) {
                $template = 'Templates_admin';
            } elseif ($login->usuarios_nivel == 3) {
                $template = 'Templates_funcionario';
            } elseif ($login->usuarios_nivel == 0) {
                $template = 'Templates_user';
            } else {
                $template = 'Templates'; // fallback para outros níveis
            }
        } else {
            $template = 'Templates'; // visitante
        }
        $data['template'] = $template;
        $data['titulo'] = "Home";
        $data['conteudo'] = "Seja bem vindo ao SYS Delivery!";

        // Busca produtos com categoria e estoque (um registro por produto)
        $produtos = (new Produtos())
            ->select('produtos.*, categorias.categorias_nome, estoque.quantidade')
            ->join('categorias', 'produtos_categorias_id = categorias_id', 'left')
            ->join('estoque', 'estoque.produto_id = produtos.produtos_id', 'left')
            ->findAll();

        // Adiciona imagem ao produto

        $imgModel = new Imgprodutos();
        foreach ($produtos as $key => $produto) {
            $img = $imgModel->where('imgprodutos_produtos_id', $produto->produtos_id)->first();
            $produtos[$key]->imagem = $img ? $img->imgprodutos_link : 'sem-imagem.png';
        }

        // Agrupa por categoria
        $produtosPorCategoria = [];
        foreach ($produtos as $produto) {
            // Só mostra produtos com estoque > 0
            if ((int) $produto->quantidade > 0) {
                $categoria = $produto->categorias_nome ?? 'Sem Categoria';
                $produtosPorCategoria[$categoria][] = $produto;
            }
        }

        $data['produtosPorCategoria'] = $produtosPorCategoria;
        return view('home/index', $data);
    }
}