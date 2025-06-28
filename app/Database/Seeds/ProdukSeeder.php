<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
  public function run()
  {
    $data = [
      [
        'nama_produk' => 'Produk A LuisZen',
        'deskripsi' => 'Deskripsi Produk A dari booth LuisZen',
        'harga' => 15000,
        'gambar_produk' => 'produk_a.jpg',
        'status' => 'tersedia',
        'stok' => 30,
        'id_booth' => 1
      ],
      [
        'nama_produk' => 'Produk A i-GACHA',
        'deskripsi' => 'Deskripsi Produk dari booth i-GACHA',
        'harga' => 20000,
        'gambar_produk' => 'produkgacha.jpg',
        'status' => 'tersedia',
        'stok' => 50,
        'id_booth' => 8
      ],
    ];

    $this->db->table('produk')->insertBatch($data);
  }
}
