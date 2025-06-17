<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePedidos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pedido_id'      => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'venda_id'       => ['type' => 'INT', 'unsigned' => true],
            'produto_id'     => ['type' => 'INT', 'unsigned' => true],
            'quantidade'     => ['type' => 'INT', 'unsigned' => true],
            'preco_unitario' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        ]);

        $this->forge->addKey('pedido_id', true);
        $this->forge->addForeignKey('venda_id', 'vendas', 'venda_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produtos', 'produtos_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos');
    }
}
