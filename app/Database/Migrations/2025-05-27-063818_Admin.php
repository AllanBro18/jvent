<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_admin' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'nama_admin' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'username_admin' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email_admin' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password_admin' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ]
        ]);

        $this->forge->addKey('id_admin', true);
        $this->forge->createTable('admin', true);
    }

    public function down()
    {
        $this->forge->dropTable('admin', true);
    }
}
