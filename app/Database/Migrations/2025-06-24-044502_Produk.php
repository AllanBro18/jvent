<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'id_booth' => [
                'type'       => 'INT',
                'unsigned'  => true,
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
            ],
            'harga' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'gambar_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'stok' => [
                'type'       => 'INT',
                'default'    => 0,
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
            $this->forge->addKey('id_produk', true);
            $this->forge->addForeignKey('id_booth', 'booth', 'id_booth', 'CASCADE', 'CASCADE');
            $this->forge->createTable('produk', true);
    }

    public function down()
    {
        $this->forge->dropTable('produk', true);
    }
}
