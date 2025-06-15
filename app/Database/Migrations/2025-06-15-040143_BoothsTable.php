<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BoothsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_booth' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'id_admin' => [
                'type'       => 'INT',
                'unsigned'  => true,
            ],
            'nama_booth' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi_booth' => [
                'type'       => 'TEXT',
            ],
            'jenis_booth' => [
                'type'       => 'ENUM',
                'constraint' => ['makanan & minuman', 'komunitas', 'merchandise', 'lainnya'],
                'default'    => 'komunitas',
            ],
            'gambar_booth' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'lokasi_booth' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'kontak_booth' => [
                'type'       => 'TEXT',
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
        $this->forge->addForeignKey('id_admin', 'admin', 'id_admin', 'CASCADE', 'CASCADE');
        $this->forge->createTable('booths_table', true);
    }

    public function down()
    {
        $this->forge->dropTable('booths_table', true);
    }
}
