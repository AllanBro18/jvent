<?php

namespace App\Controllers;

use App\Models\BoothListModel;
use App\Models\EventModel;

use function PHPUnit\Framework\fileExists;

class EventController extends BaseController
{
    protected $eventModel;
    protected $boothListModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->boothListModel = new BoothListModel(); 
    }

    public function index()
    {
        $data = [
            'events' => $this->eventModel->getEvent(),
        ];

        return 
        view('layout/header', ['title' => 'Jvent'])
        . view('event/index', $data)
        . view('layout/footer');
    }

    public function filter($kategori_tiket = null, $sort = null)
    {
        $keyword = $this->request->getVar('keyword');
        $query = $this->eventModel;

        // Filter berdasarkan keyword
        if ($keyword) {
            $query = $query->groupStart()
                        ->like('judul_event', $keyword)
                        ->orLike('lokasi_event', $keyword)
                        ->orLike('organizer', $keyword)
                        ->orLike('kategori_tiket', $keyword)
                    ->groupEnd();
        }

        // Filter berdasarkan kategori tiket
        if ($kategori_tiket && $kategori_tiket !== 'all') {
            $query = $query->where('kategori_tiket', $kategori_tiket);
        }

        // Urutkan berdasarkan tanggal event
        if ($sort && $sort === 'terbaru') {
            $query = $query->orderBy('tanggal_event', 'DESC');
        } elseif ($sort && $sort === 'terlama') {
            $query = $query->orderBy('tanggal_event', 'ASC');
        }

        $data = [
            'events' => $query->paginate(8, 'event_table'),
            'pager' => $this->eventModel->pager,
        ];

        return view('layout/header', ['title' => 'Filter Event', 'keyword' => $keyword])
            . view('event/filter', $data)
            . view('layout/footer');
    }

    public function create () {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $validation = \Config\Services::validation();
        // jika ada flashdata dari validasi sebelumnya
        if (session()->getFlashdata('validation')) {
            $validation = session()->getFlashdata('validation');
        }

        return view('event/create', [
            'title' => 'Form Tambah Data Event',
            'validation' => $validation,
        ]) . view('layout/footer');
    }

    public function save () {
        $session = session();
        if (!$session->has('id_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $kategori_tiket = $this->request->getVar('kategori_tiket');
        $harga_input = $this->request->getPost('harga_tiket');

        $rules = [
            'judul_event' => [
                'rules' => 'required|is_unique[event_table.judul_event]',
                'errors' => [
                    'required' => 'Judul event harus diisi',
                    'is_unique' => 'Event sudah terdaftar',
                ]
            ],
            'organizer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama penyelenggara harus diisi'
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
            'kategori_tiket' => [
                'rules' => 'required|in_list[gratis,berbayar]',
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
            ]
        ];

        // validasi tiket
        if ($kategori_tiket === 'berbayar') {
            $rules['harga_tiket'] = 'required|numeric';
        }
        
        // input tidak valid
        if (!$this->validate($rules)) { 
            // pesan kesalahan disimpan 
            $validation = \Config\Services::validation();
            
            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->back()->withInput()->with('validation', $validation);
        }        

        $harga_bersih = str_replace('.', '', $harga_input); // hilangkan titik ribuan
        $harga_tiket = ($kategori_tiket === 'gratis') ? 0 : (int) $harga_bersih;
        
        // ambil file gambar dari input
        $fileGambar = $this->request->getFile('gambar_event');
        
        // simpan gambar ke folder
        $namaGambar = $fileGambar->getRandomName(); // Buat nama random untuk gambar
        
        if (!$fileGambar->isValid()) {
            return redirect()->back()->withInput()->with('error', $fileGambar->getErrorString());
        }
        $fileGambar->move(FCPATH . 'uploads/images', $namaGambar);

        // slug dari input judul event 
        $slug = url_title($this->request->getVar('judul_event'), '-', true);

        // data diambil per key dan dikirim ke model
        $this->eventModel->save([
            'judul_event' => $this->request->getVar('judul_event'),
            'gambar_event' => $namaGambar,
            'organizer' => $this->request->getVar('organizer'),
            'slug' => $slug,
            'tanggal_event' => $this->request->getVar('tanggal_event'),
            'lokasi_event' => $this->request->getVar('lokasi_event'),
            'kategori_tiket' => $kategori_tiket,
            'harga_tiket' => $harga_tiket,
            'link_tiket' => $this->request->getVar('link_tiket'),
            'deskripsi_event' => $this->request->getVar('deskripsi_event'),
            'sponsor' => $this->request->getVar('sponsor'),
            'guest_star' => $this->request->getVar('guest_star'),
            'booth_list' => $this->request->getVar('booth_list'),
            'id_admin' => $session->get('id_admin'),
        ]);

        // flash data
        $session->setFlashdata('pesan', 'Event berhasil ditambahkan...');

        return redirect()->to('/dashboard');
    }

    public function detail($slug)
    {
        // Ambil daftar booth dari model
        $boothList = $this->boothListModel->findAll();
        
        // Cek apakah event dengan slug tersebut ada
        if (!$this->eventModel->getEvent($slug)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Event ' . $slug . ' tidak ditemukan');
        }

        // Ambil daftar booth yang terkait dengan event dicari
        $boothList = array_filter($boothList, function($booth) use ($slug) {
            return $booth['id_event'] === $this->eventModel->getEvent($slug)['id_event'];
        });

        // Ambil data event berdasarkan slug
        $events = $this->eventModel->getEvent($slug);

        // Simpan data event dan booth ke dalam array
        $data = [
            'events' => $events,
            'booths' => $boothList,
        ];

        // cek jika event tidak ada
        if (empty($data['events']) && empty($data['booths'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Event ' . $slug . ' tidak ditemukan');
        } 

        // tampilkan view detail event
        return view('layout/header', ['title' => $slug])
        . view('event/detail', $data)
        . view('layout/footer');
    }

    public function delete ($id) {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $event = $this->eventModel->find($id);
        if (!$event) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Event tidak ditemukan');
        }

        
        // Hapus gambar event jika ada
        if (!empty($event['gambar_event']) && file_exists(FCPATH . 'uploads/images/' . $event['gambar_event'])) {
            unlink(FCPATH . 'uploads/images/' . $event['gambar_event']);
        }

        $this->eventModel->delete($id);

        // flash data
        session()->setFlashdata('pesan', 'Event berhasil dihapus');
        return redirect()->to('/dashboard');
    }

    public function edit ($slug) {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'validation' => \Config\Services::validation(),
            'events' => $this->eventModel->getEvent($slug),
        ];

        // Cek apakah event dengan slug tersebut ada
        if (!$data['events']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Event dengan slug ' . $slug . ' tidak ditemukan');
        }

        return view('layout/header', ['title' => 'Update Event ' . $slug]) 
        . view('event/edit', $data)
        . view('layout/footer');
    }

    public function update ($id) {
        $session = session();
        if (!$session->has('id_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $kategori_tiket = $this->request->getPost('kategori_tiket');
        $harga_input = $this->request->getPost('harga_tiket');

        $rules= [
            'judul_event' => [
                'rules' => 'required|is_unique[event_table.judul_event, id_event, ' . $id . ']',
                'errors' => [
                    'required' => 'Judul event harus diisi',
                    'is_unique' => 'Event sudah terdaftar',
                ]
            ],
            'organizer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama penyelenggara harus diisi'
                ]
            ],
            'gambar_event' => [
                'rules' => 'permit_empty|max_size[gambar_event,500]|is_image[gambar_event]|mime_in[gambar_event,image/jpg,image/jpeg,image/png]', // Tambahkan permit_empty
                'errors' => [
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
            'kategori_tiket' => [
                'rules' => 'required|in_list[gratis,berbayar]',
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
            ]
        ];

        // validasi tiket
        if ($kategori_tiket === 'berbayar') {
            $rules['harga_tiket'] = 'required|numeric';
        }

        // validasi input
        if (!$this->validate($rules)) { // jika tidak valid
            // pesan kesalahan
            $validation = \Config\Services::validation();

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->to('/event/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }

        $harga_bersih = str_replace('.', '', $harga_input); // hilangkan titik ribuan
        $harga_tiket = ($kategori_tiket === 'gratis') ? 0 : (int) $harga_bersih;

        // ambil file gambar dari input
        $fileGambar = $this->request->getFile('gambar_event');
        $namaGambar = $this->request->getVar('gambar_lama');

        // jika ada gambar baru di-upload
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambarBaru = $fileGambar->getRandomName();
            $fileGambar->move(FCPATH . 'uploads/images', $namaGambarBaru);

            // Hapus gambar lama jika ada
            $gambarLama = $this->request->getVar('gambar_lama');
            if (!empty($gambarLama) && file_exists(FCPATH . 'uploads/images/' . $gambarLama)) {
                unlink(FCPATH . 'uploads/images/' . $gambarLama);
            }

            // Ganti nama gambar ke yang baru
            $namaGambar = $namaGambarBaru;
        }

        // slug dari input judul event 
        $slug = url_title($this->request->getVar('judul_event'), '-', true);

        // data diambil per key dan dikirim ke model
        $this->eventModel->save([
            'id_event' => $id,
            'judul_event' => $this->request->getVar('judul_event'),
            'gambar_event' => $namaGambar,
            'slug' => $slug,
            'organizer' => $this->request->getVar('organizer'),
            'tanggal_event' => $this->request->getVar('tanggal_event'),
            'lokasi_event' => $this->request->getVar('lokasi_event'),
            'harga_tiket' => $harga_tiket,
            'kategori_tiket' => $kategori_tiket,
            'link_tiket' => $this->request->getVar('link_tiket'),
            'deskripsi_event' => $this->request->getVar('deskripsi_event'),
            'sponsor' => $this->request->getVar('sponsor'),
            'guest_star' => $this->request->getVar('guest_star'),
            'booth_list' => $this->request->getVar('booth_list'),
            'id_admin' => $session->get('id_admin'),
        ]);

        // flash data
        $session->setFlashdata('pesan', 'Event berhasil diubah...');

        return redirect()->to('/dashboard');
    }
}
