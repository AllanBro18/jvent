<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama_admin' => 'chaidar',
            'username_admin'    => 'akhmadch',
            'email_admin'    => 'chaidar@email.com',
            'password_admin'    => password_hash('', PASSWORD_DEFAULT),
        ];

        // // Simple Queries
        // $this->db->query('INSERT INTO users (username, email, password) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('admin')->insert($data);
    }
}