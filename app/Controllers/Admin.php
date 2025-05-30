<?php 

namespace App\Controllers;

use App\Models\EventModel;

class Admin extends BaseController
{
    public function dashboard ()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $event = new EventModel();
        
        $data = [
            'title' => 'Dashboard Admin',
            'event' => $event->getEvent(),
            'id_admin' => session()->get('id_admin'),
            'username_admin' => session()->get('username_admin'),
            'email_admin' => session()->get('email_admin'),
        ];

        return view('admin/dashboard', $data);
    }
    
    public function info ()
    {
        $data = [
            'title' => 'Dashboard Info',
        ];

        return view('admin/info', $data);
    }
    
    public function pengaturan ()
    {
        $data = [
            'title' => 'Dashboard Pengaturan',
        ];

        return view('admin/pengaturan', $data);
    }
}