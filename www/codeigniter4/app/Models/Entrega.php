<?php
namespace App\Models;
use CodeIgniter\Model;

class Entrega extends Model
{
    protected $table      = 'entregas';
    protected $primaryKey = 'entrega_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['venda_id','funcionario_id','data_saiu_entrega','data_entrega','status'];
    public    $useTimestamps = false;
}
?>