<?php 

namespace App\Models;
use CodeIgniter\Model;

class EventModel extends Model {
    protected $table = 'event';
    protected $primaryKey = 'id_event';
    protected $allowedFields = [
        'judul_event', 
        'gambar_event', 
        'slug',
        'tanggal_event', 
        'lokasi_event', 
        'harga_tiket', 
        'kategori_tiket', 
        'link_tiket', 
        'deskripsi_event', 
        'sponsor', 
        'guest_star', 
        'booth_list',
        'id_admin', 
    ];

    public function getEvent ($slug = false) {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }

    public function search ($keyword) {
        return $this->table('event')
            ->like('judul_event', $keyword)
            ->orLike('lokasi_event', $keyword);
    }
}

?>