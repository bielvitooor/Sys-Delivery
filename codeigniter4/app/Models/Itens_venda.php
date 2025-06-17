<?php
namespace App\Models;
use CodeIgniter\Model;

class Itens_Venda extends Model
{
    protected $table      = 'itens_venda';
    protected $primaryKey = 'itens_venda_id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'vendas_venda_id',
        'produtos_produtos_id',
        'preco_venda',
        'quantidade'
    ];
}