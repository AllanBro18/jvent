<?php 

namespace App\Models;
use CodeIgniter\Model;

class BoothListModel extends Model {
    protected $table = 'booth_list_table';
    protected $primaryKey = 'id_booth';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nama_booth', 
        'slug',
        'deskripsi_booth', 
        'gambar_booth',
        'harga_sewa', 
        'status',
        'id_event', 
    ];

    public function getBoothById($id_booth) {
        return $this->where('id_booth', $id_booth)->first();
    }
}

?>