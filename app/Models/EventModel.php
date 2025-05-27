<?php 
    namespace App\Models;
    use CodeIgniter\Model;

    class EventModel extends Model{
        protected $table = 'event';
        protected $primaryKey = 'id_event';
        protected $allowedFields = [
            'id_admin', 
            'judul_event', 
            'tanggal_event', 
            'lokasi_event', 
            'harga_tiket', 
            'kategori_tiket', 
            'link_tiket', 
            'deskripsi_event', 
            'sponsor', 
            'guest_star', 
            'booth_list'
        ];
    }

?>