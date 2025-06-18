<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToEventTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('event_table', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'booth_list', // opsional, hanya jika ingin letakkan setelah kolom tertentu
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at', // opsional, hanya jika ingin letakkan setelah kolom tertentu
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('event_table', ['created_at', 'updated_at']);
    }
}
