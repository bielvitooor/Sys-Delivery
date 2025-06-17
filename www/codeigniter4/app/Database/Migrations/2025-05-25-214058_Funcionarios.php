<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFuncionarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'funcionario_id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'usuario_id'     => ['type' => 'INT', 'unsigned' => true],
            'cargo'          => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);

        $this->forge->addKey('funcionario_id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'usuarios_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('funcionarios');
    }

    public function down()
    {
        $this->forge->dropTable('funcionarios');
    }
}
