<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVendas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'venda_id'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'cliente_id'  => ['type' => 'INT', 'unsigned' => true],
            'data_venda'  => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'total'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        ]);

        $this->forge->addKey('venda_id', true);
        $this->forge->addForeignKey('cliente_id', 'clientes', 'cliente_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('vendas');
    }

    public function down()
    {
        $this->forge->dropTable('vendas');
    }
}
