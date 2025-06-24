<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BoothsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_booth' => 'LuisZen',
                'slug' => 'booth-a',
                'deskripsi_booth' => 'Deskripsi Booth A',
                'jenis_booth' => 'makanan & minuman',
                'gambar_booth' => 'booth_a.jpg',
                'lokasi_booth' => 'Lokasi Booth A',
                'kontak_booth' => 'https://wa.me/1234567890',
                'id_admin' => 1,
            ],
            [
                'nama_booth' => 'Booth B',
                'slug' => 'booth-b',
                'deskripsi_booth' => 'Deskripsi Booth B',
                'gambar_booth' => 'booth_b.jpg',
                'jenis_booth' => 'komunitas',
                'lokasi_booth' => 'Lokasi Booth B',
                'kontak_booth' => 'https://linktr.ee/boothb',
                'id_admin' => 1,
            ],
        ];

        $this->db->table('booth')->insertBatch($data);
    }
}
