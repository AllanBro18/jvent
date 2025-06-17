<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameBoothTableToBoothListTable extends Migration
{
    public function up()
    {
        $this->forge->renameTable('booth_table', 'booth_list_table');
    }

    public function down()
    {
        $this->forge->renameTable('booth_list_table', 'booth_table');
    }

}
