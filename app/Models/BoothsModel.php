<?php 

namespace App\Models;
use CodeIgniter\Model;

class BoothsModel extends Model {
    protected $table = 'booths_table';
    protected $primaryKey = 'id_booth';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_admin', 
        'nama_booth', 
        'deskripsi_booth', 
        'gambar_booth',
        'lokasi_booth', 
        'kontak_booth', 
        'jenis_booth'
    ];

}
?>