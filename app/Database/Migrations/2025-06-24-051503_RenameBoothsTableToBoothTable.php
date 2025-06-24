<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameBoothsTableToBoothTable extends Migration
{
    public function up()
    {
        // Cek apakah tabel 'event' ada sebelum di-rename
        $result = $this->db->query("SHOW TABLES LIKE 'booths_table'")->getResult();

        if (!empty($result)) {
            $this->forge->renameTable('booths_table', 'booth_table');
            echo "Tabel 'booths_table' berhasil diubah menjadi 'booth_table'.\n";
        } else {
            echo "Tabel 'booths_table' tidak ditemukan. Rename dibatalkan.\n";
        }
    }

    public function down()
    {
        // Cek apakah tabel 'events' ada sebelum di-rename kembali
        $result = $this->db->query("SHOW TABLES LIKE 'booth_table'")->getResult();

        if (!empty($result)) {
            $this->forge->renameTable('booth_table', 'booths_table');
            echo "Tabel 'booth_table' berhasil dikembalikan menjadi 'booths_table'.\n";
        } else {
            echo "Tabel 'booth_table' tidak ditemukan. Rename dibatalkan.\n";
        }
    }
}