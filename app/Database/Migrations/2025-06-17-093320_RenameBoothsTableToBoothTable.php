<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameBoothsTableToBoothTable extends Migration
{
    public function up()
    {
        $this->forge->renameTable('booths_table', 'booth_table');
    }

    public function down()
    {
        $this->forge->renameTable('booth_table', 'booths_table');
    }
}
