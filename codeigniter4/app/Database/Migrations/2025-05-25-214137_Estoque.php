<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEstoque extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'estoque_id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'produto_id' => ['type' => 'INT', 'unsigned' => true],
            'quantidade' => ['type' => 'INT', 'unsigned' => true],
        ]);

        $this->forge->addKey('estoque_id', true);
        $this->forge->addForeignKey('produto_id', 'produtos', 'produtos_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('estoque');
    }

    public function down()
    {
        $this->forge->dropTable('estoque');
    }
}
