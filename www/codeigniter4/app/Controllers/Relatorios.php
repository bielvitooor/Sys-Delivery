<?php

namespace App\Controllers;
use App\Models\Usuarios as Usuarios_model;
#use CodeIgniter\Controller;

class Relatorios extends BaseController
{
    private $usuarios;
    private $produtos;

    public function __construct(){
        $this->usuarios = new Usuarios_model();
        $this->produtos = new \App\Models\Produtos(); // Initialize the Produtos model
    }


    public function index()
    {
        require_once(APPPATH . 'Libraries/RelatorioPDF.php');

        $user = $this->usuarios->findAll();

        // As medidas são definidas em mm (milimetros)
        $pdf = new \RelatorioPDF();
        $pdf->AliasNbPages(); // Ativa o contador total de páginas
        $pdf->SetMargins(25, 25, 20);        // Margens esquerda, topo, direita
        $pdf->SetAutoPageBreak(true, 20);   // Margem inferior (para rodapé)
        $pdf->AddPage('P', 'A4'); // 'L' = Paisagem ou 'P' - Retrato | Medidas do A4 -> Largura: 210 mm Altura: 297 mm

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, utf8_decode('Relatório de Usuários'), 0, 1, 'C');
        $pdf->Ln(3);

        //cores
        $pdf->SetFillColor(220,220,220);  // Cor de fundo (cinza)
        $pdf->SetTextColor(0, 0, 0);  // Cor do texto (branco)
        $pdf->SetDrawColor(0, 0, 0);        // Cor da borda (preto)

        // Cabeçalho da Tabela
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'ID', 1, 0, 'L', true); //alinhamento do texto - > C: centro, R: direita, L: esquerda
        $pdf->Cell(70, 10, 'Nome', 1, 0, 'L', true);
        $pdf->Cell(70, 10, 'CPF', 1, 0, 'L',true);
        $pdf->Ln();



        // Conteúdo
        $pdf->SetFont('Arial', '', 12);
        foreach ($user as $relUser) {
            $pdf->Cell(20, 8, $relUser->usuarios_id, 1);
            $pdf->Cell(70, 8, utf8_decode($relUser->usuarios_nome.' '.$relUser->usuarios_sobrenome), 1);
            $pdf->Cell(70, 8, utf8_decode($relUser->usuarios_cpf), 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'RelatorioUsuarios.pdf');
        exit;
    }
    function relatorioProdutos(){
        require_once(APPPATH . 'Libraries/RelatorioPDF.php');

        $produtos = $this->produtos->findAll();

        // As medidas são definidas em mm (milimetros)
        $pdf = new \RelatorioPDF();
        $pdf->AliasNbPages(); // Ativa o contador total de páginas
        $pdf->SetMargins(25, 25, 20);        // Margens esquerda, topo, direita
        $pdf->SetAutoPageBreak(true, 20);   // Margem inferior (para rodapé)
        $pdf->AddPage('P', 'A4'); // 'L' = Paisagem ou 'P' - Retrato | Medidas do A4 -> Largura: 210 mm Altura: 297 mm

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, utf8_decode('Relatório de Produtos'), 0, 1, 'C');
        $pdf->Ln(3);

        //cores
        $pdf->SetFillColor(220,220,220);  // Cor de fundo (cinza)
        $pdf->SetTextColor(0, 0, 0);  // Cor do texto (branco)
        $pdf->SetDrawColor(0, 0, 0);        // Cor da borda (preto)

        // Cabeçalho da Tabela
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'ID', 1, 0, 'L', true); //alinhamento do texto - > C: centro, R: direita, L: esquerda
        $pdf->Cell(70, 10, 'Nome', 1, 0, 'L', true);
        $pdf->Cell(70, 10, 'Valor', 1, 0, 'L',true);
        $pdf->Ln();
        // Conteúdo
        $pdf->SetFont('Arial', '', 12);
        foreach($produtos as $relProduto) {
            $pdf->Cell(20, 8, $relProduto->produtos_id, 1);
            $pdf->Cell(70, 8, utf8_decode($relProduto->produtos_nome), 1);
            $pdf->Cell(70, 8, utf8_decode('R$ '.$relProduto->produtos_preco_venda), 1);
            $pdf->Ln();
        }
        $pdf->Output('I', 'RelatorioProdutos.pdf');
        exit;

    }
}
