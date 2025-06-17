<?php
namespace App\Models;
use CodeIgniter\Model;

class Itens_pedido extends Model
{
    protected $table      = 'itens_pedido';
    protected $primaryKey = 'itens_pedido_id';
    protected $returnType = 'object';
    protected $allowedFields = [
    'pedidos_pedido_id',
    'produtos_produtos_id',
    'preco_venda',
    'quantidade',
    
    ];
}