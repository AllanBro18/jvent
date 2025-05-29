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
            'username_admin' => session()->get('username_admin'),
            'email_admin' => session()->get('email_admin'),
        ];

        echo view('layout/header', $data);
        echo view('admin/dashboard', $data);
        echo view('layout/footer');
    }
    
    public function dashboard2 ()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $event = new EventModel();

        $data = [
            'title' => 'Dashboard Admin 2',
            'event' => $event->getEvent(),
            'username_admin' => session()->get('username_admin'),
            'email_admin' => session()->get('email_admin'),
        ];

        echo view('layout/header', $data);
        echo view('admin/dashboard2', $data);
        echo view('layout/footer');
    }
}