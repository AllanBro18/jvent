<?php 

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\BoothListModel;
use App\Models\EventModel;
use App\Models\boothModel;
use App\Models\ProdukModel;

class Admin extends BaseController
{
    protected $adminModel;
    
    protected $eventModel;
    protected $boothListModel;
    
    protected $boothModel;
    protected $produkModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->boothListModel = new BoothListModel();
        $this->boothModel = new BoothModel();
        $this->adminModel = new AdminModel();
        $this->produkModel = new ProdukModel();
    }

    public function dashboard ()
    {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Dashboard Admin Home',
            'events' => $this->eventModel->getEvent(),
            'booths' => $this->boothModel->getBooth(),
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/dashboard', $data);
    }

    public function event ()
    {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Dashboard Event',
            'events' => $this->eventModel->getEvent(),
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/event', $data);
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
        } else {
            $query = $query->orderBy('judul_event', 'ASC');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'events' => $query->getEvent(),
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

    public function boothlist()
    {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $eventModel = $this->eventModel;
        $boothListModel = $this->boothListModel;

        $events = $eventModel->findAll();
        $selected_id_event = $this->request->getGet('id_event');

        if ($selected_id_event) {
            $booths = $boothListModel->where('id_event', $selected_id_event)->findAll();
        } else {
            $booths = $boothListModel->findAll();
        }

        $data = [
            'title' => 'Dashboard Manajemen Booth',
            'events' => $events,
            'booths' => $booths,
            'selected_id_event' => $selected_id_event,
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/boothList', $data);
    }

    public function admin () {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'admin' => $this->adminModel->getAdmin(), // spread array
        ];

        return view('admin/admin', $data);
    }
    
    public function booth () {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Dashboard Booth',
            'booths' => $this->boothModel->findAll(),
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/booth', $data);
    }

    public function produkbooth () {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $boothModel = $this->boothModel;
        $produkModel = $this->produkModel;

        $booths = $boothModel->getBooth();
        $selected_id_booth = $this->request->getGet('id_booth');

        if ($selected_id_booth) {
            $produk = $produkModel->where('id_booth', $selected_id_booth)->findAll();
        } else {
            $produk = $produkModel->findAll();
        }

        $data = [
            'title' => 'Dashboard Manajemen Booth',
            'booths' => $booths,
            'produk' => $produk,
            'selected_id_booth' => $selected_id_booth,
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/produkBooth', $data);
    }
}