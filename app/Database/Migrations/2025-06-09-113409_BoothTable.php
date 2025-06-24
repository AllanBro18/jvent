<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BoothTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_booth' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'id_event' => [
                'type'       => 'INT'
            ],
            'nama_booth' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi_booth' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'gambar_booth' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'harga_sewa' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['tersedia', 'disewa', 'tidak tersedia'],
                'default'    => 'tersedia',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_booth', true);
        $this->forge->addForeignKey('id_event', 'event_table', 'id_event', 'CASCADE', 'CASCADE');
        $this->forge->createTable('booth_list_table', true);
    }

    public function down()
    {
        $this->forge->dropTable('booth_list_table', true);
    }
}
