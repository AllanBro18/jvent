<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterHargaProdukType extends Migration
{
    public function up()
    {
        $fields = [
            'harga' => [
                'name' => 'harga', // tetap sama
                'type' => 'INT',
            ],
        ];
        $this->forge->modifyColumn('produk', $fields);
    }

    public function down()
    {
        // Balik ke INT kalau di-rollback
        $fields = [
            'harga' => [
                'name' => 'harga',
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ];
        $this->forge->modifyColumn('produk', $fields);
    }
}
