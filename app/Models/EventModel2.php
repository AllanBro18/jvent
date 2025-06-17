<?php 

namespace App\Models;
use CodeIgniter\Model;

class EventModel2 extends Model {
    protected $table = 'event_table';
    protected $primaryKey = 'id_event';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'judul_event', 
        'gambar_event',
        'organizer', 
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

    public function getEventById($id_event) {
        return $this->where(['id_event' => $id_event])->first();
    }
}

?>