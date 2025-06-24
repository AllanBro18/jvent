<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BoothListSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_booth' => 'Booth C',
                'slug' => 'booth-c',
                'deskripsi_booth' => 'Deskripsi Booth C',
                'gambar_booth' => 'booth_c.jpg',
                'harga_sewa' => 500000,
                'status' => 'tersedia',
                'id_event' => 1,
            ],
            // [
            //     'nama_booth' => 'Booth B',
            //     'slug' => 'booth-b',
            //     'deskripsi_booth' => 'Deskripsi Booth B',
            //     'gambar_booth' => 'booth_b.jpg',
            //     'harga_sewa' => 600000,
            //     'status' => 'available',
            //     'id_event' => 5,
            // ],
        ];

        $this->db->table('booth_list_table')->insertBatch($data);
    }
}
