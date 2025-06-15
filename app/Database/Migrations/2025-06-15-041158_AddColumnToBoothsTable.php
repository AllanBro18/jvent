<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToBoothsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('booths_table', [
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'nama_booth', // opsional, hanya jika ingin letakkan setelah kolom tertentu
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('booths_table', 'slug');
    }
}
