<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameBoothTableToBoothListTable extends Migration
{
    public function up()
    {
        // Cek apakah tabel 'event' ada sebelum di-rename
        $result = $this->db->query("SHOW TABLES LIKE 'booth_table'")->getResult();

        if (!empty($result)) {
            $this->forge->renameTable('booth_table', 'booth_list_table');
            echo "Tabel 'booth_table' berhasil diubah menjadi 'booth_list_table'.\n";
        } else {
            echo "Tabel 'booth_table' tidak ditemukan. Rename dibatalkan.\n";
        }
    }

    public function down()
    {
        // Cek apakah tabel 'events' ada sebelum di-rename kembali
        $result = $this->db->query("SHOW TABLES LIKE 'booth_list_table'")->getResult();

        if (!empty($result)) {
            $this->forge->renameTable('booth_list_table', 'booth_table');
            echo "Tabel 'booth_list_table' berhasil dikembalikan menjadi 'booth_table'.\n";
        } else {
            echo "Tabel 'booth_list_table' tidak ditemukan. Rename dibatalkan.\n";
        }
    }
}
