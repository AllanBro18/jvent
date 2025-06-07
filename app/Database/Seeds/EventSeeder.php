<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_admin' => 2, // pastikan id_admin 1 sudah ada di tabel admin
                'judul_event' => 'J-Culture Festival 2025',
                'organizer' => 'J-Culture Indonesia',
                'slug' => url_title('J-Culture Festival 2025', '-', true),
                'tanggal_event' => '2025-07-15',
                'lokasi_event' => 'Banjarmasin Convention Center',
                'harga_tiket' => 50000,
                'kategori_tiket' => 'Berbayar',
                'link_tiket' => 'https://event.com/jculture',
                'deskripsi_event' => 'Festival budaya Jepang terbesar di Kalimantan Selatan.',
                'sponsor' => 'AnimeMall, Tokopedia',
                'guest_star' => 'Hana Yori Dango, JKT48',
                'booth_list' => 'Cosplay, Kuliner, Merchandise'
            ],
            [
                'id_admin' => 2,
                'judul_event' => 'Otaku Night 2025',
                'organizer' => 'Otaku Community Banjarmasin',
                'slug' => url_title('Otaku Night 2025', '-', true),
                'tanggal_event' => '2025-08-20',
                'lokasi_event' => 'Lapangan Murjani',
                'harga_tiket' => 30000,
                'kategori_tiket' => 'Berbayar (VIP)',
                'link_tiket' => 'https://event.com/otakunight',
                'deskripsi_event' => 'Acara malam cosplay dan konser anisong.',
                'sponsor' => 'Shopee, Gojek',
                'guest_star' => 'DJ Soba, Sakura Band',
                'booth_list' => 'Game, Komik, K-pop Store'
            ]
        ];

        // Simple Queries

        // satu data
        // $this->db->table('event')->insert($data);
        
        // data banyak
        $this->db->table('event')->insertBatch($data);
    }
}