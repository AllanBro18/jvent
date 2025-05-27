<?php

namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model {
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $allowedFields = [
        'nama_admin', 
        'username_admin', 
        'email_admin',
        'password_admin',
    ];
}