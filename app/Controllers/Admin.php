<?php 

namespace App\Controllers;

use App\Models\BoothModel;
use App\Models\EventModel;

class Admin extends BaseController
{
    protected $eventModel;
    protected $boothModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->boothModel = new BoothModel();
    }

    public function dashboard ()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'events' => $this->eventModel->getEvent(),
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/dashboard', $data);
    }

    public function searchAndFilter () {
        $keyword = $this->request->getVar('keyword');
        $sort = $this->request->getVar('sort') ?? 'asc';
        $query = $this->eventModel;

        if ($keyword) {
            $query = $query->groupStart()
                        ->like('judul_event', $keyword)
                        ->orLike('lokasi_event', $keyword)
                        ->orLike('organizer', $keyword)
                        ->orLike('kategori_tiket', $keyword)
                        ->groupEnd();
        }

        if ($sort == 'terbaru') {
            $query = $query->orderBy('tanggal_event', 'DESC');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'events' => $query->orderBy('judul_event', strtoupper($sort))->findAll(),
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

    public function booths()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }


        $data = [
            'title' => 'Dashboard Manajemen Booth',
            'booths' => $this->boothModel->select('booth_table.*, event_table.judul_event')
                ->join('event_table', 'booth_table.id_event = event_table.id_event')
                ->findAll(),
            'events' => $this->eventModel->getEvent(),
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/booths', $data);
    }
}