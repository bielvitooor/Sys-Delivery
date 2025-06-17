<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cliente_id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'usuario_id' => ['type' => 'INT', 'unsigned' => true],
            'endereco'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'cidade_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
        ]);

        $this->forge->addKey('cliente_id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'usuarios_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cidade_id', 'cidades', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('clientes');
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
    }
}
