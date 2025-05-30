<?php 

namespace App\Controllers;

use App\Models\EventModel;

class Admin extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    public function dashboard ()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'event' => $this->eventModel->getEvent(),
            ...$this->getAdminSession(), // spread array
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
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/pengaturan', $data);
    }
}