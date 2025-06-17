<?php
namespace App\Models;
use CodeIgniter\Model;

class Pedidos extends Model
{
    protected $table      = 'pedidos';
    protected $primaryKey = 'pedido_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['cliente_id', 'data_pedido','total', 'endereco_id','status'];
    public    $useTimestamps = false;
}

?>