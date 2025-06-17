<?php
namespace App\Models;
use CodeIgniter\Model;

class Vendas extends Model
{
    protected $table      = 'vendas';
    protected $primaryKey = 'venda_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['data_venda','pedido_id'];
    protected $useTimestamps = false;
}
?>