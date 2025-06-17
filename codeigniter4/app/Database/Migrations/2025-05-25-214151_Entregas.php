<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEntregas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'entrega_id'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'venda_id'      => ['type' => 'INT', 'unsigned' => true],
            'funcionario_id'=> ['type' => 'INT', 'unsigned' => true],
            'data_entrega'  => ['type' => 'DATETIME', 'null' => true],
            'status'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Pendente'],
        ]);

        $this->forge->addKey('entrega_id', true);
        $this->forge->addForeignKey('venda_id', 'vendas', 'venda_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('funcionario_id', 'funcionarios', 'funcionario_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('entregas');
    }

    public function down()
    {
        $this->forge->dropTable('entregas');
    }
}
