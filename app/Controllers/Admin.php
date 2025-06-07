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

    public function filter () {
        $sort = $this->request->getVar('sort') ?? 'asc';
        $query = $this->eventModel;

        if ($sort == 'terbaru') {
            $query = $query->orderBy('tanggal_event', 'DESC');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'event' => $query->orderBy('judul_event', strtoupper($sort))->findAll(),
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/dashboard', $data);
    } 

    public function search () {
        $keyword = $this->request->getVar('keyword');
        $query = $this->eventModel; // untuk filter kategori
        
        if ($keyword) {
            $query = $query->search($keyword);
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