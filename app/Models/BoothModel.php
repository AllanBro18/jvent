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
        'harga_sewa', 
        'status',
        'id_event', 
    ];

    public function getBoothsByEvent($id_event) {
        return $this->where('id_event', $id_event)->findAll();
    }

    public function getBooth($slug = false, $id_event = null) {
        if ($slug === false) {
            return $this->findAll();
        }

        $builder = $this->where(['slug' => $slug]);
        if ($id_event !== null) {
            $builder = $builder->where(['id_event' => $id_event]);
        }
        return $builder->first();
    }
}

?>