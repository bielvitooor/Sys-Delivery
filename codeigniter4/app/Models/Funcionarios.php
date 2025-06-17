<?php 
namespace App\Models;
use CodeIgniter\Model;

class Funcionarios extends Model
{
    protected $table      = 'funcionarios';
    protected $primaryKey = 'usuario_id';
    protected $returnType = 'object';
    protected $allowedFields = ['usuario_id','cargo'];
    public    $useTimestamps = false;
}
?>