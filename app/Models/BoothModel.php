<?php 

namespace App\Models;
use CodeIgniter\Model;

class BoothModel extends Model {
    protected $table = 'booth_table';
    protected $primaryKey = 'id_booth';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nama_booth', 
        'slug',
        'deskripsi_booth', 
        'gambar_booth',
        'jenis_booth',
        'lokasi_booth', 
        'kontak_booth', 
        'id_admin', 
    ];

    public function getBooth($slug = false) {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }
}

?>