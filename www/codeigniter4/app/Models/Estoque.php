<?php 
namespace App\Models;
use CodeIgniter\Model;

class Estoque extends Model
{
    protected $table      = 'estoque';
    protected $primaryKey = 'estoque_id';
    protected $returnType = 'object';
    protected $allowedFields = ['produto_id','quantidade'];
    public    $useTimestamps = false;
}
?>