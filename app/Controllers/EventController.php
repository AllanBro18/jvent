<?php

namespace App\Controllers;

use App\Models\EventModel;

class EventController extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jvent'
        ];
        echo view('layout/header', $data);
        echo view('event/index');
        echo view('layout/footer');
    }

    public function create () {
        $data = [
            'title' => 'Form Tambah Data Event',
            'validation' => \Config\Services::validation(),
        ];

        echo view('event/create', $data);
    }

    public function save () {
        // validasi input
        if (!$this->validate([
            'judul_event' => [
                'rules' => 'required|is_unique[event.judul_event]',
                'errors' => [
                    'required' => '{field} event harus diisi',
                    'is_unique' => '{field} event sudah terdaftar',
                ]
            ],
            'gambar_event' => [ // validasi gambar
                'rules' => 'uploaded[gambar_event]|max_size[gambar_event,500]|is_image[gambar_event]|mime_in[gambar_event,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih gambar event terlebih dahulu.',
                    'max_size' => 'Ukuran gambar terlalu besar (maks 500KB).',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.',
                ]
            ],
            'tanggal_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal event harus diisi',
                ]
            ],
            'lokasi_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'lokasi event harus diisi',
                ]
            ],
            'harga_tiket' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'harga tiket harus diisi',
                ]
            ],
            'kategori_tiket' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kategori tiket harus diisi',
                ]
            ],
            'link_tiket' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'link tiket harus diisi',
                ]
            ],
            'deskripsi_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'deskripsi event harus diisi',
                ]
            ],
            'sponsor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'guest_star' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'guest star harus diisi',
                ]
            ],
            'booth_list' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'booth list harus diisi',
                ]
            ]
        ])) { // jika tidak valid
            // pesan kesalahan
            $validation = \Config\Services::validation();

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // ambil file gambar dari input
        $fileGambar = $this->request->getFile('gambar_event');

        // simpan gambar ke folder
        $namaGambar = $fileGambar->getRandomName(); // Buat nama random untuk gambar
        $fileGambar->move('uploads/images', $namaGambar);

        // slug dari input judul buku 
        $slug = url_title($this->request->getVar('judul_event'), '-', true);
        
        // data diambil per key dan dikirim ke model
        $this->eventModel->save([
            'judul_event' => $this->request->getVar('judul_event'),
            'gambar_event' => $namaGambar,
            'slug' => $slug,
            'tanggal_event' => $this->request->getVar('tanggal_event'),
            'lokasi_event' => $this->request->getVar('lokasi_event'),
            'harga_tiket' => $this->request->getVar('harga_tiket'),
            'kategori_tiket' => $this->request->getVar('kategori_tiket'),
            'link_tiket' => $this->request->getVar('link_tiket'),
            'deskripsi_event' => $this->request->getVar('deskripsi_event'),
            'sponsor' => $this->request->getVar('sponsor'),
            'guest_star' => $this->request->getVar('guest_star'),
            'booth_list' => $this->request->getVar('booth_list'),
            'id_admin' => session()->get('id_admin'),
        ]);

        // flash data
        session()->setFlashdata('pesan', 'Event berhasil ditambahkan...');

        return redirect()->to('/event');
    }
    
    public function filter()
    {
        $event = $this->eventModel->getEvent();

        $data = [
            'title' => 'Filter Event',
            'event' => $event,
        ];
        echo view('layout/header', $data);
        echo view('event/filter', $data);
        echo view('layout/footer');
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Event ' . $slug,
            'event' => $this->eventModel->getEvent($slug),
        ];

        // cek jika event tidak ada
        if (empty($data['event'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Event ' . $slug . ' tidak ditemukan');
        } 

        echo view('layout/header', $data);
        echo view('event/detail', $data);
        echo view('layout/footer');
    }
}
