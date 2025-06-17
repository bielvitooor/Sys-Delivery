<?php
namespace App\Models;
use CodeIgniter\Model;

class Clientes extends Model
{
    protected $table      = 'clientes';
    protected $primaryKey = 'cliente_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['usuario_id'];
    public    $useTimestamps = false;
}
?>