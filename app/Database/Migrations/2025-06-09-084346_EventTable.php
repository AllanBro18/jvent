<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_event' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'id_admin' => [
                'type'       => 'INT',
                'unsigned' => true
            ],
            'judul_event' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'organizer' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'gambar_event' => [ // Field untuk menyimpan gambar
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, 
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
                'null' => true
            ],
            'guest_star'    => [
                'type'       => 'TEXT',
                'null' => true
            ],
            'booth_list' => [
                'type'       => 'TEXT',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_event', true);
        $this->forge->addForeignKey('id_admin', 'admin', 'id_admin', 'CASCADE', 'CASCADE');
        $this->forge->createTable('event_table', true);
    }

    public function down()
    {
        $this->forge->dropTable('event_table', true);
    }
}
