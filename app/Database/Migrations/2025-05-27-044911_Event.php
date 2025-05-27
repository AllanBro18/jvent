<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Event extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_event' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'judul_event' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'tanggal_event' => [
                'type'       => 'DATE',
            ],
            'lokasi_event' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'harga_tiket' => [
                'type'       => 'INT',
            ],
            'kategori_tiket' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'link_tiket'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi_event' => [
                'type'       => 'TEXT',
            ],
            'sponsor' => [
                'type'       => 'TEXT',
            ],
            'guest_star'    => [
                'type'       => 'TEXT',
            ],
            'booth_list' => [
                'type'       => 'TEXT',
            ]
        ]);

        $this->forge->addKey('id_event', true);
        $this->forge->addForeignKey('id_admin', 'admin', 'id_admin', 'CASCADE', 'CASCADE');
        $this->forge->createTable('event', true);
    }

    public function down()
    {
        $this->forge->dropTable('event', true);
    }
}
